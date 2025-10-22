<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            // Bakı administrative districts (rayonlar) - city_id will be 1 as it's the first city in CitiesSeeder
            ['city_id' => 1, 'name_az' => 'Abşeron rayonu', 'name_en' => 'Absheron District', 'name_ru' => 'Апшеронский район', 'sort_order' => 1],
            ['city_id' => 1, 'name_az' => 'Binəqədi rayonu', 'name_en' => 'Binagadi District', 'name_ru' => 'Бинагадинский район', 'sort_order' => 2],
            ['city_id' => 1, 'name_az' => 'Xətai rayonu', 'name_en' => 'Khatai District', 'name_ru' => 'Хатаинский район', 'sort_order' => 3],
            ['city_id' => 1, 'name_az' => 'Xəzər rayonu', 'name_en' => 'Khazar District', 'name_ru' => 'Хазарский район', 'sort_order' => 4],
            ['city_id' => 1, 'name_az' => 'Qaradağ rayonu', 'name_en' => 'Garadag District', 'name_ru' => 'Карадагский район', 'sort_order' => 5],
            ['city_id' => 1, 'name_az' => 'Nərimanov rayonu', 'name_en' => 'Narimanov District', 'name_ru' => 'Наримановский район', 'sort_order' => 6],
            ['city_id' => 1, 'name_az' => 'Nəsimi rayonu', 'name_en' => 'Nasimi District', 'name_ru' => 'Насиминский район', 'sort_order' => 7],
            ['city_id' => 1, 'name_az' => 'Nizami rayonu', 'name_en' => 'Nizami District', 'name_ru' => 'Низаминский район', 'sort_order' => 8],
            ['city_id' => 1, 'name_az' => 'Pirallahı rayonu', 'name_en' => 'Pirallahi District', 'name_ru' => 'Пираллахинский район', 'sort_order' => 9],
            ['city_id' => 1, 'name_az' => 'Sabunçu rayonu', 'name_en' => 'Sabunchu District', 'name_ru' => 'Сабунчинский район', 'sort_order' => 10],
            ['city_id' => 1, 'name_az' => 'Səbail rayonu', 'name_en' => 'Sabail District', 'name_ru' => 'Сабаильский район', 'sort_order' => 11],
            ['city_id' => 1, 'name_az' => 'Suraxanı rayonu', 'name_en' => 'Surakhani District', 'name_ru' => 'Сураханский район', 'sort_order' => 12],
            ['city_id' => 1, 'name_az' => 'Yasamal rayonu', 'name_en' => 'Yasamal District', 'name_ru' => 'Ясамальский район', 'sort_order' => 13],
        ];

        foreach ($districts as $district) {
            \App\Models\District::create($district);
        }
    }
}
