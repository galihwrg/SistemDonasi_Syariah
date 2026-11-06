<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $mahasiswa = User::where('user_type', 'mahasiswa')->first() ?? $admin;

        // Ambil kategori yang ada
        $catArsitektur = Category::where('slug', 'arsitektur')->first();
        $catAlam = Category::where('slug', 'alam-tadabbur')->first() ?? Category::where('slug', 'alam')->first();
        $catKegiatan = Category::where('slug', 'kegiatan-umat')->first() ?? Category::where('slug', 'kegiatan')->first();
        $catKaligrafi = Category::where('slug', 'kaligrafi')->first();

        $sampleArtworks = [
            [
                'user_id' => $mahasiswa->id,
                'category_id' => $catKegiatan?->id ?? 1,
                'title' => 'Kebersamaan Subuh & Ukhuwah di Pelataran Masjid',
                'slug' => 'kebersamaan-subuh-ukhuwah-pelataran-masjid',
                'narration' => "Ketika fajar menyingsing di atas pilar-pilar kokoh pelataran Nabawi, terpaan cahaya keemasan mengingatkan kita akan fitrah ketenangan sejati. Di sanalah ribuan wajah dengan ragam bahasa dan bangsa berkumpul dalam satu saf, membasahi lisan dengan zikir yang sama, dan menanggalkan segala keakuan duniawi.\n\nPotret ini menangkap denyut ukhuwah islamiyah yang murni—sebuah pengingat bahwa di tengah riuhnya zaman, ada kedamaian abadi yang selalu menanti saat seorang hamba menundukkan kening dan membuka tangan menyambut rahmat-Nya di awal hari.",
                'quran_reference' => 'QS. Al-Hujurat: 10',
                'quran_arabic' => 'إِنَّمَا الْمُؤْمِنُونَ إِخْوَةٌ فَأَصْلِحُوا بَيْنَ أَخَوَيْكُمْ ۚ وَاتَّقُوا اللَّهَ لَعَلَّكُمْ تُرْحَمُونَ',
                'quran_translation' => 'Sesungguhnya orang-orang mukmin itu bersaudara, karena itu damaikanlah antara kedua saudaramu (yang berselisih) dan bertakwalah kepada Allah agar kamu mendapat rahmat.',
                'image_path' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 890,
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catArsitektur?->id ?? 1,
                'title' => 'Simetri dan Keagungan Lengkung Pilar Masjid Nabawi',
                'slug' => 'simetri-keagungan-lengkung-pilar-masjid-nabawi',
                'narration' => "Kemegahan arsitektur Islam tidak sekadar memanjakan mata, melainkan manifestasi ketertiban, kesucian, dan penghambaan kepada Sang Maha Pencipta. Lengkung pilar dengan ornamen emas memantulkan cahaya fajar yang menyejukkan hati siapa pun yang berteduh di bawahnya.",
                'quran_reference' => 'QS. An-Nur: 36',
                'quran_arabic' => 'فِي بُيُوتٍ أَذِنَ اللَّهُ أَن تُرْفَعَ وَيُذْكَرَ فِيهَا اسْمُهُ يُسَبِّحُ لَهُ فِيهَا بِالْغُدُوِّ وَالْآصَالِ',
                'quran_translation' => 'Bertasbihlah kepada Allah di masjid-masjid yang telah diperintahkan untuk dimuliakan dan disebut nama-Nya di dalamnya, pada waktu pagi dan petang.',
                'image_path' => 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 1400,
            ],
            [
                'user_id' => $mahasiswa->id,
                'category_id' => $catAlam?->id ?? 2,
                'title' => 'Kabut Pagi & Tadabbur Ciptaan di Lembah Bromo',
                'slug' => 'kabut-pagi-tadabbur-ciptaan-lembah-bromo',
                'narration' => "Menyaksikan hamparan kabut yang menutupi lembah di waktu syuruq menghadirkan rasa takjub yang mendalam. Betapa kecilnya manusia di hadapan semesta ciptaan Allah, dan betapa luasnya karunia yang dihamparkan untuk mereka yang mau berpikir.",
                'quran_reference' => 'QS. Ali \'Imran: 191',
                'quran_arabic' => 'الَّذِينَ يَذْكُرُونَ اللَّهَ قِيَامًا وَقُعُودًا وَعَلَىٰ جُنُوبِهِمْ وَيَتَفَكَّرُونَ فِي خَلْقِ السَّمَاوَاتِ وَالْأَرْضِ رَبَّنَا مَا خَلَقْتَ هَٰذَا بَاطِلًا سُبْحَانَكَ فَقِنَا عَذَابَ النَّارِ',
                'quran_translation' => '(yaitu) orang-orang yang mengingat Allah sambil berdiri atau duduk atau dalam keadaan berbaring dan mereka memikirkan tentang penciptaan langit dan bumi (seraya berkata): Ya Tuhan kami, tidaklah Engkau menciptakan semua ini sia-sia; Maha Suci Engkau, peliharalah kami dari siksa neraka.',
                'image_path' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 620,
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catKaligrafi?->id ?? 3,
                'title' => 'Lafaz Basmalah Kaligrafi Thuluth Tradisional',
                'slug' => 'lafaz-basmalah-kaligrafi-thuluth-tradisional',
                'narration' => "Goresan pena khatat di atas kanvas dengan tinta emas tradisional melambangkan permulaan setiap amal kebaikan dengan menyebut nama Allah yang Maha Pengasih lagi Maha Penyayang.",
                'quran_reference' => 'QS. Al-Fatihah: 1',
                'quran_arabic' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
                'quran_translation' => 'Dengan menyebut nama Allah Yang Maha Pengasih lagi Maha Penyayang.',
                'image_path' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 2300,
            ],
            [
                'user_id' => $mahasiswa->id,
                'category_id' => $catKegiatan?->id ?? 1,
                'title' => 'Lentera Berkah & Manisnya Waktu Berbuka',
                'slug' => 'lentera-berkah-manisnya-waktu-berbuka',
                'narration' => "Cahaya lentera temaram dan butiran kurma menanti azan magrib berkumandang. Momen kebersamaan yang senantiasa dinanti dalam bulan penuh ampunan dan rahmat.",
                'quran_reference' => 'QS. Al-Baqarah: 185',
                'quran_arabic' => 'شَهْرُ رَمَضَانَ الَّذِي أُنزِلَ فِيهِ الْقُرْآنُ هُدًى لِّلنَّاسِ وَبَيِّنَاتٍ مِّنَ الْهُدَىٰ وَالْفُرْقَانِ',
                'quran_translation' => 'Bulan Ramadan adalah (bulan) yang di dalamnya diturunkan Al-Qur\'an, sebagai petunjuk bagi manusia dan penjelasan-penjelasan mengenai petunjuk itu dan pembeda.',
                'image_path' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 745,
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catKegiatan?->id ?? 1,
                'title' => 'Semangat Pemuda Pelopor dalam Halaqah Ilmu',
                'slug' => 'semangat-pemuda-pelopor-dalam-halaqah-ilmu',
                'narration' => "Di perpustakaan masjid berlantai kayu yang sejuk, para mahasiswa dan pemuda melingkar dalam halaqah keilmuan, saling mengkaji mushaf dan meneguhkan komitmen untuk kemajuan umat.",
                'quran_reference' => 'QS. Al-Mujadilah: 11',
                'quran_arabic' => 'يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ ۚ وَاللَّهُ بِمَا تَعْمَلُونَ خَبِيرٌ',
                'quran_translation' => 'Allah akan meninggikan orang-orang yang beriman di antaramu dan orang-orang yang diberi ilmu pengetahuan beberapa derajat.',
                'image_path' => 'https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=1200&q=80',
                'dimensions' => '3840 x 2160 px',
                'status' => 'approved',
                'download_count' => 512,
            ],
        ];

        foreach ($sampleArtworks as $art) {
            Artwork::updateOrCreate(
                ['slug' => $art['slug']],
                $art
            );
        }
    }
}
