<x-layouts.app title="Waktu Salat & Arah Kiblat — Kuantum Pelopor Indonesia">

    <div class="px-4 md:px-8 py-5 space-y-5 pb-12" id="prayer-qibla-container">

        {{-- Sub-info Lokasi, Refresh Button & Tanggal Hijriyah --}}
        <div class="bg-white rounded-2xl px-5 py-3.5 border border-[#e5e5e0] shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-[#535955]">
            <div class="flex items-center gap-2 font-medium">
                <span class="material-symbols-outlined text-[#c59b27] text-[18px] shrink-0">location_on</span>
                <span class="text-gray-500">Lokasi:</span>
                <span id="display-location" class="font-bold text-[#0f382c]">{{ $prayerData['location'] }}</span>
            </div>
            <div class="flex items-center gap-3 self-end sm:self-auto">
                <span id="display-hijri" class="font-semibold text-[#735c00] bg-[#c59b27]/10 px-3 py-1 rounded-full text-xs">
                    {{ $prayerData['hijri_date'] }}
                </span>
                <button type="button"
                        id="btn-detect-location"
                        onclick="detectUserLocation()"
                        title="Deteksi Lokasi GPS Anda"
                        class="px-2.5 py-1 rounded-xl bg-[#f4f4f1] border border-[#e5e5e0] hover:bg-[#e2e3e0] text-[#0f382c] flex items-center gap-1.5 transition-all active:scale-95 shadow-2xs text-xs font-medium">
                    <span id="location-refresh-icon" class="material-symbols-outlined text-[15px]">my_location</span>
                    <span class="hidden sm:inline">Perbarui Lokasi</span>
                </button>
            </div>
        </div>

        {{-- Alert Notifikasi Status GPS / Izin Geolocation --}}
        <div id="location-status-badge" class="hidden px-4 py-2.5 rounded-xl text-xs font-medium items-center justify-between transition-all">
            <span id="location-status-text">Mendeteksi lokasi GPS...</span>
            <span class="material-symbols-outlined text-[15px]">info</span>
        </div>

        {{-- Grid 2 Kolom di Desktop (Kiri: Waktu Salat & Arah Kiblat, Kanan: Jadwal 5 Waktu Salat) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
            <div class="space-y-4">
                {{-- 1. Card Ringkas: Waktu Salat Berikutnya (Stitch 100%) --}}
                <section class="rounded-2xl bg-white p-5 border border-[#e5e5e0] shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#c59b27] animate-pulse"></span>
                            <span class="text-xs font-semibold tracking-wider uppercase text-[#535955]">
                                Waktu Salat Berikutnya
                            </span>
                        </div>
                        <span id="display-timezone" class="text-xs font-semibold text-[#735c00] bg-amber-50 px-2 py-0.5 rounded-md">
                            {{ $prayerData['timezone'] }}
                        </span>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div>
                            <h2 class="font-serif text-[26px] md:text-[30px] font-bold text-[#0f382c] leading-tight">
                                <span id="display-next-name">{{ $nextPrayer['name'] }}</span>
                                <span class="font-normal text-lg md:text-xl text-[#535955]"> — <span id="display-next-time">{{ $nextPrayer['time'] }} {{ $prayerData['timezone'] === 'Zona WIB' ? 'WIB' : ($prayerData['timezone'] === 'Zona WITA' ? 'WITA' : 'WIT') }}</span></span>
                            </h2>
                            <p class="text-xs md:text-sm text-[#735c00] font-medium mt-1 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span id="display-next-label">{{ $nextPrayer['label'] }}</span>
                            </p>
                        </div>
                    </div>
                </section>

                {{-- 2. Kompas / Indikator Arah Kiblat Interaktif --}}
                <section class="bg-white rounded-2xl p-5 border border-[#e5e5e0] shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-[#e5e5e0]">
                        <div>
                            <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-[#c59b27]">Panduan Ibadah Presisi</span>
                            <h3 class="font-serif text-base md:text-lg font-bold text-[#0f382c] mt-0.5">Arah Kiblat</h3>
                        </div>
                        <div class="text-right">
                            <span id="display-qibla-degree" class="inline-block px-3 py-1 rounded-lg bg-[#f4f4f1] border border-[#e5e5e0] text-[#0f382c] font-serif font-bold text-base md:text-lg">
                                {{ $prayerData['qibla']['degree'] }}°
                            </span>
                            <div id="display-qibla-label" class="text-xs font-semibold text-[#735c00] mt-0.5">
                                {{ $prayerData['qibla']['direction_label'] }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-center gap-6 py-2">
                        {{-- Visual Kompas Interaktif dengan Jarum & Ka'bah Marker --}}
                        <div class="relative w-32 h-32 rounded-full border-2 border-[#e5e5e0] bg-gradient-to-b from-[#f9f9f6] to-[#ecece9] flex items-center justify-center shrink-0 shadow-md">
                            {{-- Mata Angin --}}
                            <span class="absolute top-1.5 text-[10px] font-bold text-[#ba1a1a]">U</span>
                            <span class="absolute bottom-1.5 text-[9px] font-semibold text-[#717975]">S</span>
                            <span class="absolute right-2 text-[9px] font-semibold text-[#717975]">T</span>
                            <span class="absolute left-2 text-[9px] font-semibold text-[#717975]">B</span>

                            {{-- Kompas Dial Berputar Sesuai Heading Device / Sensor --}}
                            <div id="compass-dial"
                                 class="w-24 h-24 rounded-full border border-dashed border-[#c1c8c3] bg-white flex items-center justify-center relative transition-transform duration-300 ease-out"
                                 style="transform: rotate(0deg);">
                                
                                {{-- Ka'bah Marker --}}
                                <div id="kaaba-marker"
                                     class="absolute w-4 h-4 bg-[#0f382c] rounded-[3px] border border-[#c59b27] flex items-center justify-center shadow-xs"
                                     style="top: 2px; left: 8px;"
                                     title="Arah Ka'bah Makkah">
                                    <span class="w-2 h-0.5 bg-[#fed65b] block"></span>
                                </div>

                                {{-- Jarum Penunjuk Emas Presisi Menghadap Sudut Kiblat --}}
                                <div id="qibla-needle"
                                     class="w-16 h-16 flex items-center justify-center transition-transform duration-500 ease-out"
                                     style="transform: rotate({{ $prayerData['qibla']['degree'] - 360 }}deg);">
                                    <div class="w-1 h-11 bg-gradient-to-t from-transparent via-[#c59b27] to-[#fed65b] rounded-full relative flex justify-center">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#c59b27] border border-white absolute top-0 -mt-0.5 shadow-sm"></div>
                                    </div>
                                </div>

                                {{-- Pusat Poros Kompas --}}
                                <div class="w-3.5 h-3.5 rounded-full bg-[#0f382c] border-2 border-white absolute shadow-xs z-10"></div>
                            </div>
                        </div>

                        {{-- Panduan Arah --}}
                        <div class="flex-1 pl-2">
                            <div class="text-sm font-bold text-[#0f382c]">Menghadap Ka'bah</div>
                            <p class="text-xs text-[#535955] mt-1.5 leading-relaxed">
                                Posisikan layar atau ponsel mendatar. Sejajarkan jarum emas menuju Ka'bah untuk menghadap Kiblat dengan presisi.
                            </p>
                            <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-[#735c00]">
                                <span class="material-symbols-outlined text-[16px] text-[#c59b27]">explore</span>
                                <span id="display-qibla-subtext">{{ $prayerData['qibla']['degree'] }}° dari lokasi Anda</span>
                            </div>
                        </div>
                    </div>

                    {{-- Sensor Status Mini Pill --}}
                    <div class="mt-4 pt-3 border-t border-[#f0f0ed] flex items-center justify-between text-xs text-[#717975]">
                        <span id="sensor-status-label" class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Mode Geolocation Presisi
                        </span>
                        <button type="button"
                                onclick="calibrateCompass()"
                                class="text-[#0f382c] font-semibold hover:underline flex items-center gap-1">
                            <span>Kalibrasi Sensor</span>
                            <span class="material-symbols-outlined text-[14px]">refresh</span>
                        </button>
                    </div>
                </section>
            </div>

            {{-- Kolom Kanan di Desktop: Jadwal 5 Waktu Salat --}}
            <div>
                {{-- 3. Jadwal 5 Waktu Salat Polos & Presisi --}}
                <section class="bg-white rounded-2xl p-5 border border-[#e5e5e0] shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-[#e5e5e0]">
                        <div>
                            <h3 class="font-serif text-base md:text-lg font-bold text-[#0f382c]">Jadwal 5 Waktu Salat</h3>
                            <p class="text-xs text-[#535955]">Berdasarkan hisab akurat Kemenag RI / MABIMS</p>
                        </div>
                        <span class="material-symbols-outlined text-[#717975] text-[20px]">calendar_today</span>
                    </div>

                    <div class="divide-y divide-[#f0f0ed] mt-1 text-[#1c1b1f]">
                        @php
                            $prayersList = [
                                ['key' => 'Subuh', 'icon' => 'wb_twilight'],
                                ['key' => 'Terbit', 'icon' => 'wb_sunny'],
                                ['key' => 'Dzuhur', 'icon' => 'light_mode'],
                                ['key' => 'Ashar', 'icon' => 'sunny'],
                                ['key' => 'Maghrib', 'icon' => 'nights_stay'],
                                ['key' => 'Isya', 'icon' => 'dark_mode'],
                            ];
                        @endphp

                        @foreach ($prayersList as $item)
                            @php
                                $isNext = ($nextPrayer['name'] ?? '') === $item['key'];
                                $timeValue = $prayerData['timings'][$item['key']] ?? '--:--';
                                $tzSuffix = $prayerData['timezone'] === 'Zona WIB' ? 'WIB' : ($prayerData['timezone'] === 'Zona WITA' ? 'WITA' : 'WIT');
                            @endphp
                            <div class="flex items-center justify-between py-3.5 px-3 rounded-xl transition-colors {{ $isNext ? 'bg-[#f4f7f5] border border-[#a6d0be]' : 'hover:bg-[#fafaf8]' }}">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-[20px] {{ $isNext ? 'text-[#0f382c]' : 'text-[#717975]' }}">
                                        {{ $item['icon'] }}
                                    </span>
                                    <div>
                                        <span class="text-sm font-semibold {{ $isNext ? 'text-[#0f382c] font-bold' : 'text-gray-800' }}">
                                            {{ $item['key'] }}
                                        </span>
                                        @if ($isNext)
                                            <span class="ml-2 text-[10px] font-bold bg-[#c1ecda] text-[#002117] px-2 py-0.5 rounded-full">
                                                Berikutnya
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span id="time-val-{{ strtolower($item['key']) }}"
                                      class="font-mono text-sm font-bold {{ $isNext ? 'text-[#0f382c]' : 'text-gray-700' }}">
                                    {{ $timeValue }} {{ $tzSuffix }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
                @php
                    $prayersList = [
                        ['key' => 'Subuh', 'icon' => 'wb_twilight'],
                        ['key' => 'Terbit', 'icon' => 'wb_sunny'],
                        ['key' => 'Dzuhur', 'icon' => 'light_mode'],
                        ['key' => 'Ashar', 'icon' => 'sunny'],
                        ['key' => 'Maghrib', 'icon' => 'nights_stay'],
                        ['key' => 'Isya', 'icon' => 'dark_mode'],
                    ];
                @endphp

                @foreach ($prayersList as $item)
                    @php
                        $isNext = ($nextPrayer['name'] ?? '') === $item['key'];
                        $timeValue = $prayerData['timings'][$item['key']] ?? '--:--';
                    @endphp
                    <div id="prayer-row-{{ strtolower($item['key']) }}"
                         class="flex items-center justify-between py-2.5 px-2 transition-all {{ $isNext ? 'rounded-xl bg-[#f4f4f1] border-l-4 border-[#c59b27] border-y border-r border-[#e5e5e0] -mx-1 px-3 shadow-2xs font-semibold' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined {{ $isNext ? 'text-[#c59b27]' : 'text-[#535955]' }} text-[18px]">
                                {{ $item['icon'] }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[13px] {{ $isNext ? 'font-bold text-[#0f382c]' : 'font-medium text-[#1c1b1f]' }}">
                                    {{ $item['key'] }}
                                </span>
                                @if ($isNext)
                                    <span class="px-1.5 py-0.5 rounded text-[10px] bg-[#c59b27]/15 text-[#735c00] font-bold">
                                        Berikutnya
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span id="time-val-{{ strtolower($item['key']) }}"
                              class="font-serif text-[14px] {{ $isNext ? 'font-bold text-[#0f382c]' : 'font-semibold text-[#0f382c]' }}">
                            {{ $timeValue }} {{ $prayerData['timezone'] === 'Zona WIB' ? 'WIB' : ($prayerData['timezone'] === 'Zona WITA' ? 'WITA' : 'WIT') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </section>

    </div>

    {{-- Script Geolocation & Kompas Interaktif --}}
    <script>
        let currentQiblaDegree = {{ $prayerData['qibla']['degree'] ?? 295.2 }};

        function showLocationStatus(message, isError = false) {
            const badge = document.getElementById('location-status-badge');
            const text = document.getElementById('location-status-text');
            if (!badge || !text) return;

            badge.className = isError
                ? 'px-3.5 py-2 rounded-xl text-[11px] font-medium flex items-center justify-between bg-red-50 text-red-700 border border-red-200'
                : 'px-3.5 py-2 rounded-xl text-[11px] font-medium flex items-center justify-between bg-emerald-50 text-emerald-800 border border-emerald-200';

            text.innerText = message;
            badge.classList.remove('hidden');

            setTimeout(() => {
                badge.classList.add('hidden');
            }, 6000);
        }

        function detectUserLocation() {
            const icon = document.getElementById('location-refresh-icon');
            if (icon) icon.classList.add('animate-spin');

            if (!navigator.geolocation) {
                showLocationStatus('Browser Anda tidak mendukung Geolocation GPS.', true);
                if (icon) icon.classList.remove('animate-spin');
                return;
            }

            showLocationStatus('Mendeteksi posisi koordinat GPS Anda...', false);

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // 1. Coba reverse geocode langsung dari client browser (BigDataCloud Client API - free & fast)
                    let clientCity = '';
                    try {
                        const geoClient = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=id`);
                        if (geoClient.ok) {
                            const geoData = await geoClient.json();
                            const regency = geoData.locality || geoData.city || geoData.principalSubdivisionDistrict;
                            const province = geoData.principalSubdivision;
                            if (regency && province) {
                                clientCity = `${regency}, ${province}`;
                            } else if (regency) {
                                clientCity = regency;
                            }
                        }
                    } catch (e) {
                        // ignore and let server resolve
                    }

                    try {
                        const queryUrl = clientCity
                            ? `/api/waktu-salat?lat=${lat}&lng=${lng}&city=${encodeURIComponent(clientCity)}`
                            : `/api/waktu-salat?lat=${lat}&lng=${lng}`;

                        const response = await fetch(queryUrl);
                        const result = await response.json();

                        if (result.status === 'success') {
                            updateUIWithPrayerData(result.data);
                            showLocationStatus(`Lokasi terdeteksi: ${result.data.location}`, false);
                        } else {
                            showLocationStatus('Gagal memuat jadwal untuk koordinat Anda.', true);
                        }
                    } catch (err) {
                        showLocationStatus('Koneksi terganggu saat mengambil jadwal.', true);
                    } finally {
                        if (icon) icon.classList.remove('animate-spin');
                    }
                },
                (error) => {
                    if (icon) icon.classList.remove('animate-spin');
                    let msg = 'Izin lokasi ditolak. Menggunakan lokasi default Jakarta.';
                    if (error.code === error.TIMEOUT) msg = 'Waktu permintaan lokasi habis.';
                    showLocationStatus(msg, true);
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
            );
        }

        function updateUIWithPrayerData(data) {
            document.getElementById('display-location').innerText = data.location;
            document.getElementById('display-hijri').innerText = data.hijri_date;
            document.getElementById('display-timezone').innerText = data.timezone;

            if (data.next_prayer) {
                const tzSuffix = data.timezone === 'Zona WIB' ? 'WIB' : (data.timezone === 'Zona WITA' ? 'WITA' : 'WIT');
                document.getElementById('display-next-name').innerText = data.next_prayer.name;
                document.getElementById('display-next-time').innerText = `${data.next_prayer.time} ${tzSuffix}`;
                document.getElementById('display-next-label').innerText = data.next_prayer.label;
            }

            if (data.qibla) {
                currentQiblaDegree = data.qibla.degree;
                document.getElementById('display-qibla-degree').innerText = `${data.qibla.degree}°`;
                document.getElementById('display-qibla-label').innerText = data.qibla.direction_label;
                document.getElementById('display-qibla-subtext').innerText = `${data.qibla.degree}° dari lokasi Anda`;

                const needle = document.getElementById('qibla-needle');
                if (needle) {
                    needle.style.transform = `rotate(${data.qibla.degree}deg)`;
                }
            }

            if (data.timings) {
                const tzSuffix = data.timezone === 'Zona WIB' ? 'WIB' : (data.timezone === 'Zona WITA' ? 'WITA' : 'WIT');
                for (const [key, val] of Object.entries(data.timings)) {
                    const el = document.getElementById(`time-val-${key.toLowerCase()}`);
                    if (el) el.innerText = `${val} ${tzSuffix}`;
                }
            }
        }

        // Listener Device Orientation untuk memutar kompas di smartphone
        function setupCompassOrientation() {
            if (window.DeviceOrientationEvent) {
                window.addEventListener('deviceorientation', (event) => {
                    let heading = null;
                    if (event.webkitCompassHeading) {
                        // iOS Safari
                        heading = event.webkitCompassHeading;
                    } else if (event.alpha !== null) {
                        // Android Chrome
                        heading = 360 - event.alpha;
                    }

                    if (heading !== null) {
                        const dial = document.getElementById('compass-dial');
                        if (dial) {
                            dial.style.transform = `rotate(${-heading}deg)`;
                        }
                    }
                }, false);
            }
        }

        function calibrateCompass() {
            if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                DeviceOrientationEvent.requestPermission()
                    .then(permissionState => {
                        if (permissionState === 'granted') {
                            showLocationStatus('Sensor orientasi kompas diaktifkan.', false);
                            setupCompassOrientation();
                        } else {
                            showLocationStatus('Izin orientasi perangkat ditolak.', true);
                        }
                    })
                    .catch(() => showLocationStatus('Gagal meminta izin orientasi perangkat.', true));
            } else {
                showLocationStatus('Kompas telah dikalibrasi sesuai arah Kiblat.', false);
                setupCompassOrientation();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupCompassOrientation();
        });
    </script>

</x-layouts.app>
