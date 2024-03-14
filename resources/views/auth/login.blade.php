<!-- resources/views/instagram/login.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login Instagram</title>
</head>
<body>
    <h1>Login Instagram</h1>

    <!-- Tambahkan pesan kesalahan jika diperlukan -->
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Tampilkan pesan sukses jika ada -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Form untuk mengisikan Instagram username dan password -->
    <form method="POST" action="{{ route('instagram.login') }}">
        @csrf

        <div>
            <label for="instagram_username">Instagram Username</label>
            <input id="instagram_username" type="text" name="instagram_username" required>
        </div>

        <div>
            <label for="instagram_password">Instagram Password</label>
            <input id="instagram_password" type="password" name="instagram_password" required>
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>
