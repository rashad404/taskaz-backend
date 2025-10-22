<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetroStation;

class MetroStationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metroStations = [
            // All Baku metro stations (city_id: 1 for Bakı)
            ['city_id' => 1, 'name_az' => '28 May', 'name_en' => '28 May', 'name_ru' => '28 мая', 'sort_order' => 1],
            ['city_id' => 1, 'name_az' => '8 Noyabr', 'name_en' => '8 November', 'name_ru' => '8 ноября', 'sort_order' => 2],
            ['city_id' => 1, 'name_az' => 'Avtovağzal', 'name_en' => 'Bus Station', 'name_ru' => 'Автовокзал', 'sort_order' => 3],
            ['city_id' => 1, 'name_az' => 'Azadlıq Prospekti', 'name_en' => 'Azadlig Avenue', 'name_ru' => 'проспект Азадлыг', 'sort_order' => 4],
            ['city_id' => 1, 'name_az' => 'Bakmil', 'name_en' => 'Bakmil', 'name_ru' => 'Бакмил', 'sort_order' => 5],
            ['city_id' => 1, 'name_az' => 'Dərnəgül', 'name_en' => 'Darnagul', 'name_ru' => 'Дарнагюль', 'sort_order' => 6],
            ['city_id' => 1, 'name_az' => 'Elmlər Akademiyası', 'name_en' => 'Academy of Sciences', 'name_ru' => 'Академия наук', 'sort_order' => 7],
            ['city_id' => 1, 'name_az' => 'Əhmədli', 'name_en' => 'Ahmadli', 'name_ru' => 'Ахмедли', 'sort_order' => 8],
            ['city_id' => 1, 'name_az' => 'Gənclik', 'name_en' => 'Ganjlik', 'name_ru' => 'Генджлик', 'sort_order' => 9],
            ['city_id' => 1, 'name_az' => 'Həzi Aslanov', 'name_en' => 'Hazi Aslanov', 'name_ru' => 'Гази Асланов', 'sort_order' => 10],
            ['city_id' => 1, 'name_az' => 'Xalqlar Dostluğu', 'name_en' => 'Friendship of Nations', 'name_ru' => 'Дружба народов', 'sort_order' => 11],
            ['city_id' => 1, 'name_az' => 'Xocəsən', 'name_en' => 'Khojasan', 'name_ru' => 'Ходжасан', 'sort_order' => 12],
            ['city_id' => 1, 'name_az' => 'İçəri Şəhər', 'name_en' => 'Old City', 'name_ru' => 'Ичери Шехер', 'sort_order' => 13],
            ['city_id' => 1, 'name_az' => 'İnşaatçılar', 'name_en' => 'Builders', 'name_ru' => 'Иншаатчылар', 'sort_order' => 14],
            ['city_id' => 1, 'name_az' => 'Koroğlu', 'name_en' => 'Koroglu', 'name_ru' => 'Кёроглу', 'sort_order' => 15],
            ['city_id' => 1, 'name_az' => 'Qara Qarayev', 'name_en' => 'Gara Garayev', 'name_ru' => 'Кара Караев', 'sort_order' => 16],
            ['city_id' => 1, 'name_az' => 'Memar Əcəmi', 'name_en' => 'Memar Ajami', 'name_ru' => 'Мемар Аджеми', 'sort_order' => 17],
            ['city_id' => 1, 'name_az' => 'Neftçilər', 'name_en' => 'Oilmen', 'name_ru' => 'Нефтчиляр', 'sort_order' => 18],
            ['city_id' => 1, 'name_az' => 'Nəriman Nərimanov', 'name_en' => 'Nariman Narimanov', 'name_ru' => 'Нариман Нариманов', 'sort_order' => 19],
            ['city_id' => 1, 'name_az' => 'Nəsimi', 'name_en' => 'Nasimi', 'name_ru' => 'Насими', 'sort_order' => 20],
            ['city_id' => 1, 'name_az' => 'Nizami', 'name_en' => 'Nizami', 'name_ru' => 'Низами', 'sort_order' => 21],
            ['city_id' => 1, 'name_az' => 'Sahil', 'name_en' => 'Sahil', 'name_ru' => 'Сахил', 'sort_order' => 22],
            ['city_id' => 1, 'name_az' => 'Şah İsmayıl Xətai', 'name_en' => 'Shah Ismail Khatai', 'name_ru' => 'Шах Исмаил Хатаи', 'sort_order' => 23],
            ['city_id' => 1, 'name_az' => 'Ulduz', 'name_en' => 'Ulduz', 'name_ru' => 'Ульдуз', 'sort_order' => 24],
        ];

        foreach ($metroStations as $station) {
            MetroStation::create($station);
        }
    }
}
