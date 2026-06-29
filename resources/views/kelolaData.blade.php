<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Indikator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 antialiased">

    <x-header />
    <x-button-to-top />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ── Page Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Kelola Data Indikator</h1>
                <p class="text-sm text-gray-500 mt-0.5">Ketenagakerjaan per provinsi</p>
            </div>
            <button id="btnAdd"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors w-full sm:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah data
            </button>
        </div>

        {{-- ── Alert Blade (session) ── --}}
        @if (session('success'))
        <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-5">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- ── Alert JS ── --}}
        <div id="jsAlert"
            class="hidden items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-5">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span id="jsAlertMsg"></span>
        </div>

        {{-- ── Upload Section ── --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Unggah data excel</p>

            <form action="{{ route('data.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-col sm:flex-row gap-3 items-end">
                    {{-- File picker --}}
                    <div class="flex-1 w-full">
                        <p class="text-sm font-medium text-gray-700 mb-1.5">Pilih file (.xlsx / .xls)</p>
                        <label
                            class="flex items-center gap-3 w-full border-2 border-dashed border-gray-200 hover:border-blue-400 hover:bg-blue-50 rounded-lg px-4 py-3 cursor-pointer transition-colors group">
                            <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 group-hover:bg-blue-100 flex-shrink-0 transition-colors">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate" id="fileName">Pilih file Excel...</p>
                                <p class="text-xs text-gray-400">Maks. 5 MB &nbsp;·&nbsp; .xlsx / .xls</p>
                            </div>
                            <input type="file" name="file" id="fileInput" accept=".xlsx,.xls"
                                class="hidden" onchange="updateFileName(this)" required>
                        </label>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-colors w-full sm:w-auto justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload
                    </button>
                </div>

                {{-- Note --}}
                <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg px-4 py-3">
                    <p class="text-xs text-blue-700 leading-relaxed">
                        <span class="font-semibold">Kolom yang dibutuhkan:</span>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">PROVINSI</code>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">TPT</code>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">LOWONGAN KERJA</code>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">RLS</code>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">IPM</code>
                        <code class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded font-mono">TPAK</code>
                        &nbsp;— Nama provinsi harus huruf kapital. Data baru akan <strong>menggantikan</strong> seluruh data lama.
                    </p>
                </div>

                {{-- Format toggle --}}
                <button type="button" id="toggleFormat"
                    class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 mt-3 transition-colors">
                    <svg id="toggleIcon" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Lihat contoh format
                </button>

                <div id="formatWrap" class="hidden mt-3 border border-gray-100 rounded-lg overflow-x-auto">
                    <table class="min-w-full text-xs text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase tracking-wide text-[10px]">
                            <tr>
                                <th class="px-4 py-2.5 text-left font-semibold">PROVINSI</th>
                                <th class="px-4 py-2.5 text-left font-semibold">TPT</th>
                                <th class="px-4 py-2.5 text-left font-semibold">LOWONGAN</th>
                                <th class="px-4 py-2.5 text-left font-semibold">RLS</th>
                                <th class="px-4 py-2.5 text-left font-semibold">IPM</th>
                                <th class="px-4 py-2.5 text-left font-semibold">TPAK</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr class="bg-white">
                                <td class="px-4 py-2 font-medium text-gray-700">ACEH</td>
                                <td class="px-4 py-2 tabular-nums">5,11</td>
                                <td class="px-4 py-2 tabular-nums">2.100</td>
                                <td class="px-4 py-2 tabular-nums">8,79</td>
                                <td class="px-4 py-2 tabular-nums">72,40</td>
                                <td class="px-4 py-2 tabular-nums">64,13</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-2 font-medium text-gray-700">SUMATERA SELATAN</td>
                                <td class="px-4 py-2 tabular-nums">6,00</td>
                                <td class="px-4 py-2 tabular-nums">1.800</td>
                                <td class="px-4 py-2 tabular-nums">8,32</td>
                                <td class="px-4 py-2 tabular-nums">70,12</td>
                                <td class="px-4 py-2 tabular-nums">62,45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        {{-- ── Filter Bar ── --}}
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 mb-4">
            <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">

                {{-- Search --}}
                <div class="relative flex-1 min-w-0">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input id="searchInput" type="text" placeholder="Cari provinsi..."
                        oninput="applyFilter()"
                        class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400">
                </div>

                {{-- Indikator --}}
                <select id="filterIndikator" onchange="applyFilter()"
                    class="py-2 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-white sm:w-44">
                    <option value="">Semua indikator</option>
                    <option value="tpt">TPT</option>
                    <option value="ipm">IPM</option>
                    <option value="rls">RLS</option>
                    <option value="tpak">TPAK</option>
                    <option value="lowongan_kerja">Lowongan kerja</option>
                </select>

                {{-- Kondisi --}}
                <select id="filterKondisi" onchange="applyFilter()"
                    class="py-2 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-white sm:w-48">
                    <option value="">Semua kondisi</option>
                    <option value="atas">Di atas rata-rata</option>
                    <option value="bawah">Di bawah rata-rata</option>
                </select>

                {{-- Actions --}}
                <div class="flex gap-2 flex-shrink-0">
                    <button id="resetFilter" onclick="resetFilter()"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </button>
                    <a href="{{ route('export.excel') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Desktop Table ── --}}
        <div class="hidden sm:block bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Provinsi</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TPT (%)</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lowongan kerja</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">RLS</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">IPM</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TPAK (%)</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
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
                            <td class="px-5 py-3.5 text-gray-500 tabular-nums">{{ $row->tpt }}</td>
                            <td class="px-5 py-3.5 text-gray-500 tabular-nums">{{ number_format($row->lowongan_kerja, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-gray-500 tabular-nums">{{ $row->rls }}</td>
                            <td class="px-5 py-3.5 text-gray-500 tabular-nums">{{ $row->ipm }}</td>
                            <td class="px-5 py-3.5 text-gray-500 tabular-nums">{{ $row->tpak }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-1">
                                    <button
                                        class="btnEdit px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded-md transition-colors"
                                        data-id="{{ $row->id }}"
                                        data-provinsi="{{ $row->provinsi }}"
                                        data-tpt="{{ $row->tpt }}"
                                        data-lowongan="{{ $row->lowongan_kerja }}"
                                        data-rls="{{ $row->rls }}"
                                        data-ipm="{{ $row->ipm }}"
                                        data-tpak="{{ $row->tpak }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('data.destroy', $row->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data {{ $row->provinsi }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2.5 py-1 text-xs font-medium text-red-500 hover:bg-red-50 rounded-md transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-sm text-gray-400">
                                Belum ada data. Tambah atau upload file Excel untuk memulai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Mobile Cards ── --}}
        <div class="sm:hidden space-y-3" id="mobileCards">
            @forelse($data as $row)
            <div class="mobile-card bg-white border border-gray-200 rounded-xl p-4"
                data-provinsi="{{ strtolower($row->provinsi) }}"
                data-tpt="{{ $row->tpt }}"
                data-ipm="{{ $row->ipm }}"
                data-rls="{{ $row->rls }}"
                data-tpak="{{ $row->tpak }}"
                data-lowongan_kerja="{{ $row->lowongan_kerja }}">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <p class="text-sm font-semibold text-gray-900 leading-tight">{{ $row->provinsi }}</p>
                </div>
                <div class="grid grid-cols-2 gap-y-2.5 gap-x-4 mb-3.5">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">TPT</p>
                        <p class="text-sm text-gray-700 tabular-nums">{{ $row->tpt }}%</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Lowongan</p>
                        <p class="text-sm text-gray-700 tabular-nums">{{ number_format($row->lowongan_kerja, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">RLS</p>
                        <p class="text-sm text-gray-700 tabular-nums">{{ $row->rls }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">IPM</p>
                        <p class="text-sm text-gray-700 tabular-nums">{{ $row->ipm }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">TPAK</p>
                        <p class="text-sm text-gray-700 tabular-nums">{{ $row->tpak }}%</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-3 border-t border-gray-100">
                    <button
                        class="btnEdit flex-1 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors"
                        data-id="{{ $row->id }}"
                        data-provinsi="{{ $row->provinsi }}"
                        data-tpt="{{ $row->tpt }}"
                        data-lowongan="{{ $row->lowongan_kerja }}"
                        data-rls="{{ $row->rls }}"
                        data-ipm="{{ $row->ipm }}"
                        data-tpak="{{ $row->tpak }}">
                        Edit
                    </button>
                    <form action="{{ route('data.destroy', $row->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus data {{ $row->provinsi }}?')"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-1.5 text-xs font-medium text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-8 text-center text-sm text-gray-400">
                Belum ada data. Tambah atau upload file Excel untuk memulai.
            </div>
            @endforelse
        </div>

    </div>{{-- /page --}}


    {{-- ── Modal ── --}}
    <div id="dataModal"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        style="background: rgba(0,0,0,.45);">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl">

            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-100">
                <h2 id="modalTitle" class="text-base font-semibold text-gray-900">Tambah data</h2>
                <button id="cancelBtn"
                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="dataForm" method="POST" class="px-6 py-5">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="dataId">

                <div class="space-y-4">

                    {{-- Provinsi full width --}}
                    <div>
                        <label for="fProvinsi" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Provinsi</label>
                        <input type="text" name="provinsi" id="fProvinsi"
                            placeholder="cth. JAWA BARAT"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                            required>
                    </div>

                    {{-- Grid 2 col --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="fTpt" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">TPT (%)</label>
                            <input type="number" name="tpt" id="fTpt"
                                step="0.01" min="0" placeholder="0.00"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                                required>
                        </div>
                        <div>
                            <label for="fLowongan" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Lowongan kerja</label>
                            <input type="number" name="lowongan_kerja" id="fLowongan"
                                min="0" placeholder="0"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                                required>
                        </div>
                        <div>
                            <label for="fRls" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">RLS</label>
                            <input type="number" name="rls" id="fRls"
                                step="0.01" min="0" placeholder="0.00"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                                required>
                        </div>
                        <div>
                            <label for="fIpm" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">IPM</label>
                            <input type="number" name="ipm" id="fIpm"
                                step="0.01" min="0" placeholder="0.00"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                                required>
                        </div>
                    </div>

                    {{-- TPAK full width --}}
                    <div>
                        <label for="fTpak" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">TPAK (%)</label>
                        <input type="number" name="tpak" id="fTpak"
                            step="0.01" min="0" placeholder="0.00"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-300 transition-colors"
                            required>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" id="cancelBtn2"
                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ── Scripts ── --}}
    <script>
        /* Average dari controller */
        window.dataAverages = {
            tpt:            <?= json_encode($avgTPT ?? 0) ?>,
            ipm:            <?= json_encode($avgIPM ?? 0) ?>,
            rls:            <?= json_encode($avgRLS ?? 0) ?>,
            tpak:           <?= json_encode($avgTPAK ?? 0) ?>,
            lowongan_kerja: <?= json_encode($avgLowongan ?? 0) ?>,
        };

        /* ── Modal ── */
        const modal       = document.getElementById('dataModal');
        const form        = document.getElementById('dataForm');
        const btnAdd      = document.getElementById('btnAdd');
        const cancelBtn   = document.getElementById('cancelBtn');
        const cancelBtn2  = document.getElementById('cancelBtn2');
        const methodField = document.getElementById('methodField');
        const modalTitle  = document.getElementById('modalTitle');

        function openModal()  { modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.style.overflow = 'hidden'; }
        function closeModal() { modal.classList.add('hidden');    modal.classList.remove('flex'); document.body.style.overflow = ''; }

        btnAdd.addEventListener('click', () => {
            form.action       = "{{ route('data.store') }}";
            methodField.value = 'POST';
            modalTitle.textContent = 'Tambah data';
            form.reset();
            openModal();
        });

        [cancelBtn, cancelBtn2].forEach(b => b.addEventListener('click', closeModal));
        modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        document.querySelectorAll('.btnEdit').forEach(btn => {
            btn.addEventListener('click', () => {
                form.action       = "{{ url('/kelolaData') }}/" + btn.dataset.id;
                methodField.value = 'PUT';
                modalTitle.textContent = 'Edit data';

                document.getElementById('dataId').value    = btn.dataset.id;
                document.getElementById('fProvinsi').value = btn.dataset.provinsi;
                document.getElementById('fTpt').value      = btn.dataset.tpt;
                document.getElementById('fIpm').value      = btn.dataset.ipm;
                document.getElementById('fRls').value      = btn.dataset.rls;
                document.getElementById('fTpak').value     = btn.dataset.tpak;
                document.getElementById('fLowongan').value = btn.dataset.lowongan;

                openModal();
            });
        });

        /* ── Filter ── */
        function applyFilter() {
            const search    = document.getElementById('searchInput').value.toLowerCase().trim();
            const indikator = document.getElementById('filterIndikator').value;
            const kondisi   = document.getElementById('filterKondisi').value;

            /* Desktop rows */
            document.querySelectorAll('#tableBody .data-row').forEach(row => {
                row.style.display = matches(row, search, indikator, kondisi) ? '' : 'none';
            });
            /* Mobile cards */
            document.querySelectorAll('#mobileCards .mobile-card').forEach(card => {
                card.style.display = matches(card, search, indikator, kondisi) ? '' : 'none';
            });
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

        function resetFilter() {
            document.getElementById('searchInput').value      = '';
            document.getElementById('filterIndikator').value  = '';
            document.getElementById('filterKondisi').value    = '';
            applyFilter();
        }

        /* ── File name display ── */
        function updateFileName(input) {
            const el = document.getElementById('fileName');
            el.textContent = input.files[0] ? input.files[0].name : 'Pilih file Excel...';
        }

        /* ── Format toggle ── */
        document.getElementById('toggleFormat').addEventListener('click', function () {
            const wrap = document.getElementById('formatWrap');
            const icon = document.getElementById('toggleIcon');
            const isHidden = wrap.classList.contains('hidden');
            wrap.classList.toggle('hidden', !isHidden);
            icon.style.transform = isHidden ? 'rotate(180deg)' : '';
            this.childNodes[1].textContent = isHidden ? ' Sembunyikan contoh format' : ' Lihat contoh format';
        });

        /* ── JS Alert ── */
        function showAlert(msg) {
            const el = document.getElementById('jsAlert');
            document.getElementById('jsAlertMsg').textContent = msg;
            el.classList.remove('hidden');
            el.classList.add('flex');
            setTimeout(() => { el.classList.add('hidden'); el.classList.remove('flex'); }, 3500);
        }
    </script>

</body>
</html>