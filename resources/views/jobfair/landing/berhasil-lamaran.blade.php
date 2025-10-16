<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lamaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-gray-50">
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg text-center">
        <div class="text-green-600 text-5xl mb-4">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Lamaran Berhasil Dikirim!</h1>
        <p class="text-gray-600 mb-6">
            Terima kasih sudah melamar pekerjaan. Tim kami akan segera memproses lamaran Anda.
        </p>
        <a href="{{ route('jobfair.landing') }}"
            class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
            Kembali ke Beranda
        </a>
    </div>
</body>

</html>
