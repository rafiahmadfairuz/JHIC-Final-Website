<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-4 mb-6 gap-2">
            <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
            <span class="text-sm text-gray-500">#{{ $order->id }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-8">
            <div class="space-y-3">
                <p>
                    <span class="font-semibold">Tanggal:</span>
                    {{ $order->created_at->format('d M Y H:i') }}
                </p>
                <p>
                    <span class="font-semibold">Status:</span>
                    <span
                        class="px-4 py-1 rounded-full text-sm font-medium shadow-sm
            @if ($order->status == 'pending') bg-yellow-100 text-yellow-700 border border-yellow-300
            @elseif($order->status == 'selesai') bg-green-100 text-green-700 border border-green-300
            @else bg-red-100 text-red-700 border border-red-300 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
            <div class="space-y-2">
                <p><span class="font-semibold">Nama Pembeli:</span> {{ $order->pembeli->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $order->pembeli->email }}</p>
                <p><span class="font-semibold">No. HP:</span> {{ $order->pembeli->no_hp ?? '-' }}</p>
            </div>
        </div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Produk Dipesan</h2>
        <div class="space-y-4">
            @foreach ($order->items as $item)
                <div
                    class="flex flex-col md:flex-row md:items-center gap-4 bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}"
                        class="w-24 h-24 rounded-lg object-cover border mx-auto md:mx-0">
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-base font-semibold text-gray-800">{{ $item->produk->nama }}</h2>
                        <p class="text-gray-500 text-sm">Qty: {{ $item->qty }}</p>
                        <p class="text-gray-700 font-medium">
                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800">
                            Rp {{ number_format($item->qty * $item->produk->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="bg-gray-100 p-5 rounded-xl mt-8">
            <div class="flex justify-between items-center text-lg font-bold text-gray-800">
                <span>Total</span>
                <span class="text-green-600 text-2xl">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('landing.kwu.index') }}"
                class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>

</body>

</html>
