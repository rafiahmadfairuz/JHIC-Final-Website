<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email hasil lamaran</title>
</head>

<body>
    <h2>Halo {{ $nama }}</h2>

    <p>Status lamaran kamu untuk posisi <strong>{{ $pekerjaan }}</strong> telah diperbarui menjadi:
        <strong>{{ strtoupper($status) }}</strong></p>

    @if ($status === 'diterima')
        <p>Selamat! Silakan cek informasi lebih lanjut dari perusahaan.</p>
    @else
        <p>Terima kasih telah melamar. Jangan berkecil hati, terus coba kesempatan lain.</p>
    @endif

</body>

</html>
