<x-layouts.app title="Unggah Karya Visual — Kuantum Pelopor Indonesia">

    <div class="px-5 py-4 space-y-4">

        {{-- Top Title & Close Button Bar --}}
        <div class="flex items-center justify-between pb-2 border-b border-[#dadad7]/40">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}"
                   aria-label="Tutup formulir"
                   class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#1a1c1b] hover:bg-[#e2e3e0] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
                <h1 class="font-serif text-[18px] text-[#0f382c] tracking-tight font-semibold">
                    Unggah Karya
                </h1>
            </div>
            <span class="text-[11px] font-medium text-[#735c00] bg-[#fed65b]/20 px-2.5 py-1 rounded-full">
                Kurasi Syariah
            </span>
        </div>

        {{-- Form Unggah Karya --}}
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- 1. Area Unggah Foto Kompak & Bersih --}}
            <section class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-[13px] text-[#0f382c] font-semibold">Foto Karya <span class="text-red-500">*</span></label>
                    <span class="text-[11px] text-[#717975]">Maks. 10MB</span>
                </div>
                <div class="group relative border-2 border-dashed border-[#c1c8c3]/70 hover:border-[#0f382c] bg-white rounded-2xl p-5 text-center cursor-pointer transition-all hover:bg-[#f4f4f1] active:scale-[0.99] shadow-2xs">
                    <input accept="image/jpeg,image/png,image/webp"
                           aria-label="Pilih foto karya"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                           type="file"
                           name="image"
                           id="foto-karya">
                    <div class="flex flex-col items-center justify-center gap-1.5">
                        <div class="w-10 h-10 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#0f382c] group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[22px]">add_a_photo</span>
                        </div>
                        <p class="text-[12px] text-[#0f382c] font-semibold mt-1">Pilih Foto Karya</p>
                        <p class="text-[11px] text-[#717975]">JPG atau PNG beresolusi tinggi</p>
                    </div>
                </div>
            </section>

            {{-- 2. Input Judul Karya --}}
            <section class="space-y-1.5">
                <label class="block text-[13px] text-[#0f382c] font-semibold" for="judul-karya">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl px-3.5 py-2.5 text-[13px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#735c00]/20 transition-all shadow-2xs"
                       id="judul-karya"
                       name="title"
                       placeholder="Judul foto karya dakwah"
                       type="text">
            </section>

            {{-- 3. Pilihan Kategori Pills (Arsitektur, Alam, Kaligrafi, Kegiatan) --}}
            <section class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="block text-[13px] text-[#0f382c] font-semibold">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <span class="text-[11px] text-[#717975]">Pilih satu</span>
                </div>
                <input type="hidden" name="category" id="selected-category" value="Arsitektur">
                <div class="grid grid-cols-2 gap-2" id="kategori-container">
                    <button class="category-btn active flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-[#0f382c] bg-[#0f382c] text-white text-[12px] font-semibold transition-all shadow-xs"
                            type="button"
                            data-category="Arsitektur">
                        <span class="material-symbols-outlined text-[18px]">mosque</span>
                        <span class="truncate">Arsitektur</span>
                    </button>
                    <button class="category-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-[#c1c8c3]/50 bg-white text-[#1a1c1b] text-[12px] font-medium hover:bg-[#f4f4f1] transition-all"
                            type="button"
                            data-category="Alam">
                        <span class="material-symbols-outlined text-[18px] text-[#414845]">nature</span>
                        <span class="truncate">Alam</span>
                    </button>
                    <button class="category-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-[#c1c8c3]/50 bg-white text-[#1a1c1b] text-[12px] font-medium hover:bg-[#f4f4f1] transition-all"
                            type="button"
                            data-category="Kaligrafi">
                        <span class="material-symbols-outlined text-[18px] text-[#414845]">draw</span>
                        <span class="truncate">Kaligrafi</span>
                    </button>
                    <button class="category-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-[#c1c8c3]/50 bg-white text-[#1a1c1b] text-[12px] font-medium hover:bg-[#f4f4f1] transition-all"
                            type="button"
                            data-category="Kegiatan">
                        <span class="material-symbols-outlined text-[18px] text-[#414845]">groups</span>
                        <span class="truncate">Kegiatan</span>
                    </button>
                </div>
            </section>

            {{-- 4. Narasi Singkat --}}
            <section class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="block text-[13px] text-[#0f382c] font-semibold" for="narasi">
                        Narasi Singkat <span class="font-normal text-[#717975] text-[11px]">(Opsional)</span>
                    </label>
                    <span class="text-[11px] text-[#717975]">Maks. 250 kata</span>
                </div>
                <textarea class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl p-3 text-[13px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#735c00]/20 transition-all resize-none leading-relaxed shadow-2xs"
                          id="narasi"
                          name="narration"
                          placeholder="Cerita singkat atau hikmah foto..."
                          rows="2"></textarea>
            </section>

            {{-- 5. Ayat / Hadits Pendukung --}}
            <section class="space-y-1.5">
                <label class="block text-[13px] text-[#0f382c] font-semibold" for="dalil-pendukung">
                    Ayat / Hadits Pendukung <span class="font-normal text-[#717975] text-[11px]">(Opsional)</span>
                </label>
                <input class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl px-3.5 py-2.5 text-[13px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#735c00]/20 transition-all shadow-2xs"
                       id="dalil-pendukung"
                       name="quran_reference"
                       placeholder="Contoh: QS. An-Nur: 36"
                       type="text">
            </section>

            {{-- 6. Tombol Kirim / Unggah & Catatan Ringkas --}}
            <section class="space-y-2 pt-2">
                <button class="w-full h-12 bg-[#0f382c] text-white text-[13px] rounded-xl flex items-center justify-center gap-2 shadow-sm hover:bg-[#1a5c44] active:scale-[0.98] transition-all font-semibold"
                        type="submit">
                    <span class="material-symbols-outlined text-[20px]">upload</span>
                    Unggah Karya
                </button>
                <p class="text-center text-[11px] text-[#717975] font-normal">
                    Karya yang lolos kurasi akan ditampilkan di galeri publik.
                </p>
            </section>
        </form>

    </div>

    {{-- Script Interaksi Tombol Kategori --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const hiddenInput = document.getElementById('selected-category');

            categoryButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryButtons.forEach(b => {
                        b.classList.remove('bg-[#0f382c]', 'text-white', 'border-[#0f382c]', 'shadow-xs');
                        b.classList.add('bg-white', 'text-[#1a1c1b]', 'border-[#c1c8c3]/50');
                        const icon = b.querySelector('.material-symbols-outlined');
                        if (icon) {
                            icon.classList.remove('text-[#ffe088]');
                            icon.classList.add('text-[#414845]');
                        }
                    });

                    btn.classList.remove('bg-white', 'text-[#1a1c1b]', 'border-[#c1c8c3]/50');
                    btn.classList.add('bg-[#0f382c]', 'text-white', 'border-[#0f382c]', 'shadow-xs');
                    const icon = btn.querySelector('.material-symbols-outlined');
                    if (icon) {
                        icon.classList.remove('text-[#414845]');
                        icon.classList.add('text-[#ffe088]');
                    }

                    if (hiddenInput && btn.dataset.category) {
                        hiddenInput.value = btn.dataset.category;
                    }
                });
            });
        });
    </script>

</x-layouts.app>
