<x-jobfair.dashboard.app>
    <main class="p-6 space-y-8">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
            <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Perusahaan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPerusahaan }}</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Pekerjaan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPekerjaan }}</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transform transition">
                <div>
                    <p class="text-gray-600">Total Lamaran</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalLamaran }}</p>
                </div>
            </div>

        </div>
    </main>
</x-jobfair.dashboard.app>
