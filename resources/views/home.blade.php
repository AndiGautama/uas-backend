<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Selamat Datang di Halaman Home</h1>

    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
        @csrf
        <button type="submit" onclick="return confirmLogout(event)">Logout</button>
    </form>

    <script>
        function confirmLogout(event) {
            if (!confirm('Apakah Anda yakin ingin logout?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
