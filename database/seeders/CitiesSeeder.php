<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Major cities - sorted by importance
            ['name_az' => 'Bakı', 'name_en' => 'Baku', 'name_ru' => 'Баку', 'has_neighborhoods' => true, 'sort_order' => 1],
            ['name_az' => 'Gəncə', 'name_en' => 'Ganja', 'name_ru' => 'Гянджа', 'has_neighborhoods' => false, 'sort_order' => 2],
            ['name_az' => 'Sumqayıt', 'name_en' => 'Sumgayit', 'name_ru' => 'Сумгаит', 'has_neighborhoods' => false, 'sort_order' => 3],
            ['name_az' => 'Mingəçevir', 'name_en' => 'Mingachevir', 'name_ru' => 'Мингячевир', 'has_neighborhoods' => false, 'sort_order' => 4],
            ['name_az' => 'Lənkəran', 'name_en' => 'Lankaran', 'name_ru' => 'Ленкорань', 'has_neighborhoods' => false, 'sort_order' => 5],
            ['name_az' => 'Şirvan', 'name_en' => 'Shirvan', 'name_ru' => 'Ширван', 'has_neighborhoods' => false, 'sort_order' => 6],
            ['name_az' => 'Naxçıvan', 'name_en' => 'Nakhchivan', 'name_ru' => 'Нахчыван', 'has_neighborhoods' => false, 'sort_order' => 7],
            ['name_az' => 'Şəki', 'name_en' => 'Shaki', 'name_ru' => 'Шеки', 'has_neighborhoods' => false, 'sort_order' => 8],
            ['name_az' => 'Yevlax', 'name_en' => 'Yevlakh', 'name_ru' => 'Евлах', 'has_neighborhoods' => false, 'sort_order' => 9],
            ['name_az' => 'Qəbələ', 'name_en' => 'Gabala', 'name_ru' => 'Габала', 'has_neighborhoods' => false, 'sort_order' => 10],

            // Administrative regions
            ['name_az' => 'Ağdam', 'name_en' => 'Agdam', 'name_ru' => 'Агдам', 'has_neighborhoods' => false, 'sort_order' => 11],
            ['name_az' => 'Ağdaş', 'name_en' => 'Agdash', 'name_ru' => 'Агдаш', 'has_neighborhoods' => false, 'sort_order' => 12],
            ['name_az' => 'Ağcabədi', 'name_en' => 'Aghjabadi', 'name_ru' => 'Агджабеди', 'has_neighborhoods' => false, 'sort_order' => 13],
            ['name_az' => 'Ağstafa', 'name_en' => 'Agstafa', 'name_ru' => 'Агстафа', 'has_neighborhoods' => false, 'sort_order' => 14],
            ['name_az' => 'Ağsu', 'name_en' => 'Agsu', 'name_ru' => 'Агсу', 'has_neighborhoods' => false, 'sort_order' => 15],
            ['name_az' => 'Astara', 'name_en' => 'Astara', 'name_ru' => 'Астара', 'has_neighborhoods' => false, 'sort_order' => 16],
            ['name_az' => 'Balakən', 'name_en' => 'Balakan', 'name_ru' => 'Балакен', 'has_neighborhoods' => false, 'sort_order' => 17],
            ['name_az' => 'Bərdə', 'name_en' => 'Barda', 'name_ru' => 'Барда', 'has_neighborhoods' => false, 'sort_order' => 18],
            ['name_az' => 'Beyləqan', 'name_en' => 'Beylagan', 'name_ru' => 'Бейлаган', 'has_neighborhoods' => false, 'sort_order' => 19],
            ['name_az' => 'Biləsuvar', 'name_en' => 'Bilasuvar', 'name_ru' => 'Билясувар', 'has_neighborhoods' => false, 'sort_order' => 20],
            ['name_az' => 'Cəbrayıl', 'name_en' => 'Jabrayil', 'name_ru' => 'Джебраил', 'has_neighborhoods' => false, 'sort_order' => 21],
            ['name_az' => 'Cəlilabad', 'name_en' => 'Jalilabad', 'name_ru' => 'Джалилабад', 'has_neighborhoods' => false, 'sort_order' => 22],
            ['name_az' => 'Daşkəsən', 'name_en' => 'Dashkasan', 'name_ru' => 'Дашкесан', 'has_neighborhoods' => false, 'sort_order' => 23],
            ['name_az' => 'Füzuli', 'name_en' => 'Fizuli', 'name_ru' => 'Физули', 'has_neighborhoods' => false, 'sort_order' => 24],
            ['name_az' => 'Gədəbəy', 'name_en' => 'Gadabay', 'name_ru' => 'Гедабек', 'has_neighborhoods' => false, 'sort_order' => 25],
            ['name_az' => 'Goranboy', 'name_en' => 'Goranboy', 'name_ru' => 'Геранбой', 'has_neighborhoods' => false, 'sort_order' => 26],
            ['name_az' => 'Göyçay', 'name_en' => 'Goychay', 'name_ru' => 'Гейчай', 'has_neighborhoods' => false, 'sort_order' => 27],
            ['name_az' => 'Göygöl', 'name_en' => 'Goygol', 'name_ru' => 'Гёйгёль', 'has_neighborhoods' => false, 'sort_order' => 28],
            ['name_az' => 'Hacıqabul', 'name_en' => 'Hajigabul', 'name_ru' => 'Хаджикабул', 'has_neighborhoods' => false, 'sort_order' => 29],
            ['name_az' => 'İmişli', 'name_en' => 'Imishli', 'name_ru' => 'Имишли', 'has_neighborhoods' => false, 'sort_order' => 30],
            ['name_az' => 'İsmayıllı', 'name_en' => 'Ismayilli', 'name_ru' => 'Исмаиллы', 'has_neighborhoods' => false, 'sort_order' => 31],
            ['name_az' => 'Kəlbəcər', 'name_en' => 'Kalbajar', 'name_ru' => 'Кельбаджар', 'has_neighborhoods' => false, 'sort_order' => 32],
            ['name_az' => 'Kürdəmir', 'name_en' => 'Kurdamir', 'name_ru' => 'Кюрдамир', 'has_neighborhoods' => false, 'sort_order' => 33],
            ['name_az' => 'Laçın', 'name_en' => 'Lachin', 'name_ru' => 'Лачин', 'has_neighborhoods' => false, 'sort_order' => 34],
            ['name_az' => 'Lerik', 'name_en' => 'Lerik', 'name_ru' => 'Лерик', 'has_neighborhoods' => false, 'sort_order' => 35],
            ['name_az' => 'Masallı', 'name_en' => 'Masally', 'name_ru' => 'Масаллы', 'has_neighborhoods' => false, 'sort_order' => 36],
            ['name_az' => 'Neftçala', 'name_en' => 'Neftchala', 'name_ru' => 'Нефтчала', 'has_neighborhoods' => false, 'sort_order' => 37],
            ['name_az' => 'Oğuz', 'name_en' => 'Oguz', 'name_ru' => 'Огуз', 'has_neighborhoods' => false, 'sort_order' => 38],
            ['name_az' => 'Qax', 'name_en' => 'Gakh', 'name_ru' => 'Гах', 'has_neighborhoods' => false, 'sort_order' => 39],
            ['name_az' => 'Qazax', 'name_en' => 'Gazakh', 'name_ru' => 'Газах', 'has_neighborhoods' => false, 'sort_order' => 40],
            ['name_az' => 'Qobustan', 'name_en' => 'Gobustan', 'name_ru' => 'Гобустан', 'has_neighborhoods' => false, 'sort_order' => 41],
            ['name_az' => 'Quba', 'name_en' => 'Guba', 'name_ru' => 'Губа', 'has_neighborhoods' => false, 'sort_order' => 42],
            ['name_az' => 'Qubadlı', 'name_en' => 'Gubadly', 'name_ru' => 'Кубадлы', 'has_neighborhoods' => false, 'sort_order' => 43],
            ['name_az' => 'Qusar', 'name_en' => 'Gusar', 'name_ru' => 'Гусар', 'has_neighborhoods' => false, 'sort_order' => 44],
            ['name_az' => 'Saatlı', 'name_en' => 'Saatly', 'name_ru' => 'Саатлы', 'has_neighborhoods' => false, 'sort_order' => 45],
            ['name_az' => 'Sabirabad', 'name_en' => 'Sabirabad', 'name_ru' => 'Сабирабад', 'has_neighborhoods' => false, 'sort_order' => 46],
            ['name_az' => 'Salyan', 'name_en' => 'Salyan', 'name_ru' => 'Сальян', 'has_neighborhoods' => false, 'sort_order' => 47],
            ['name_az' => 'Şamaxı', 'name_en' => 'Shamakhi', 'name_ru' => 'Шемаха', 'has_neighborhoods' => false, 'sort_order' => 48],
            ['name_az' => 'Şəmkir', 'name_en' => 'Shamkir', 'name_ru' => 'Шамкир', 'has_neighborhoods' => false, 'sort_order' => 49],
            ['name_az' => 'Siyəzən', 'name_en' => 'Siyazan', 'name_ru' => 'Сиязань', 'has_neighborhoods' => false, 'sort_order' => 50],
            ['name_az' => 'Şuşa', 'name_en' => 'Shusha', 'name_ru' => 'Шуша', 'has_neighborhoods' => false, 'sort_order' => 51],
            ['name_az' => 'Tərtər', 'name_en' => 'Tartar', 'name_ru' => 'Тертер', 'has_neighborhoods' => false, 'sort_order' => 52],
            ['name_az' => 'Tovuz', 'name_en' => 'Tovuz', 'name_ru' => 'Товуз', 'has_neighborhoods' => false, 'sort_order' => 53],
            ['name_az' => 'Ucar', 'name_en' => 'Ujar', 'name_ru' => 'Уджар', 'has_neighborhoods' => false, 'sort_order' => 54],
            ['name_az' => 'Xaçmaz', 'name_en' => 'Khachmaz', 'name_ru' => 'Хачмаз', 'has_neighborhoods' => false, 'sort_order' => 55],
            ['name_az' => 'Xocalı', 'name_en' => 'Khojaly', 'name_ru' => 'Ходжалы', 'has_neighborhoods' => false, 'sort_order' => 56],
            ['name_az' => 'Xocavənd', 'name_en' => 'Khojavend', 'name_ru' => 'Ходжавенд', 'has_neighborhoods' => false, 'sort_order' => 57],
            ['name_az' => 'Yardımlı', 'name_en' => 'Yardimli', 'name_ru' => 'Ярдымлы', 'has_neighborhoods' => false, 'sort_order' => 58],
            ['name_az' => 'Zaqatala', 'name_en' => 'Zagatala', 'name_ru' => 'Закатала', 'has_neighborhoods' => false, 'sort_order' => 59],
            ['name_az' => 'Zəngilan', 'name_en' => 'Zangilan', 'name_ru' => 'Зангилан', 'has_neighborhoods' => false, 'sort_order' => 60],
            ['name_az' => 'Zərdab', 'name_en' => 'Zardab', 'name_ru' => 'Зардаб', 'has_neighborhoods' => false, 'sort_order' => 61],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
