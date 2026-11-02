<x-layouts.app title="Unggah Karya Visual — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Header Title --}}
        <div>
            <h1 class="text-xl font-bold font-serif text-[#0F382C]">
                Unggah Karya Visual
            </h1>
            <p class="text-xs text-[#6B7280] mt-0.5">
                Bagikan karya visual dakwah terbaik Anda untuk umat
            </p>
        </div>

        {{-- Upload Area Placeholder --}}
        <div class="border-2 border-dashed border-[#A5D6A7] rounded-3xl p-6 text-center bg-[#F9F9F6] hover:bg-[#E8F5E9]/40 transition-colors cursor-pointer">
            <div class="w-12 h-12 mx-auto rounded-full bg-[#E8F5E9] text-[#0F382C] flex items-center justify-center mb-3 shadow-2xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-[#0F382C]">
                Sentuh untuk Memilih Foto
            </p>
            <p class="text-[10px] text-[#6B7280] mt-1">
                Format JPG, PNG, WEBP (Maksimal 10MB)
            </p>
        </div>

        {{-- Notice / Info Box --}}
        <div class="p-3.5 rounded-2xl bg-[#E8F5E9] border border-[#A5D6A7]/60 text-[#0F382C] text-xs">
            <div class="flex items-start gap-2">
                <span class="text-sm">ℹ️</span>
                <p class="leading-relaxed text-[11px]">
                    Karya yang diunggah akan melalui proses kurasi santun oleh admin Kuantum Pelopor Indonesia sebelum dipublikasikan.
                </p>
            </div>
        </div>

        {{-- Form Teaser --}}
        <div class="space-y-3">
            <div>
                <label class="block text-xs font-semibold text-[#0F382C] mb-1">Judul Karya</label>
                <input type="text" placeholder="Contoh: Senja di Masjid Raya"
                       class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-white border border-[#E5E7EB] outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#0F382C] mb-1">Kategori</label>
                <select class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-white border border-[#E5E7EB] outline-none">
                    <option value="">Pilih Kategori...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

</x-layouts.app>
