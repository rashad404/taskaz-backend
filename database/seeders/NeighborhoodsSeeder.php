<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NeighborhoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $neighborhoods = [
            // Bakı (city_id will be 1 as it's the first city in CitiesSeeder)
            ['city_id' => 1, 'name_az' => 'Nəsimi', 'name_en' => 'Nasimi', 'name_ru' => 'Насими', 'sort_order' => 1],
            ['city_id' => 1, 'name_az' => 'Nərimanov', 'name_en' => 'Narimanov', 'name_ru' => 'Нариманов', 'sort_order' => 2],
            ['city_id' => 1, 'name_az' => 'Yasamal', 'name_en' => 'Yasamal', 'name_ru' => 'Ясамал', 'sort_order' => 3],
            ['city_id' => 1, 'name_az' => 'Sabunçu', 'name_en' => 'Sabunchu', 'name_ru' => 'Сабунчу', 'sort_order' => 4],
            ['city_id' => 1, 'name_az' => 'Səbail', 'name_en' => 'Sabail', 'name_ru' => 'Сабаил', 'sort_order' => 5],
            ['city_id' => 1, 'name_az' => 'Xətai', 'name_en' => 'Khatai', 'name_ru' => 'Хатаи', 'sort_order' => 6],
            ['city_id' => 1, 'name_az' => 'Suraxanı', 'name_en' => 'Surakhani', 'name_ru' => 'Сураханы', 'sort_order' => 7],
            ['city_id' => 1, 'name_az' => 'Binəqədi', 'name_en' => 'Binagadi', 'name_ru' => 'Бинагади', 'sort_order' => 8],
            ['city_id' => 1, 'name_az' => 'Xəzər', 'name_en' => 'Khazar', 'name_ru' => 'Хазар', 'sort_order' => 9],
            ['city_id' => 1, 'name_az' => 'Qaradağ', 'name_en' => 'Garadag', 'name_ru' => 'Карадаг', 'sort_order' => 10],
            ['city_id' => 1, 'name_az' => 'Pirallahı', 'name_en' => 'Pirallahi', 'name_ru' => 'Пираллахи', 'sort_order' => 11],
            ['city_id' => 1, 'name_az' => 'Abşeron', 'name_en' => 'Absheron', 'name_ru' => 'Апшерон', 'sort_order' => 12],
        ];

        foreach ($neighborhoods as $neighborhood) {
            \App\Models\Neighborhood::create($neighborhood);
        }
    }
}
