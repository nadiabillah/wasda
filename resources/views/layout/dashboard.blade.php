<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="dashboard-page">
    <header>
        <div class="logo-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h1>Database WhatsApp Sidoarjo</h1>
        </div>
        <div class="profile-section">
            <img src="{{ asset('images/profilee.png') }}" alt="Profil" id="profile-icon">
        </div>
    </header>

    <main>
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="dashboard-controls">
                <select name="user_id" id="filter-user">
                    <option value="">Pilih Organisasi Perangkat Daerah</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="phone" id="filter-phone" placeholder="Cari nomor telepon" value="{{ request('phone') }}">
                <button type="submit" id="filter-btn">Tampilkan</button>
            </div>
        </form>

        <div class="dashboard-table">
            <table>
                <thead>
                    <tr>
                        <th>Organisasi Perangkat Daerah</th>
                        <th>Nomor Telpon</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Schedule</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr>
                            <td>{{ $msg->user?->name ?? '-' }}</td>
                            <td>{{ $msg->phone ?? '-' }}</td>
                            <td>{{ $msg->email ?? '-' }}</td>
                            <td>{!! nl2br(e($msg->message)) !!}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($msg->schedule)->format('H:i') }}<br>
                                {{ \Carbon\Carbon::parse($msg->schedule)->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                @if($msg->sent == 1)
                                    <span class="badge-terkirim">Terkirim</span>
                                @else
                                    <span class="badge-belum">Belum Terkirim</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pesan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            @if($messages instanceof \Illuminate\Pagination\LengthAwarePaginator || $messages instanceof \Illuminate\Pagination\Paginator)
                {{ $messages->links('pagination::bootstrap-4') }}
            @endif
        </div>

        <div class="dashboard-actions">
            <a href="{{ route('messages') }}" class="btn-go">Buat Pesan Baru</a>
        </div>
    </main>

    <div id="profile-modal" class="modal hidden">
        <div class="modal-content profile-modal-content">
            <button class="close-button" id="close-profile-modal">❌</button>
            <div class="profile-modal-body">
                <img src="{{ asset('images/profilee.png') }}" alt="Profil" class="profile-modal-img">
                <div class="profile-modal-text">
                    Anda login sebagai <b>{{ Auth::user()?->name ?? Auth::user()?->username ?? '-' }}</b>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
