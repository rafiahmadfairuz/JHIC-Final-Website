<x-baseLMS>
    <div id="course-tugas" class="container mx-auto px-4 py-8 max-w-7xl">
        @if ($sudahDikerjakan)
            {{-- ==================== MODE REVIEW ==================== --}}
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Hasil Tugas: {{ $tugas->nama_tugas }}</h2>

                @php
                    $totalSoal = $tugas->soals->count();
                    $benar = \App\Models\JawabanSiswa::where('siswa_id', $user->id)
                        ->whereIn('soal_id', $tugas->soals->pluck('id'))
                        ->where('nilai', 1)
                        ->count();
                    $nilai = $totalSoal > 0 ? round(($benar / $totalSoal) * 100) : 0;
                @endphp


                <div class="text-center mb-8">
                    <div class="text-6xl font-bold text-green-600 mb-2">{{ $nilai }}%</div>
                    <div class="text-lg text-gray-600">Benar {{ $benar }} / {{ $totalSoal }} Soal</div>
                </div>

                @foreach ($tugas->soals as $index => $soal)
                    @php
                        $hasil = $hasilDetail[$soal->id] ?? null;
                    @endphp
                    <div class="mb-6 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Soal {{ $index + 1 }} dari {{ $totalSoal }}
                        </h3>
                        <p class="text-gray-800 mb-4">{{ $soal->pertanyaan }}</p>

                        @foreach (['a', 'b', 'c', 'd'] as $opsi)
                            @php
                                $opsiText = $soal['opsi_' . $opsi];
                                $huruf = strtoupper($opsi);
                                $isBenar = $hasil && $hasil['jawaban_benar'] === $huruf;
                                $isUser = $hasil && $hasil['jawaban_user'] === $huruf;
                                $warna = $isBenar
                                    ? 'bg-green-500 text-white'
                                    : ($isUser && !$isBenar
                                        ? 'bg-red-500 text-white'
                                        : 'bg-white');
                            @endphp
                            @if ($opsiText)
                                <div class="p-3 border rounded-lg mb-2 {{ $warna }}">
                                    {{ $huruf }}. {{ $opsiText }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

            </div>
        @else
            {{-- ==================== MODE KERJAKAN ==================== --}}
            <div id="result-section" class="hidden bg-white rounded-xl shadow-lg p-8 text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Hasil Penilaian</h2>
                <div class="text-6xl font-bold text-green-600 mb-2" id="final-score"></div>
                <p class="text-lg text-gray-600 mb-4" id="score-desc"></p>
                <a href="{{ route('lms.kursus.show', $tugas->kursus_id) }}"
                    class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    Kembali ke Kursus
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                <div class="lg:col-span-7 bg-white rounded-xl shadow-lg p-8 relative" id="quiz-section">
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('lms.kursus.show', $tugas->kursus_id) }}"
                            class="flex items-center text-red-600 hover:text-red-700 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kursus
                        </a>
                        <div class="text-sm text-gray-500">{{ $tugas->nama_tugas }}</div>
                    </div>

                    <div id="quiz-container" class="mt-6">
                        @foreach ($tugas->soals as $index => $soal)
                            <div class="soal-item {{ $index === 0 ? '' : 'hidden' }}"
                                data-soal-id="{{ $soal->id }}">
                                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            Soal {{ $index + 1 }} dari {{ count($tugas->soals) }}
                                        </h3>
                                    </div>

                                    <p class="text-gray-800 mb-6 text-base leading-relaxed">
                                        {{ $soal->pertanyaan }}
                                    </p>

                                    <div class="space-y-3 mb-6">
                                        @foreach (['a', 'b', 'c', 'd'] as $opsi)
                                            @php $opsiText = $soal['opsi_'.$opsi]; @endphp
                                            @if ($opsiText)
                                                <button data-index="{{ $index }}"
                                                    data-opsi="{{ strtoupper($opsi) }}"
                                                    class="option-btn w-full text-left p-3 border border-gray-300 rounded-lg transition-colors">
                                                    {{ strtoupper($opsi) }}. {{ $opsiText }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <button
                                        class="prev-btn px-4 py-2 text-gray-600 hover:text-gray-800 {{ $index === 0 ? 'invisible' : '' }}">
                                        ← Soal Sebelumnya
                                    </button>

                                    @if ($index === count($tugas->soals) - 1)
                                        <button id="submit-btn"
                                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            Kumpulkan Jawaban
                                        </button>
                                    @else
                                        <button
                                            class="next-btn px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            Soal Berikutnya →
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-3 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h4 class="font-semibold text-gray-800 mb-4">
                        Soal: <span class="text-gray-600">{{ $tugas->nama_tugas }}</span>
                    </h4>
                    <hr class="mb-5">
                    <div class="overflow-y-auto pr-1" style="max-height: 75vh;">
                        <div class="grid grid-cols-5 gap-3">
                            @foreach ($tugas->soals as $index => $soal)
                                <button data-index="{{ $index }}"
                                    class="num-btn w-10 h-10 flex items-center justify-center rounded-md border text-sm font-semibold
                                    bg-gray-100 border-gray-300 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-150">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const soals = document.querySelectorAll('.soal-item');
                    const numBtns = document.querySelectorAll('.num-btn');
                    const optionBtns = document.querySelectorAll('.option-btn');
                    let current = 0;
                    const storageKey = 'quiz_tugas_{{ $tugas->id }}';
                    let answers = JSON.parse(localStorage.getItem(storageKey)) || {};
                    let isSubmitted = false;

                    function showSoal(index) {
                        soals.forEach((s, i) => s.classList.toggle('hidden', i !== index));
                        current = index;
                    }

                    function saveAnswer(index, opsi) {
                        answers[index] = opsi;
                        localStorage.setItem(storageKey, JSON.stringify(answers));
                        numBtns[index].classList.remove('bg-gray-100', 'text-gray-700');
                        numBtns[index].classList.add('bg-green-500', 'text-white');
                        document.querySelectorAll(`.option-btn[data-index='${index}']`).forEach(b => b.classList.remove(
                            'bg-green-500', 'text-white'));
                        const selected = document.querySelector(`.option-btn[data-index='${index}'][data-opsi='${opsi}']`);
                        if (selected) selected.classList.add('bg-green-500', 'text-white');
                    }

                    optionBtns.forEach(btn => {
                        btn.addEventListener('click', () => {
                            const index = parseInt(btn.dataset.index);
                            const opsi = btn.dataset.opsi;
                            saveAnswer(index, opsi);
                        });
                    });

                    document.querySelectorAll('.next-btn').forEach(btn => btn.addEventListener('click', () => {
                        if (current < soals.length - 1) showSoal(current + 1);
                    }));

                    document.querySelectorAll('.prev-btn').forEach(btn => btn.addEventListener('click', () => {
                        if (current > 0) showSoal(current - 1);
                    }));

                    numBtns.forEach((btn, i) => btn.addEventListener('click', () => showSoal(i)));

                    showSoal(0);

                    document.getElementById('submit-btn')?.addEventListener('click', async () => {
                        if (Object.keys(answers).length < soals.length) {
                            if (!confirm("Masih ada soal yang belum dijawab. Tetap kirim?")) return;
                        }

                        isSubmitted = true;
                        const payload = [];
                        soals.forEach((s, i) => {
                            const soalId = s.dataset.soalId;
                            const jawaban = answers[i] || null;
                            payload.push({
                                soal_id: soalId,
                                jawaban
                            });
                        });

                        try {
                            const res = await fetch("{{ route('lms.tugas.submit', $tugas->id) }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    jawaban: payload
                                })
                            });
                            const data = await res.json();
                            if (data.success) {
                                document.getElementById('result-section').classList.remove('hidden');
                                document.getElementById('final-score').innerText = data.nilai + '%';
                                document.getElementById('score-desc').innerText =
                                    `Benar ${data.benar} / ${data.total} soal`;

                                soals.forEach(s => s.classList.remove('hidden'));
                                document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);

                                data.hasil.forEach(h => {
                                    const index = Array.from(soals).findIndex(s => s.dataset.soalId == h
                                        .soal_id);
                                    document.querySelectorAll(`.option-btn[data-index='${index}']`)
                                        .forEach(b => {
                                            const opsi = b.dataset.opsi;
                                            if (opsi === h.jawaban_benar) {
                                                b.classList.add('bg-green-500', 'text-white');
                                            }
                                            if (opsi === h.jawaban_user && h.status === 'salah') {
                                                b.classList.add('bg-red-500', 'text-white');
                                            }
                                        });
                                });

                                document.getElementById('submit-btn').classList.add('hidden');
                                localStorage.removeItem(storageKey);
                            } else {
                                alert(data.message || 'Gagal mengirim jawaban.');
                            }
                        } catch (e) {
                            alert('Terjadi kesalahan saat mengirim jawaban.');
                            console.error(e);
                        }
                    });

                    window.addEventListener('beforeunload', e => {
                        if (!isSubmitted && Object.keys(answers).length > 0) {
                            e.preventDefault();
                            e.returnValue = "Jawaban Anda belum disimpan.";
                        }
                    });
                });
            </script>
        @endif
    </div>
</x-baseLMS>
