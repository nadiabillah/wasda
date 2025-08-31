<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
</head>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<body>
    <div class="container">
        <header>
            <div class="logo-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h1>Database WhatsApp Sidoarjo</h1>
            </div>
        </header>

        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <label for="title">Tulis Pesan</label>
                </div>

                <div class="user-info-card">
                    <div style="flex:1;">
                        <div class="user-info-label">Organisasi Perangkat Daerah</div>
                        <div class="user-info-value">{{ Auth::user()->name }}</div>
                    </div>
                    <div style="flex:1;">
                        <div class="user-info-label">Email</div>
                        <div class="user-info-email">{{ Auth::user()->email }}</div>
                    </div>
                    <input type="hidden" name="opd" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                </div>

                <div class="form-group">
                    <label for="opd-phone-search">Nomor Tujuan</label>
                    <input type="text" id="opd-phone-search" placeholder="Cari nama atau nomor" autocomplete="off">

                    <div id="selected-opd-summary" class="selected-opd-summary"></div>
                    <div id="opd-phone-checkbox-list" class="checkbox-list hidden">
                        <label class="checkbox-item">
                            <input type="checkbox" id="custom-phone-toggle">
                            <span>Nomor Custom</span>
                        </label>

                    <div class="checkbox-section-title">
                        <label class="checkbox-item">
                            <input type="checkbox" id="select-all-opd">
                            <span>Pilih Semua OPD</span>
                        </label>
                    </div>

                    <div class="checkbox-section-title">
                        <label class="checkbox-item">
                            <input type="checkbox" id="select-all-asn">
                            <span>Pilih Semua ASN</span>
                        </label>
                    </div>
                    
                    @foreach($opdList as $opd)
                        <label class="checkbox-item">
                            <input type="checkbox" name="opd_phone[]" value="{{ $opd->phone }}">
                            <span>{{ $opd->name }} ({{ $opd->phone }})</span>
                        </label>
                    @endforeach

                    @foreach($asnList as $asn)
                        <label class="checkbox-item">
                            <input type="checkbox" name="asn_phone[]" value="{{ $asn->phone }}">
                            <span>{{ $asn->name }} ({{ $asn->phone }})</span>
                        </label>
                    @endforeach
                    </div>

                    <div id="custom-phone-group" class="hidden">
                        <label for="custom-phone">Nomor Custom (bisa lebih dari satu, pisahkan dengan koma)</label>
                        <input type="text" id="custom-phone" name="custom_phone" placeholder="81234567890,81234567891" autocomplete="off">
                        <small>Masukkan nomor tanpa awalan 0, contoh: 81234567890,81234567891</small>
                    </div>

                    <input type="hidden" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="message-text">Tulis pesan Anda</label>
                    <textarea id="message-text" name="message" rows="5" autocomplete="off"></textarea>
                    <div id="wa-preview-label" style="margin-top:10px; color:#888;">Preview hasil format WhatsApp:</div>
                    <pre id="wa-preview" style="background:#f7fafc; border:1px solid #e0e7ef; border-radius:8px; padding:1rem; min-height:60px; margin-top:4px; font-family:inherit; white-space:pre-wrap;"></pre>
                </div>

                <div class="form-group">
                    <label for="file-upload">Lampirkan Gambar atau Video</label>
                    <input type="file" id="file-upload" name="media" accept="image/*,video/*">
                </div>

                <div class="schedule-container">
                    <label for="schedule-select">Jenis Pengiriman</label>
                    <select id="schedule-select" name="send_option">
                        <option value="instant">Kirim langsung</option>
                        <option value="schedule">Schedule</option>
                    </select>
                </div>

                <div class="schedule-options hidden">
                    <label for="schedule-date">Tanggal Kirim</label>
                    <input type="date" id="schedule-date" name="schedule_date" min="{{ date('Y-m-d') }}">
                    <label for="schedule-time">Jam Kirim</label>
                    <input type="time" id="schedule-time" name="schedule_time">
                </div>

                <button type="submit" class="save-button">Kirim</button>
                <a href="{{ route('dashboard') }}" class="btn-back-dashboard">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>

    <footer style="text-align:center; margin:2rem 0; color:#888;">
        &copy; {{ date('Y') }} Database WhatsApp Sidoarjo. Dikembangkan oleh Diskominfo Kabupaten Sidoarjo.
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/messages.js') }}"></script>
</body>
</html>