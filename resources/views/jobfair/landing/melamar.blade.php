<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Melamar Pekerjaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-24 mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Formulir Pendaftaran Pekerjaan</h2>
        </div>
        <form action="{{ route('jobfair.storemelamar', $pekerjaan->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <div class="bg-gray-100 p-4 rounded-md">
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Syarat Berkas yang Dibutuhkan</h3>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach (explode(',', $pekerjaan->syarat) as $syarat)
                        <li>{{ $syarat }}</li>
                    @endforeach
                </ul>
            </div>
            <div id="fileInputs">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Berkas 1
                        ({{ explode(',', $pekerjaan->syarat)[0] ?? 'File' }})</label>
                    <input type="file" name="berkas[]"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>
            <button type="button" onclick="addFileInput()"
                class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                + Tambah Berkas
            </button>
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <script>
        let fileCount = 1;
        const syaratList = @json(explode(',', $pekerjaan->syarat));

        function addFileInput() {
            fileCount++;
            const container = document.getElementById('fileInputs');

            const labelText = syaratList[fileCount - 1] ?? 'File';

            const div = document.createElement('div');
            div.classList.add('mb-4');
            div.innerHTML = `
        <label class="block text-gray-700 mb-1">Berkas ${fileCount} (${labelText})</label>
        <input type="file" name="berkas[]" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400" required>
    `;
            container.appendChild(div);
        }
    </script>

</body>

</html>
