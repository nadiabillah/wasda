<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['opd_setda', 'SEKRETARIAT DAERAH KABUPATEN SIDOARJO', 'setda@sidoarjokab.go.id'],
            ['opd_setwan', 'SEKRETARIAT DPRD', 'setwan@sidoarjokab.go.id'],
            ['opd_kpu', 'SEKRETARIAT KOMISI PEMILIHAN UMUM', 'kab_sidoarjo@kpu.go.id'],
            ['opd_inspektorat', 'INSPEKTORAT DAERAH', 'inspektorat@sidoarjokab.go.id'],
            ['opd_bkd', 'BADAN KEPEGAWAIAN DAERAH', 'fo.bkdsda@gmail.com'],
            ['opd_bakesbangpol', 'BADAN KESATUAN BANGSA DAN POLITIK', 'bakesbangpolsidoarjo@gmail.com'],
            ['opd_bappeda', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', 'bappedasidoarjo@gmail.com'],
            ['opd_bpbd', 'BADAN PENANGGULANGAN BENCANA DAERAH', 'bpbdsidoarjo@gmail.com'],
            ['opd_bppd', 'BADAN PELAYANAN PAJAK DAERAH', 'pajakdaerah@sidoarjokab.go.id'],
            ['opd_bpkad', 'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH', 'bpkad@sidoarjokab.go.id'],
            ['opd_dlhk', 'DINAS LINGKUNGAN HIDUP DAN KEBERSIHAN', 'dlhk.sidoarjokab@gmail.com'],
            ['opd_perikanan', 'DINAS PERIKANAN', 'perikanan@sidoarjokab.go.id'],
            ['opd_dukcapil', 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', 'mpp@sidoarjokab.go.id'],
            ['opd_dinkes', 'DINAS KESEHATAN', 'dinkes@sidoarjokab.go.id'],
            ['opd_kopum', 'DINAS KOPERASI DAN USAHA MIKRO', 'diskopum@sidoarjokab.go.id'],
            ['opd_pubm', 'DINAS PEKERJAAN UMUM BINA MARGA DAN SUMBER DAYA AIR', 'pubmsda@gmail.com'],
            ['opd_perkim', 'DINAS PERUMAHAN, PERMUKIMAN, CIPTA KARYA DAN TATA RUANG', 'mpp@sidoarjokab.go.id'],
            ['opd_kominfo', 'DINAS KOMUNIKASI DAN INFORMATIKA', 'diskominfo@sidoarjokab.go.id'],
            ['opd_dispora', 'DINAS KEPEMUDAAN, OLAHRAGA DAN PARIWISATA', 'disporaparsda@gmail.com'],
            ['opd_disdik', 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'pendidikan@sidoarjokab.go.id'],
            ['opd_dishub', 'DINAS PERHUBUNGAN', 'dishub@sidoarjokab.go.id'],
            ['opd_dispanperta', 'DINAS PANGAN DAN PERTANIAN', 'tikdiskominfo@sidoarjokab.go.id'],
            ['opd_disnaker', 'DINAS TENAGA KERJA', 'disnaker@sidoarjokab.go.id'],
            ['opd_rsud', 'RSUD SIDOARJO', 'rsudrtnotopurosda@gmail.com'],
            ['opd_satpolpp', 'SATUAN POLISI PAMONG PRAJA', 'satpolppsda50@gmail.com'],
            ['opd_pmd', 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 'dinpmd@sidoarjokab.go.id'],
            ['opd_dp3akb', 'DINAS PPPA DAN KB', 'dp3akb@sidoarjokab.go.id'],
            ['opd_rsudbarat', 'RSUD SIDOARJO BARAT', 'rsudsidoarjobarat@sidoarjokab.go.id'],
            ['opd_balongbendo', 'KECAMATAN BALONGBENDO', 'balongbendo@sidoarjokab.go.id'],
            ['opd_buduran', 'KECAMATAN BUDURAN', 'buduran@sidoarjokab.go.id'],
            ['opd_candi', 'KECAMATAN CANDI', 'candi@sidoarjokab.go.id'],
            ['opd_gedangan', 'KECAMATAN GEDANGAN', 'gedangan@sidoarjokab.go.id'],
            ['opd_jabon', 'KECAMATAN JABON', 'jabon@sidoarjokab.go.id'],
            ['opd_krembung', 'KECAMATAN KREMBUNG', 'krembung@sidoarjokab.go.id'],
            ['opd_krian', 'KECAMATAN KRIAN', 'krian@sidoarjokab.go.id'],
            ['opd_porong', 'KECAMATAN PORONG', 'porong@sidoarjokab.go.id'],
            ['opd_prambon', 'KECAMATAN PRAMBON', 'prambon@sidoarjokab.go.id'],
            ['opd_sedati', 'KECAMATAN SEDATI', 'sedati@sidoarjokab.go.id'],
            ['opd_sidoarjo', 'KECAMATAN SIDOARJO', 'sidoarjokota@sidoarjokab.go.id'],
            ['opd_sukodono', 'KECAMATAN SUKODONO', 'sukodono@sidoarjokab.go.id'],
            ['opd_taman', 'KECAMATAN TAMAN', 'taman@sidoarjokab.go.id'],
            ['opd_tanggulangin', 'KECAMATAN TANGGULANGIN', 'tanggulangin@sidoarjokab.go.id'],
            ['opd_tarik', 'KECAMATAN TARIK', 'tarik@sidoarjokab.go.id'],
            ['opd_tulangan', 'KECAMATAN TULANGAN', 'tulangankec@gmail.com'],
            ['opd_waru', 'KECAMATAN WARU', 'waru@sidoarjokab.go.id'],
            ['opd_wonoayu', 'KECAMATAN WONOAYU', 'wonoayu@sidoarjokab.go.id'],
            ['opd_dpmptsp', 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'perijinan_sidoarjokab@yahoo.co.id'],
            ['opd_disperindag', 'DINAS PERINDUSTRIAN DAN PERDAGANGAN', 'disperindogsidoarjo@gmail.com'],
            ['opd_perpus', 'DINAS PERPUSTAKAAN DAN KEARSIPAN', 'e-perpus@sidoarjokab.go.id'],
            ['opd_dinsos', 'DINAS SOSIAL', 'dinsos.sidoarjo@gmail.com'],
        ];

        $phoneIndex = 100; // supaya unik

        foreach ($users as $user) {
            $username = $user[0];
            $name = $user[1];
            $email = $user[2];
            $password = Str::random(8);
            $phoneRaw = '08123456' . str_pad($phoneIndex++, 4, '0', STR_PAD_LEFT);

            // Normalisasi ke format +62
            $phone = preg_replace('/[^0-9]/', '', $phoneRaw);
            if (strpos($phone, '62') !== 0) {
                $phone = '62' . ltrim($phone, '0');
            }
            $phone = '+' . $phone;

            User::create([
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'plain_password' => $password,
            ]);
        }
    }
}