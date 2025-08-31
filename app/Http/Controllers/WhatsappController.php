<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Whatsapp;
use App\Models\User;
use App\Models\Asn;
use Illuminate\Support\Facades\Auth;

class WhatsAppController extends Controller
{
    // Dashboard filter
    public function index(Request $request)
    {
        $users = User::all();
        $query = Whatsapp::with('user')->latest();

        if ($request->filled('user_id')) {
            $query->where('opd_id', $request->input('user_id'));
        }
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        $messages = $query->paginate(10);

        return view('layout.dashboard', compact('messages', 'users'));
    }

    // Tampilkan form pesan
    public function create()
    {
        $opdList = User::whereNotNull('phone')->get();
        $asnList = Asn::all();
        return view('layout.messages', compact('opdList', 'asnList'));
    }

    // Simpan pesan baru ke banyak nomor
    public function store(Request $request)
    {
        $request->validate([
            'opd' => 'required',
            'message' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'url_app' => 'nullable',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10000',
            'schedule_date' => 'nullable|date',
            'schedule_time' => 'nullable|date_format:H:i',
        ]);

        if ($request->input('send_option') === 'schedule') {
            $schedule = $request->input('schedule_date') . ' ' . $request->input('schedule_time');
            if (strtotime($schedule) < strtotime(now())) {
                return back()->withInput()->withErrors(['schedule_date' => 'Tanggal dan waktu kirim tidak boleh lewat dari waktu sekarang.']);
            }
        }

        $absolutePath = null;
        if ($request->hasFile('media')) {
            $originalName = $request->file('media')->getClientOriginalName();
            $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
            $relativePath = 'uploads/' . $uniqueName;
            $request->file('media')->storeAs('uploads', $uniqueName, 'public');
            $absolutePath = storage_path('app/public/' . $relativePath);
        }

        $opdId = $request->input('opd');
        $user = User::find($opdId);
        $opdName = $user ? $user->name : 'OPD tidak diketahui';
        $footer = "\n\nPesan ini dikirimkan oleh " . $opdName . " melalui aplikasi Database WhatsApp Sidoarjo.";

        $message = $this->markdownToWhatsapp($request->input('message')) . $footer;

        // Ambil semua nomor dari input hidden 'phone', pisahkan dengan koma
        $phones = explode(',', $request->input('phone'));
        $phones = array_filter(array_map('trim', $phones)); // bersihkan spasi dan kosong

        $scheduleValue = $request->input('send_option') === 'schedule'
            ? date("Y-m-d H:i:s", strtotime($request->input('schedule_date') . ' ' . $request->input('schedule_time')))
            : now();

        foreach ($phones as $phone) {
            // Normalisasi nomor WhatsApp Indonesia
            $phoneNum = preg_replace('/[^0-9]/', '', $phone);
            if (strpos($phoneNum, '62') !== 0) {
                $phoneNum = '62' . ltrim($phoneNum, '0');
            }
            $phoneNum = '+' . $phoneNum;

            Whatsapp::create([
                'opd_id' => $opdId,
                'url_app' => $request->input('url_app'),
                'phone' => $phoneNum,
                'email' => $request->input('email'),
                'message' => $message,
                'imagepath' => $absolutePath,
                'schedule' => $scheduleValue,
                'server' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil disimpan!');
    }

    private function markdownToWhatsapp($text)
    {
        // 1. Bold + Italic: ***text*** → placeholder [BI]...[/BI]
        $text = preg_replace('/(\*\*\*|___)(.+?)\1/s', '[BI]$2[/BI]', $text);

        // 2. Bold: **text** atau __text__ → placeholder [B]...[/B]
        $text = preg_replace('/\*\*(.+?)\*\*/s', '[B]$1[/B]', $text);
        $text = preg_replace('/\_\_(.+?)\_\_/s', '[B]$1[/B]', $text);

        // 3. Italic: *text* atau _text_ → _text_ (langsung WhatsApp format)
        $text = preg_replace('/(?<!\*)\*(?!\*)([^*]+)(?<!\*)\*(?!\*)/s', '_$1_', $text);
        $text = preg_replace('/(?<!_)_(?!_)([^_]+)(?<!_)_(?!_)/s', '_$1_', $text);

        // 4. Strikethrough: ~~text~~ → ~text~
        $text = preg_replace('/~~(.+?)~~/s', '~$1~', $text);

        // 5. Bulleted list
        $text = preg_replace('/^(\s*)[-*]\s+/m', "$1• ", $text);

        // 6. Blockquote
        $text = preg_replace('/^> ?(.*)$/m', "```$1```", $text);

        // 7. Hapus heading
        $text = preg_replace('/^#{1,6}\s*/m', '', $text);

        // 8. Hapus inline code
        $text = preg_replace('/```(.*?)```/s', '$1', $text);
        $text = preg_replace('/`(.+?)`/', '$1', $text);

        // 🔄 Terakhir: kembalikan placeholder ke format WhatsApp
        $text = str_replace(['[BI]', '[/BI]'], ['*_', '_*'], $text); // *_..._*
        $text = str_replace(['[B]', '[/B]'], ['*', '*'], $text);     // *...*

        return $text;
    }
}