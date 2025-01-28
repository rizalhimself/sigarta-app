<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara</title>
</head>
<body>
<h1>Dashboard Bendahara</h1>
<p>Halo, {{ auth()->user()->username }}! Anda login sebagai Bendahara.</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
</body>
</html>
