<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Indikator Ketenagakerjaan Per Provinsi 2024</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-header />

<body class="bg-gray-100 min-h-screen antialiased">

    
    <x-button-to-top />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-5">

        {{-- ── Page Header ── --}}
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                Data Indikator Ketenagakerjaan 2024
            </h1>
            <p class="text-sm text-gray-500 mt-1 leading-relaxed max-w-2xl">
                Data per provinsi meliputi Tingkat Pengangguran Terbuka (TPT), Lowongan Kerja Terdaftar,
                Rata-rata Lama Sekolah (RLS), Indeks Pembangunan Manusia (IPM), dan
                Tingkat Partisipasi Angkatan Kerja (TPAK).
            </p>
        </div>

        {{-- ── Summary Cards ── --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-3">

            {{-- Total Provinsi --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Total provinsi</p>
                    <p class="text-2xl font-semibold text-blue-600 tabular-nums">{{ $totalProvinsi }}</p>
                </div>
                <span class="text-xs text-gray-400">Seluruh Indonesia</span>
            </div>

            {{-- Rata-rata TPT --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Rata-rata TPT nasional</p>
                    <p class="text-2xl font-semibold text-amber-500 tabular-nums">{{ number_format($avgTPT, 2) }}%</p>
                </div>
                <span class="self-start text-xs bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full font-medium">Nasional</span>
            </div>

            {{-- TPT Tertinggi --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">TPT tertinggi</p>
                    <p class="text-2xl font-semibold text-red-500 tabular-nums">{{ number_format($highest->tpt, 2) }}%</p>
                </div>
                <span class="text-xs text-gray-400 truncate">{{ $highest->provinsi }}</span>
            </div>

            {{-- TPT Terendah --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">TPT terendah</p>
                    <p class="text-2xl font-semibold text-green-500 tabular-nums">{{ number_format($lowest->tpt, 2) }}%</p>
                </div>
                <span class="text-xs text-gray-400 truncate">{{ $lowest->provinsi }}</span>
            </div>

        </div>

        {{-- ── Filter ── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 space-y-3">

            {{-- Search --}}
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input id="searchInput" type="text" placeholder="Cari provinsi..."
                    oninput="applyFilter()"
                    class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400">
            </div>

            {{-- Filter row --}}
            <div class="flex flex-col sm:flex-row gap-2">
                <select id="filterIndikator" onchange="applyFilter()"
                    class="flex-1 py-2 px-3 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-white">
                    <option value="">Semua indikator</option>
                    <option value="tpt">TPT</option>
                    <option value="ipm">IPM</option>
                    <option value="rls">RLS</option>
                    <option value="tpak">TPAK</option>
                    <option value="lowongan_kerja">Lowongan kerja</option>
                </select>

                <select id="filterKondisi" onchange="applyFilter()"
                    class="flex-1 py-2 px-3 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-white">
                    <option value="">Semua kondisi</option>
                    <option value="atas">Di atas rata-rata</option>
                    <option value="bawah">Di bawah rata-rata</option>
                </select>

                <button id="resetFilter" onclick="resetFilter()"
                    class="inline-flex items-center justify-center gap-1.5 py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </button>

                <a href="{{ route('export.excel') }}"
                    class="inline-flex items-center justify-center gap-1.5 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh data
                </a>
            </div>
        </div>

        {{-- ── Filter Status Badge ── --}}
        <div id="filterStatus" class="hidden">
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <span class="text-gray-500 text-xs font-medium">Filter aktif:</span>
                <span id="badgeSearch"
                    class="hidden items-center gap-1 bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span id="badgeSearchText"></span>
                </span>
                <span id="badgeIndikator"
                    class="hidden items-center gap-1 bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <span id="badgeIndikatorText"></span>
                </span>
                <span id="badgeKondisi"
                    class="hidden items-center gap-1 bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                    <span id="badgeKondisiText"></span>
                </span>
                <span id="filterCount" class="text-xs text-gray-400 ml-1"></span>
            </div>
        </div>

        {{-- ── Desktop Table ── --}}
        <div class="hidden sm:block bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Provinsi</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">TPT (%)</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lowongan</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">RLS</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">IPM</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">TPAK (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="tableBody">
                        @forelse($data as $row)
                        <tr class="data-row hover:bg-gray-50 transition-colors"
                            data-provinsi="{{ strtolower($row->provinsi) }}"
                            data-tpt="{{ $row->tpt }}"
                            data-ipm="{{ $row->ipm }}"
                            data-rls="{{ $row->rls }}"
                            data-tpak="{{ $row->tpak }}"
                            data-lowongan_kerja="{{ $row->lowongan_kerja }}">
                            <td class="px-5 py-3.5 font-medium text-gray-900 whitespace-nowrap">{{ $row->provinsi }}</td>
                            <td class="px-5 py-3.5 tabular-nums text-gray-600">{{ $row->tpt }}</td>
                            <td class="px-5 py-3.5 tabular-nums text-gray-600">{{ number_format($row->lowongan_kerja, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 tabular-nums text-gray-600">{{ $row->rls }}</td>
                            <td class="px-5 py-3.5 tabular-nums text-gray-600">{{ $row->ipm }}</td>
                            <td class="px-5 py-3.5 tabular-nums text-gray-600">{{ $row->tpak }}</td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-sm text-gray-400">
                                Tidak ada data tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Row count --}}
            <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400" id="rowCount">
                    Menampilkan {{ count($data) }} provinsi
                </p>
            </div>
        </div>

        {{-- ── Mobile Cards ── --}}
        <div class="sm:hidden space-y-3" id="mobileCards">
            @forelse($data as $row)
            <div class="mobile-card bg-white rounded-xl border border-gray-200 shadow-sm p-4"
                data-provinsi="{{ strtolower($row->provinsi) }}"
                data-tpt="{{ $row->tpt }}"
                data-ipm="{{ $row->ipm }}"
                data-rls="{{ $row->rls }}"
                data-tpak="{{ $row->tpak }}"
                data-lowongan_kerja="{{ $row->lowongan_kerja }}">

                <div class="flex items-start justify-between gap-2 mb-3">
                    <p class="text-sm font-semibold text-gray-900 leading-tight">{{ $row->provinsi }}</p>
                    @if($row->tpt > $avgTPT)
                        <span class="flex-shrink-0 inline-flex items-center gap-1 text-xs font-medium bg-red-50 text-green-600 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                            </svg>
                            Atas rata-rata
                        </span>
                    @else
                        <span class="flex-shrink-0 inline-flex items-center gap-1 text-xs font-medium bg-green-50 text-red-600 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            Bawah rata-rata
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-y-3 gap-x-2">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">TPT</p>
                        <p class="text-sm font-medium text-gray-800 tabular-nums">{{ $row->tpt }}%</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">RLS</p>
                        <p class="text-sm font-medium text-gray-800 tabular-nums">{{ $row->rls }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">IPM</p>
                        <p class="text-sm font-medium text-gray-800 tabular-nums">{{ $row->ipm }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">TPAK</p>
                        <p class="text-sm font-medium text-gray-800 tabular-nums">{{ $row->tpak }}%</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Lowongan</p>
                        <p class="text-sm font-medium text-gray-800 tabular-nums">{{ number_format($row->lowongan_kerja, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-sm text-gray-400">
                Tidak ada data tersedia.
            </div>
            @endforelse
        </div>

        {{-- ── No results message ── --}}
        <div id="noResults" class="hidden bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-10 text-center">
            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-gray-400">Tidak ada provinsi yang cocok dengan filter ini.</p>
            <button onclick="resetFilter()" class="mt-2 text-sm text-blue-600 hover:underline">Reset filter</button>
        </div>

    </main>


    {{-- ── Scripts ── --}}
    <script>
        window.dataAverages = {
            tpt:            <?= json_encode($avgTPT ?? 0) ?>,
            ipm:            <?= json_encode($avgIPM ?? 0) ?>,
            rls:            <?= json_encode($avgRLS ?? 0) ?>,
            tpak:           <?= json_encode($avgTPAK ?? 0) ?>,
            lowongan_kerja: <?= json_encode($avgLowongan ?? 0) ?>,
        };

        function applyFilter() {
            const search    = document.getElementById('searchInput').value.toLowerCase().trim();
            const indikator = document.getElementById('filterIndikator').value;
            const kondisi   = document.getElementById('filterKondisi').value;

            let visibleCount = 0;

            /* Desktop rows */
            document.querySelectorAll('#tableBody .data-row').forEach(row => {
                const show = matches(row, search, indikator, kondisi);
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            /* Mobile cards */
            document.querySelectorAll('#mobileCards .mobile-card').forEach(card => {
                card.style.display = matches(card, search, indikator, kondisi) ? '' : 'none';
            });

            /* Row count */
            const countEl = document.getElementById('rowCount');
            if (countEl) countEl.textContent = `Menampilkan ${visibleCount} provinsi`;

            /* No results */
            const noResults = document.getElementById('noResults');
            noResults.classList.toggle('hidden', visibleCount > 0);

            /* Filter status badges */
            updateBadges(search, indikator, kondisi, visibleCount);
        }

        function matches(el, search, indikator, kondisi) {
            if (search && !el.dataset.provinsi.includes(search)) return false;
            if (indikator && kondisi) {
                const val = parseFloat(el.dataset[indikator]);
                const avg = window.dataAverages[indikator] ?? 0;
                if (kondisi === 'atas'  && val <= avg) return false;
                if (kondisi === 'bawah' && val >= avg) return false;
            }
            return true;
        }

        function updateBadges(search, indikator, kondisi, count) {
            const statusEl  = document.getElementById('filterStatus');
            const bSearch   = document.getElementById('badgeSearch');
            const bInd      = document.getElementById('badgeIndikator');
            const bKon      = document.getElementById('badgeKondisi');
            const countEl2  = document.getElementById('filterCount');

            const hasFilter = search || indikator;
            statusEl.classList.toggle('hidden', !hasFilter);

            if (search) {
                bSearch.classList.remove('hidden'); bSearch.classList.add('inline-flex');
                document.getElementById('badgeSearchText').textContent = `"${search}"`;
            } else {
                bSearch.classList.add('hidden'); bSearch.classList.remove('inline-flex');
            }

            const labelMap = { tpt: 'TPT', ipm: 'IPM', rls: 'RLS', tpak: 'TPAK', lowongan_kerja: 'Lowongan kerja' };
            if (indikator) {
                bInd.classList.remove('hidden'); bInd.classList.add('inline-flex');
                document.getElementById('badgeIndikatorText').textContent = labelMap[indikator] + (kondisiLabel ? ` · ${kondisiLabel}` : '');
                bKon.classList.add('hidden'); bKon.classList.remove('inline-flex');
            } else {
                bInd.classList.add('hidden'); bInd.classList.remove('inline-flex');
                bKon.classList.add('hidden'); bKon.classList.remove('inline-flex');
            }

            countEl2.textContent = hasFilter ? `${count} hasil` : '';
        }

        function resetFilter() {
            document.getElementById('searchInput').value     = '';
            document.getElementById('filterIndikator').value = '';
            document.getElementById('filterKondisi').value   = '';
            applyFilter();
        }
    </script>

</body>
</html>