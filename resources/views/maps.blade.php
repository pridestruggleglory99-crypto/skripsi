<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Peta Indikator Ketenagakerjaan</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #map {
            position: absolute;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        /* Mobile: header lebih kecil */
        @media (max-width: 640px) {
            #map { top: 56px; }
        }

        .legend-container {
            max-height: 220px;
            overflow-y: auto;
            font-size: 0.75rem;
            min-width: 160px;
            max-width: 220px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
            margin-right: 6px;
            border: 1px solid rgba(0,0,0,0.2);
            border-radius: 2px;
        }

        /* Scrollbar tipis untuk legend */
        .legend-container::-webkit-scrollbar { width: 4px; }
        .legend-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 2px; }
        .legend-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 2px; }
    </style>
</head>

<body class="bg-gray-100">
    <x-header />

    <!-- Overlay Controls -->
    <div class="absolute top-16 sm:top-20 left-0 right-0 z-[1000] px-3 sm:px-4 pt-3">
        <div class="flex flex-col sm:flex-row gap-2 max-w-xl ml-auto">

            <!-- Search -->
            <div class="relative flex-1">
                <input id="searchProvinsi"
                    type="text"
                    placeholder="Cari provinsi..."
                    autocomplete="off"
                    class="w-full py-2 pl-9 pr-3 rounded-lg border border-gray-200 text-sm shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <ul id="suggestionList"
                    class="absolute z-[1001] mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-md hidden max-h-52 overflow-auto text-sm"></ul>
            </div>

            <!-- Filter Dropdown -->
            <div class="relative">
                <button id="dropdownButton" data-dropdown-toggle="dropdownFilter"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm inline-flex items-center justify-center gap-2 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter Peta
                </button>

                <div id="dropdownFilter"
                    class="z-[1002] hidden bg-white border border-gray-200 rounded-lg shadow-md w-48 absolute right-0 mt-2">
                    <ul class="py-1 text-sm text-gray-700">
                        <li><a href="#" data-filter="tpt" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50">TPT</a></li>
                        <li><a href="#" data-filter="ipm" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50">IPM</a></li>
                        <li><a href="#" data-filter="rls" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50">RLS</a></li>
                        <li><a href="#" data-filter="tpak" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50">TPAK</a></li>
                        <li><a href="#" data-filter="lowongan" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50">Lowongan Kerja</a></li>
                        <li class="border-t border-gray-100">
                            <a href="#" data-filter="reset" class="flex items-center gap-2 px-4 py-2 hover:bg-red-50 text-red-500">
                                Reset Peta
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- Tombol Cara Pakai -->
    <button data-modal-target="hintModal" data-modal-toggle="hintModal"
        class="absolute bottom-5 right-4 z-[1000] bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm shadow-sm flex items-center gap-2 transition">
        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Cara Pakai
    </button>

    <!-- Modal Cara Pakai -->
    <div id="hintModal"
        class="hidden fixed inset-0 z-[1001] flex items-center justify-center px-4 backdrop-blur-sm bg-black/20">
        <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h2 class="text-base font-semibold text-gray-800">Cara Menggunakan Peta</h2>
            </div>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 font-medium">1</span>
                    Ketik nama provinsi di kolom pencarian untuk menemukannya di peta.
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 font-medium">2</span>
                    Gunakan tombol Filter untuk menampilkan warna berdasarkan data TPT, IPM, RLS, TPAK, atau Lowongan Kerja.
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 font-medium">3</span>
                    Klik provinsi di peta untuk melihat detail datanya.
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 font-medium">4</span>
                    Pilih Reset Peta di menu filter untuk kembali ke tampilan awal.
                </li>
            </ul>
            <div class="mt-5 text-right">
                <button data-modal-hide="hintModal"
                    class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const provinceColors = {};
        const legendItems = [];
        let geoLayer;
        let currentLegend;

        const fixedPalette = [
            '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
            '#8c564b', '#e377c2', '#17becf', '#bcbd22', '#7f7f7f',
            '#393b79', '#637939', '#8c6d31', '#843c39', '#7b4173',
            '#a55194', '#6b6ecf', '#9c9ede', '#ce6dbd', '#e7969c',
            '#de9ed6', '#3182bd', '#9e9ac8', '#8c510a', '#d8b365',
            '#5ab4ac', '#01665e', '#c51b7d', '#fdb863', '#80cdc1',
            '#018571', '#dfc27d', '#1b7837', '#762a83', '#af8dc3',
            '#f1a340', '#998ec3'
        ];

        let paletteIndex = 0;

        function assignColor(provKey) {
            if (!provinceColors[provKey]) {
                provinceColors[provKey] = fixedPalette[paletteIndex % fixedPalette.length];
                paletteIndex++;
            }
            return provinceColors[provKey];
        }

        fetch('/map/geojson')
            .then(res => res.json())
            .then(geojson => {
                geoLayer = L.geoJSON(geojson, {
                    style: function(feature) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        const color = assignColor(name);
                        return {
                            fillColor: color,
                            weight: 1.5,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: 0.7,
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        legendItems.push({
                            name: feature.properties.PROVINSI,
                            color: provinceColors[name]
                        });
                        const props = feature.properties;
                        layer.bindPopup(`
                            <div style="min-width:160px; font-size:13px; line-height:1.6">
                                <p style="font-weight:600; margin-bottom:6px; font-size:14px">${props.PROVINSI}</p>
                                <table style="width:100%; border-collapse:collapse;">
                                    <tr><td style="color:#666; padding:1px 0">TPT</td><td style="font-weight:500; text-align:right">${props.TPT ?? 'N/A'}%</td></tr>
                                    <tr><td style="color:#666; padding:1px 0">IPM</td><td style="font-weight:500; text-align:right">${props.IPM ?? 'N/A'}</td></tr>
                                    <tr><td style="color:#666; padding:1px 0">RLS</td><td style="font-weight:500; text-align:right">${props.RLS ?? 'N/A'} tahun</td></tr>
                                    <tr><td style="color:#666; padding:1px 0">Lowongan</td><td style="font-weight:500; text-align:right">${props.LOWONGAN_KERJA_TERDAFTAR ?? 'N/A'}</td></tr>
                                    <tr><td style="color:#666; padding:1px 0">TPAK</td><td style="font-weight:500; text-align:right">${props.TPAK ?? 'N/A'}%</td></tr>
                                </table>
                            </div>
                        `);
                    }
                }).addTo(map);

                showLegend(legendItems);

                // Search logic
                const searchInput = document.getElementById('searchProvinsi');
                const suggestionList = document.getElementById('suggestionList');
                let allProvinsi = [];

                map.whenReady(() => {
                    geoLayer.eachLayer(layer => {
                        const provName = layer.feature.properties.PROVINSI.trim();
                        if (!allProvinsi.includes(provName)) allProvinsi.push(provName);
                    });
                });

                searchInput.addEventListener('input', () => {
                    const keyword = searchInput.value.trim().toLowerCase();
                    suggestionList.innerHTML = '';

                    if (!keyword) {
                        suggestionList.classList.add('hidden');
                        return;
                    }

                    const matches = allProvinsi.filter(n => n.toLowerCase().includes(keyword));

                    if (!matches.length) {
                        suggestionList.classList.add('hidden');
                        return;
                    }

                    matches.forEach(match => {
                        const li = document.createElement('li');
                        li.textContent = match;
                        li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer';
                        li.addEventListener('click', () => {
                            zoomToProvince(match);
                            searchInput.value = '';
                            suggestionList.classList.add('hidden');
                        });
                        suggestionList.appendChild(li);
                    });

                    suggestionList.classList.remove('hidden');
                });

                searchInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const match = allProvinsi.find(n =>
                            n.toLowerCase() === searchInput.value.trim().toLowerCase()
                        );
                        if (match) {
                            zoomToProvince(match);
                            searchInput.value = '';
                            suggestionList.classList.add('hidden');
                        }
                    }
                });

                document.addEventListener('click', e => {
                    if (!searchInput.contains(e.target) && !suggestionList.contains(e.target)) {
                        suggestionList.classList.add('hidden');
                    }
                });

                function zoomToProvince(provName) {
                    const targetName = provName.trim().toLowerCase();
                    let found = false;

                    geoLayer.eachLayer(layer => {
                        const name = layer.feature.properties.PROVINSI.trim().toLowerCase();
                        if (name === targetName) {
                            map.fitBounds(layer.getBounds(), { padding: [20, 20] });
                            layer.setStyle({
                                fillColor: '#2563eb',
                                weight: 2.5,
                                color: 'white',
                                dashArray: '',
                                fillOpacity: 0.85
                            });
                            if (layer.getPopup()) layer.openPopup();
                            found = true;
                        } else {
                            layer.setStyle({ fillOpacity: 0.15 });
                        }
                    });

                    if (!found) alert('Provinsi tidak ditemukan!');
                }
            });

        function showLegend(items) {
            if (currentLegend) map.removeControl(currentLegend);
            currentLegend = L.control({ position: 'bottomleft' });
            currentLegend.onAdd = function() {
                const div = L.DomUtil.create('div', 'legend-container bg-white p-3 rounded-lg shadow-md');
                div.innerHTML = '<p style="font-weight:600; font-size:0.75rem; margin-bottom:6px; color:#374151">Legenda</p>';
                items.forEach(item => {
                    div.innerHTML += `
                        <div class="legend-item">
                            <span class="legend-color" style="background:${item.color}"></span>
                            <span style="color:#4b5563">${item.name}</span>
                        </div>
                    `;
                });
                return div;
            };
            currentLegend.addTo(map);
        }

        document.querySelectorAll('#dropdownFilter a[data-filter]').forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();
                applyFilter(item.dataset.filter);
            });
        });

        function applyFilter(type) {
            const indicatorMap = {
                tpt:      { label: 'TPT',           unit: '%',      key: 'TPT' },
                ipm:      { label: 'IPM',           unit: '',       key: 'IPM' },
                rls:      { label: 'RLS',           unit: ' tahun', key: 'RLS' },
                tpak:     { label: 'TPAK',          unit: '%',      key: 'TPAK' },
                lowongan: { label: 'Lowongan Kerja',unit: '',       key: 'LOWONGAN_KERJA_TERDAFTAR' },
            };

            if (type === 'reset') {
                map.setView([-2.5, 118], 5);
                const resetLegend = [];
                geoLayer.eachLayer(layer => {
                    const provName = layer.feature.properties.PROVINSI.trim().toLowerCase();
                    const color = provinceColors[provName] || '#ccc';
                    layer.setStyle({ fillColor: color, weight: 1.5, color: 'white', dashArray: '3', fillOpacity: 0.7 });
                    resetLegend.push({ name: layer.feature.properties.PROVINSI, color });
                });
                showLegend(resetLegend);
                return;
            }

            const { label, unit, key } = indicatorMap[type];
            const values = [];

            geoLayer.eachLayer(layer => {
                const val = layer.feature.properties[key];
                if (val !== undefined && val !== null && !isNaN(val)) values.push(parseFloat(val));
            });

            if (!values.length) { alert(`Tidak ada data ${label}.`); return; }

            const avg = values.reduce((a, b) => a + b, 0) / values.length;
            const avgFixed = avg.toFixed(2);

            geoLayer.eachLayer(layer => {
                const val = parseFloat(layer.feature.properties[key]);
                let color = '#d1d5db';
                if (!isNaN(val)) {
                    if (type === 'tpt') {
                        color = val < avg ? '#16a34a' : '#dc2626';
                    } else {
                        color = val > avg ? '#16a34a' : '#dc2626';
                    }
                }
                layer.setStyle({ fillColor: color, weight: 1.5, color: 'white', dashArray: '3', fillOpacity: 0.75 });
            });

            const categoryLegend = type === 'tpt'
                ? [
                    { name: `${label} < ${avgFixed}${unit} (di bawah rata-rata nasional)`, color: '#16a34a' },
                    { name: `${label} > ${avgFixed}${unit} (di atas rata-rata nasional)`, color: '#dc2626' }
                ]
                : [
                    { name: `${label} > ${avgFixed}${unit} (di atas rata-rata nasional)`, color: '#16a34a' },
                    { name: `${label} < ${avgFixed}${unit} (di bawah rata-rata nasional)`, color: '#dc2626' }
                ];

            showLegend(categoryLegend);
        }
    </script>
</body>

</html>