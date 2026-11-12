<x-layouts.app title="Unggah Karya Visual — Kuantum Pelopor Indonesia" :hide-bottom-nav="true">

    <div class="px-4 py-4 space-y-4 max-w-lg mx-auto">

        {{-- Top Title & Close Button Bar (Sesuai Stitch) --}}
        <div class="flex items-center justify-between pb-3 border-b border-[#dadad7]/50">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
                   aria-label="Tutup formulir"
                   class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#1a1c1b] hover:bg-[#e2e3e0] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
                <div>
                    <h1 class="font-serif text-[18px] text-[#0f382c] tracking-tight font-bold">
                        Unggah Karya Visual
                    </h1>
                    <p class="text-[11px] text-[#414845]">Persembahan wakaf visual dakwah Islam</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-[#735c00] bg-[#fed65b]/30 border border-[#fed65b]/60 px-2.5 py-1 rounded-full">
                Kurasi Syariah
            </span>
        </div>

        {{-- Flash Error Messages --}}
        @if ($errors->any())
            <div class="rounded-xl p-3 bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">error</span>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        {{-- Form Unggah Karya --}}
        <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- 1. Area Unggah Foto Kompak & Bersih --}}
            <section class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-[13px] text-[#0f382c] font-semibold">Foto Karya <span class="text-red-500">*</span></label>
                    <span class="text-[11px] text-[#717975]">JPG, PNG, WEBP (Maks. 10MB)</span>
                </div>
                
                {{-- Dropzone / Upload Box --}}
                <div id="dropzone"
                     class="group relative border-2 border-dashed border-[#c1c8c3]/80 hover:border-[#0f382c] bg-white rounded-2xl p-5 text-center cursor-pointer transition-all hover:bg-[#f4f4f1] active:scale-[0.99] shadow-2xs overflow-hidden">
                    <input accept="image/jpeg,image/png,image/webp"
                           aria-label="Pilih foto karya"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-20"
                           type="file"
                           name="image"
                           id="foto-karya"
                           required
                           onchange="previewUploadedImage(this)">
                    
                    {{-- Default State --}}
                    <div id="upload-prompt" class="flex flex-col items-center justify-center gap-1.5 py-2">
                        <div class="w-12 h-12 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#0f382c] group-hover:scale-105 transition-transform shadow-xs">
                            <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                        </div>
                        <p class="text-[13px] text-[#0f382c] font-semibold mt-1">Pilih atau Tarik Foto Karya</p>
                        <p class="text-[11px] text-[#717975]">Format foto resolusi tinggi berkualitas prima</p>
                    </div>

                    {{-- Image Preview State (Hidden by default) --}}
                    <div id="image-preview-container" class="hidden relative w-full aspect-video rounded-xl overflow-hidden bg-gray-100">
                        <img id="image-preview" src="#" alt="Pratinjau Foto" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="px-3 py-1.5 rounded-lg bg-white/90 text-[#0f382c] text-xs font-semibold shadow-xs">
                                Ganti Foto
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 2. Input Judul Karya --}}
            <section class="space-y-1.5">
                <label class="block text-[13px] text-[#0f382c] font-semibold" for="judul-karya">
                    Judul Karya <span class="text-red-500">*</span>
                </label>
                <input class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl px-3.5 py-2.5 text-[13px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#735c00]/20 transition-all shadow-2xs"
                       id="judul-karya"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Contoh: Kehangatan Subuh di Pelataran Nabawi"
                       required
                       type="text">
            </section>

            {{-- 3. Pilihan Kategori Pills Berbasis Kategori Nyata --}}
            <section class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="block text-[13px] text-[#0f382c] font-semibold">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <span class="text-[11px] text-[#717975]">Pilih salah satu</span>
                </div>
                
                @php
                    $defaultCatId = old('category_id', $categories->first()->id ?? 1);
                @endphp
                <input type="hidden" name="category_id" id="selected-category-id" value="{{ $defaultCatId }}">

                <div class="grid grid-cols-2 gap-2" id="kategori-container">
                    @foreach ($categories as $cat)
                        @php
                            $isSelected = ($defaultCatId == $cat->id);
                            $icon = match(strtolower($cat->slug)) {
                                'arsitektur', 'arsitektur-masjid' => 'mosque',
                                'alam', 'alam-tadabbur' => 'nature',
                                'kaligrafi' => 'draw',
                                'kegiatan', 'kegiatan-umat' => 'groups',
                                'ramadhan' => 'nights_stay',
                                default => 'photo_library',
                            };
                        @endphp
                        <button type="button"
                                data-cat-id="{{ $cat->id }}"
                                onclick="selectCategory({{ $cat->id }}, this)"
                                class="category-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border text-[12px] font-semibold transition-all shadow-2xs {{ $isSelected ? 'bg-[#0f382c] text-white border-[#0f382c] shadow-xs' : 'bg-white text-[#1a1c1b] border-[#c1c8c3]/60 hover:bg-[#f4f4f1]' }}">
                            <span class="material-symbols-outlined text-[18px] {{ $isSelected ? 'text-[#fed65b]' : 'text-[#717975]' }}">
                                {{ $icon }}
                            </span>
                            <span class="truncate">{{ $cat->name }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            {{-- 4. Narasi Singkat / Refleksi Hikmah --}}
            <section class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="block text-[13px] text-[#0f382c] font-semibold" for="narasi">
                        Refleksi &amp; Narasi Hikmah <span class="font-normal text-[#717975] text-[11px]">(Opsional)</span>
                    </label>
                    <span class="text-[11px] text-[#717975]">Maks. 1.500 karakter</span>
                </div>
                <textarea class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl p-3 text-[13px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#735c00]/20 transition-all resize-none leading-relaxed shadow-2xs"
                          id="narasi"
                          name="narration"
                          placeholder="Tuliskan renungan, momen spiritual, atau hikmah di balik karya visual ini..."
                          rows="3">{{ old('narration') }}</textarea>
            </section>

            {{-- 5. Rujukan Ayat / Hadits Pendukung --}}
            <section class="space-y-2 bg-[#f4f4f1] p-3.5 rounded-2xl border border-[#c1c8c3]/40">
                <div class="flex items-center gap-1.5 text-[11px] text-[#735c00] font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    <span>Dalil Al-Qur'an / Hadits (Opsional)</span>
                </div>

                <div>
                    <label class="block text-[11px] text-[#414845] font-semibold mb-1" for="dalil-pendukung">Rujukan Surah / Hadits</label>
                    <input class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl px-3 py-2 text-[12px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#735c00]/20 transition-all shadow-2xs"
                           id="dalil-pendukung"
                           name="quran_reference"
                           value="{{ old('quran_reference') }}"
                           placeholder="Contoh: QS. Al-Hujurat: 10 atau HR. Bukhari"
                           type="text">
                </div>

                <div>
                    <label class="block text-[11px] text-[#414845] font-semibold mb-1" for="quran-arabic">Teks Arab (Opsional)</label>
                    <input class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl px-3 py-2 text-[13px] text-right text-[#0f382c] font-serif placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#735c00]/20 transition-all shadow-2xs"
                           id="quran-arabic"
                           name="quran_arabic"
                           dir="rtl"
                           value="{{ old('quran_arabic') }}"
                           placeholder="إِنَّمَا الْمُؤْمِنُونَ إِخْوَةٌ..."
                           type="text">
                </div>

                <div>
                    <label class="block text-[11px] text-[#414845] font-semibold mb-1" for="quran-trans">Terjemahan Bahasa Indonesia (Opsional)</label>
                    <textarea class="w-full bg-white border border-[#c1c8c3]/70 rounded-xl p-2.5 text-[12px] text-[#1a1c1b] placeholder:text-[#717975] focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#735c00]/20 transition-all resize-none shadow-2xs"
                              id="quran-trans"
                              name="quran_translation"
                              placeholder="Arti terjemahan ayat..."
                              rows="2">{{ old('quran_translation') }}</textarea>
                </div>
            </section>

            {{-- 6. Tombol Kirim / Unggah & Catatan Transparansi --}}
            <section class="space-y-2 pt-2 pb-6">
                <button class="w-full h-12 bg-[#0f382c] text-white text-[13px] rounded-xl flex items-center justify-center gap-2 shadow-sm hover:bg-[#1a5c44] active:scale-[0.98] transition-all font-semibold"
                        type="submit">
                    <span class="material-symbols-outlined text-[20px] text-[#fed65b]">upload</span>
                    <span>Unggah Karya Dakwah</span>
                </button>
                <p class="text-center text-[11px] text-[#717975] leading-relaxed px-2">
                    Karya yang diunggah akan masuk antrean kurasi admin terlebih dahulu untuk memastikan kesesuaian etika syariah sebelum diterbitkan ke galeri publik.
                </p>
            </section>
        </form>

    </div>

    {{-- Script Pratinjau Foto & Kategori --}}
    <script>
        function previewUploadedImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('upload-prompt').classList.add('hidden');
                    document.getElementById('image-preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function selectCategory(id, btn) {
            document.getElementById('selected-category-id').value = id;
            
            document.querySelectorAll('.category-btn').forEach(b => {
                b.classList.remove('bg-[#0f382c]', 'text-white', 'border-[#0f382c]', 'shadow-xs');
                b.classList.add('bg-white', 'text-[#1a1c1b]', 'border-[#c1c8c3]/60');
                const icon = b.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.classList.remove('text-[#fed65b]');
                    icon.classList.add('text-[#717975]');
                }
            });

            btn.classList.remove('bg-white', 'text-[#1a1c1b]', 'border-[#c1c8c3]/60');
            btn.classList.add('bg-[#0f382c]', 'text-white', 'border-[#0f382c]', 'shadow-xs');
            const activeIcon = btn.querySelector('.material-symbols-outlined');
            if (activeIcon) {
                activeIcon.classList.remove('text-[#717975]');
                activeIcon.classList.add('text-[#fed65b]');
            }
        }
    </script>

</x-layouts.app>
