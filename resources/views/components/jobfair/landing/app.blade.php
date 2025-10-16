<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jobfair</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-gradient-to-b from-blue-50 to-[#f4f6fb]">
    <x-jobfair.landing.nav />
    <div>
        {{ $slot }}
    </div>
    <x-jobfair.landing.footer />
</body>

</html>
