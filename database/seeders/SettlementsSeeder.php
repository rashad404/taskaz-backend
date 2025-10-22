<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settlement;

class SettlementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settlements = [
            // Abşeron rayonu (district_id: 1)
            ['district_id' => 1, 'name_az' => 'Aşağı Güzdək', 'name_en' => 'Ashagi Guzdek', 'name_ru' => 'Ашагы Гюздек', 'sort_order' => 1],
            ['district_id' => 1, 'name_az' => 'Atyalı', 'name_en' => 'Atyali', 'name_ru' => 'Атялы', 'sort_order' => 2],
            ['district_id' => 1, 'name_az' => 'Ceyranbatan', 'name_en' => 'Ceyranbatan', 'name_ru' => 'Джейранбатан', 'sort_order' => 3],
            ['district_id' => 1, 'name_az' => 'Çiçək', 'name_en' => 'Chichek', 'name_ru' => 'Чичек', 'sort_order' => 4],
            ['district_id' => 1, 'name_az' => 'Digah', 'name_en' => 'Digah', 'name_ru' => 'Дигах', 'sort_order' => 5],
            ['district_id' => 1, 'name_az' => 'Fatmayı', 'name_en' => 'Fatmayi', 'name_ru' => 'Фатмайы', 'sort_order' => 6],
            ['district_id' => 1, 'name_az' => 'Görədil', 'name_en' => 'Goradil', 'name_ru' => 'Гёредил', 'sort_order' => 7],
            ['district_id' => 1, 'name_az' => 'Güzdək', 'name_en' => 'Guzdek', 'name_ru' => 'Гюздек', 'sort_order' => 8],
            ['district_id' => 1, 'name_az' => 'Hökməli', 'name_en' => 'Hokmali', 'name_ru' => 'Хокмели', 'sort_order' => 9],
            ['district_id' => 1, 'name_az' => 'Köhnə Corat', 'name_en' => 'Kohna Jorat', 'name_ru' => 'Кёхне Джорат', 'sort_order' => 10],
            ['district_id' => 1, 'name_az' => 'Qobu', 'name_en' => 'Gobu', 'name_ru' => 'Гобу', 'sort_order' => 11],
            ['district_id' => 1, 'name_az' => 'Masazır', 'name_en' => 'Masazir', 'name_ru' => 'Масазыр', 'sort_order' => 12],
            ['district_id' => 1, 'name_az' => 'Mehdiabad', 'name_en' => 'Mehdiabad', 'name_ru' => 'Мехдиабад', 'sort_order' => 13],
            ['district_id' => 1, 'name_az' => 'Məmmədli', 'name_en' => 'Mammadli', 'name_ru' => 'Маммадлы', 'sort_order' => 14],
            ['district_id' => 1, 'name_az' => 'Novxanı', 'name_en' => 'Novkhani', 'name_ru' => 'Новханы', 'sort_order' => 15],
            ['district_id' => 1, 'name_az' => 'Pirəkəşkül', 'name_en' => 'Pirakeshkul', 'name_ru' => 'Пиракешкюль', 'sort_order' => 16],
            ['district_id' => 1, 'name_az' => 'Saray', 'name_en' => 'Saray', 'name_ru' => 'Сарай', 'sort_order' => 17],
            ['district_id' => 1, 'name_az' => 'Yeni Corat', 'name_en' => 'Yeni Jorat', 'name_ru' => 'Ени Джорат', 'sort_order' => 18],
            ['district_id' => 1, 'name_az' => 'Zuğulba', 'name_en' => 'Zughulba', 'name_ru' => 'Зугулба', 'sort_order' => 19],

            // Binəqədi rayonu (district_id: 2)
            ['district_id' => 2, 'name_az' => '2-ci Alatava', 'name_en' => '2nd Alatava', 'name_ru' => '2-ая Алатава', 'sort_order' => 1],
            ['district_id' => 2, 'name_az' => '6-cı mikrorayon', 'name_en' => '6th Microdistrict', 'name_ru' => '6-ой микрорайон', 'sort_order' => 2],
            ['district_id' => 2, 'name_az' => '7-ci mikrorayon', 'name_en' => '7th Microdistrict', 'name_ru' => '7-ой микрорайон', 'sort_order' => 3],
            ['district_id' => 2, 'name_az' => '8-ci mikrorayon', 'name_en' => '8th Microdistrict', 'name_ru' => '8-ой микрорайон', 'sort_order' => 4],
            ['district_id' => 2, 'name_az' => '9-cu mikrorayon', 'name_en' => '9th Microdistrict', 'name_ru' => '9-ый микрорайон', 'sort_order' => 5],
            ['district_id' => 2, 'name_az' => 'Biləcəri', 'name_en' => 'Bilajari', 'name_ru' => 'Биляджары', 'sort_order' => 6],
            ['district_id' => 2, 'name_az' => 'Binəqədi', 'name_en' => 'Binagadi', 'name_ru' => 'Бинагади', 'sort_order' => 7],
            ['district_id' => 2, 'name_az' => 'Xocəsən', 'name_en' => 'Khojasan', 'name_ru' => 'Ходжасан', 'sort_order' => 8],
            ['district_id' => 2, 'name_az' => 'Xutor', 'name_en' => 'Khutor', 'name_ru' => 'Хутор', 'sort_order' => 9],
            ['district_id' => 2, 'name_az' => 'M.Ə.Rəsulzadə', 'name_en' => 'M.A.Rasulzade', 'name_ru' => 'М.Э.Расулзаде', 'sort_order' => 10],
            ['district_id' => 2, 'name_az' => 'Sulutəpə', 'name_en' => 'Sulutepe', 'name_ru' => 'Сулутепе', 'sort_order' => 11],

            // Xətai rayonu (district_id: 3)
            ['district_id' => 3, 'name_az' => 'Ağ şəhər', 'name_en' => 'Ag Shahar', 'name_ru' => 'Аг Шахар', 'sort_order' => 1],
            ['district_id' => 3, 'name_az' => 'Əhmədli', 'name_en' => 'Ahmadli', 'name_ru' => 'Ахмедли', 'sort_order' => 2],
            ['district_id' => 3, 'name_az' => 'Həzi Aslanov', 'name_en' => 'Hazi Aslanov', 'name_ru' => 'Гази Асланов', 'sort_order' => 3],
            ['district_id' => 3, 'name_az' => 'Köhnə Günəşli', 'name_en' => 'Kohna Gunashli', 'name_ru' => 'Кёхне Гюнешли', 'sort_order' => 4],
            ['district_id' => 3, 'name_az' => 'NZS', 'name_en' => 'NZS', 'name_ru' => 'НЗС', 'sort_order' => 5],

            // Xəzər rayonu (district_id: 4)
            ['district_id' => 4, 'name_az' => 'Binə', 'name_en' => 'Bina', 'name_ru' => 'Бина', 'sort_order' => 1],
            ['district_id' => 4, 'name_az' => 'Buzovna', 'name_en' => 'Buzovna', 'name_ru' => 'Бузовна', 'sort_order' => 2],
            ['district_id' => 4, 'name_az' => 'Dübəndi', 'name_en' => 'Dubandi', 'name_ru' => 'Дюбенди', 'sort_order' => 3],
            ['district_id' => 4, 'name_az' => 'Gürgən', 'name_en' => 'Gurgan', 'name_ru' => 'Гюрган', 'sort_order' => 4],
            ['district_id' => 4, 'name_az' => 'Qala', 'name_en' => 'Gala', 'name_ru' => 'Гала', 'sort_order' => 5],
            ['district_id' => 4, 'name_az' => 'Mərdəkan', 'name_en' => 'Mardakan', 'name_ru' => 'Мардакан', 'sort_order' => 6],
            ['district_id' => 4, 'name_az' => 'Şağan', 'name_en' => 'Shagan', 'name_ru' => 'Шаган', 'sort_order' => 7],
            ['district_id' => 4, 'name_az' => 'Şimal DRES', 'name_en' => 'Shimal DRES', 'name_ru' => 'Шимал ДРЭС', 'sort_order' => 8],
            ['district_id' => 4, 'name_az' => 'Şüvəlan', 'name_en' => 'Shuvelan', 'name_ru' => 'Шувелян', 'sort_order' => 9],
            ['district_id' => 4, 'name_az' => 'Türkan', 'name_en' => 'Turkan', 'name_ru' => 'Тюркан', 'sort_order' => 10],
            ['district_id' => 4, 'name_az' => 'Zirə', 'name_en' => 'Zira', 'name_ru' => 'Зире', 'sort_order' => 11],

            // Qaradağ rayonu (district_id: 5)
            ['district_id' => 5, 'name_az' => 'Ələt', 'name_en' => 'Alat', 'name_ru' => 'Алят', 'sort_order' => 1],
            ['district_id' => 5, 'name_az' => 'Qızıldaş', 'name_en' => 'Gizildash', 'name_ru' => 'Гызылдаш', 'sort_order' => 2],
            ['district_id' => 5, 'name_az' => 'Qobustan', 'name_en' => 'Gobustan', 'name_ru' => 'Гобустан', 'sort_order' => 3],
            ['district_id' => 5, 'name_az' => 'Lökbatan', 'name_en' => 'Lokbatan', 'name_ru' => 'Лёкбатан', 'sort_order' => 4],
            ['district_id' => 5, 'name_az' => 'Müşfiqabad', 'name_en' => 'Mushfigabad', 'name_ru' => 'Мушфигабад', 'sort_order' => 5],
            ['district_id' => 5, 'name_az' => 'Puta', 'name_en' => 'Puta', 'name_ru' => 'Пута', 'sort_order' => 6],
            ['district_id' => 5, 'name_az' => 'Sahil', 'name_en' => 'Sahil', 'name_ru' => 'Сахил', 'sort_order' => 7],
            ['district_id' => 5, 'name_az' => 'Səngəçal', 'name_en' => 'Sangachal', 'name_ru' => 'Сангачал', 'sort_order' => 8],
            ['district_id' => 5, 'name_az' => 'Şubanı', 'name_en' => 'Shubani', 'name_ru' => 'Шубаны', 'sort_order' => 9],

            // Nərimanov rayonu (district_id: 6)
            ['district_id' => 6, 'name_az' => 'Böyükşor', 'name_en' => 'Boyukshor', 'name_ru' => 'Бёюкшор', 'sort_order' => 1],

            // Nəsimi rayonu (district_id: 7)
            ['district_id' => 7, 'name_az' => '1-ci mikrorayon', 'name_en' => '1st Microdistrict', 'name_ru' => '1-ый микрорайон', 'sort_order' => 1],
            ['district_id' => 7, 'name_az' => '2-ci mikrorayon', 'name_en' => '2nd Microdistrict', 'name_ru' => '2-ой микрорайон', 'sort_order' => 2],
            ['district_id' => 7, 'name_az' => '3-cü mikrorayon', 'name_en' => '3rd Microdistrict', 'name_ru' => '3-ий микрорайон', 'sort_order' => 3],
            ['district_id' => 7, 'name_az' => '4-cü mikrorayon', 'name_en' => '4th Microdistrict', 'name_ru' => '4-ый микрорайон', 'sort_order' => 4],
            ['district_id' => 7, 'name_az' => '5-ci mikrorayon', 'name_en' => '5th Microdistrict', 'name_ru' => '5-ый микрорайон', 'sort_order' => 5],
            ['district_id' => 7, 'name_az' => 'Kubinka', 'name_en' => 'Kubinka', 'name_ru' => 'Кубинка', 'sort_order' => 6],

            // Nizami rayonu (district_id: 8)
            ['district_id' => 8, 'name_az' => '8-ci kilometr', 'name_en' => '8th Kilometer', 'name_ru' => '8-ой километр', 'sort_order' => 1],
            ['district_id' => 8, 'name_az' => 'Keşlə', 'name_en' => 'Keshla', 'name_ru' => 'Кешла', 'sort_order' => 2],

            // Pirallahı rayonu (district_id: 9)
            ['district_id' => 9, 'name_az' => 'Pirallahı', 'name_en' => 'Pirallahi', 'name_ru' => 'Пираллахи', 'sort_order' => 1],

            // Sabunçu rayonu (district_id: 10)
            ['district_id' => 10, 'name_az' => 'Albalılıq', 'name_en' => 'Albalilig', 'name_ru' => 'Албалылыг', 'sort_order' => 1],
            ['district_id' => 10, 'name_az' => 'Bakıxanov', 'name_en' => 'Bakikhanov', 'name_ru' => 'Бакиханов', 'sort_order' => 2],
            ['district_id' => 10, 'name_az' => 'Balaxanı', 'name_en' => 'Balakhani', 'name_ru' => 'Балаханы', 'sort_order' => 3],
            ['district_id' => 10, 'name_az' => 'Bilgəh', 'name_en' => 'Bilgah', 'name_ru' => 'Бильгях', 'sort_order' => 4],
            ['district_id' => 10, 'name_az' => 'Kürdəxanı', 'name_en' => 'Kurdakhani', 'name_ru' => 'Кюрдаханы', 'sort_order' => 5],
            ['district_id' => 10, 'name_az' => 'Maştağa', 'name_en' => 'Mashtaga', 'name_ru' => 'Маштага', 'sort_order' => 6],
            ['district_id' => 10, 'name_az' => 'Nardaran', 'name_en' => 'Nardaran', 'name_ru' => 'Нардаран', 'sort_order' => 7],
            ['district_id' => 10, 'name_az' => 'Pirşağı', 'name_en' => 'Pirshagi', 'name_ru' => 'Пиршаги', 'sort_order' => 8],
            ['district_id' => 10, 'name_az' => 'Ramana', 'name_en' => 'Ramana', 'name_ru' => 'Рамана', 'sort_order' => 9],
            ['district_id' => 10, 'name_az' => 'Sabunçu', 'name_en' => 'Sabunchu', 'name_ru' => 'Сабунчу', 'sort_order' => 10],
            ['district_id' => 10, 'name_az' => 'Savalan', 'name_en' => 'Savalan', 'name_ru' => 'Савалан', 'sort_order' => 11],
            ['district_id' => 10, 'name_az' => 'Sea Breeze', 'name_en' => 'Sea Breeze', 'name_ru' => 'Си Бриз', 'sort_order' => 12],
            ['district_id' => 10, 'name_az' => 'Yeni Balaxanı', 'name_en' => 'Yeni Balakhani', 'name_ru' => 'Ени Балаханы', 'sort_order' => 13],
            ['district_id' => 10, 'name_az' => 'Yeni Ramana', 'name_en' => 'Yeni Ramana', 'name_ru' => 'Ени Рамана', 'sort_order' => 14],
            ['district_id' => 10, 'name_az' => 'Zabrat', 'name_en' => 'Zabrat', 'name_ru' => 'Забрат', 'sort_order' => 15],

            // Səbail rayonu (district_id: 11)
            ['district_id' => 11, 'name_az' => '20-ci sahə', 'name_en' => '20th Site', 'name_ru' => '20-ый участок', 'sort_order' => 1],
            ['district_id' => 11, 'name_az' => 'Badamdar', 'name_en' => 'Badamdar', 'name_ru' => 'Бадамдар', 'sort_order' => 2],
            ['district_id' => 11, 'name_az' => 'Bayıl', 'name_en' => 'Bayil', 'name_ru' => 'Баиль', 'sort_order' => 3],
            ['district_id' => 11, 'name_az' => 'Bibiheybət', 'name_en' => 'Bibiheybat', 'name_ru' => 'Бибихейбат', 'sort_order' => 4],
            ['district_id' => 11, 'name_az' => 'Şıxov', 'name_en' => 'Shikhov', 'name_ru' => 'Шыхов', 'sort_order' => 5],

            // Suraxanı rayonu (district_id: 12)
            ['district_id' => 12, 'name_az' => 'Bahar', 'name_en' => 'Bahar', 'name_ru' => 'Бахар', 'sort_order' => 1],
            ['district_id' => 12, 'name_az' => 'Bülbülə', 'name_en' => 'Bulbula', 'name_ru' => 'Бюльбюле', 'sort_order' => 2],
            ['district_id' => 12, 'name_az' => 'Dədə Qorqud', 'name_en' => 'Dada Gorgud', 'name_ru' => 'Деде Горгуд', 'sort_order' => 3],
            ['district_id' => 12, 'name_az' => 'Əmircan', 'name_en' => 'Amirjan', 'name_ru' => 'Амирджан', 'sort_order' => 4],
            ['district_id' => 12, 'name_az' => 'Günəşli', 'name_en' => 'Gunashli', 'name_ru' => 'Гюнешли', 'sort_order' => 5],
            ['district_id' => 12, 'name_az' => 'Hövsan', 'name_en' => 'Hovsan', 'name_ru' => 'Хёвсан', 'sort_order' => 6],
            ['district_id' => 12, 'name_az' => 'Qaraçuxur', 'name_en' => 'Garachukhur', 'name_ru' => 'Гарачухур', 'sort_order' => 7],
            ['district_id' => 12, 'name_az' => 'Massiv A', 'name_en' => 'Massiv A', 'name_ru' => 'Массив А', 'sort_order' => 8],
            ['district_id' => 12, 'name_az' => 'Massiv B', 'name_en' => 'Massiv B', 'name_ru' => 'Массив Б', 'sort_order' => 9],
            ['district_id' => 12, 'name_az' => 'Massiv D', 'name_en' => 'Massiv D', 'name_ru' => 'Массив Д', 'sort_order' => 10],
            ['district_id' => 12, 'name_az' => 'Massiv G', 'name_en' => 'Massiv G', 'name_ru' => 'Массив Г', 'sort_order' => 11],
            ['district_id' => 12, 'name_az' => 'Massiv V', 'name_en' => 'Massiv V', 'name_ru' => 'Массив В', 'sort_order' => 12],
            ['district_id' => 12, 'name_az' => 'Suraxanı', 'name_en' => 'Surakhani', 'name_ru' => 'Сураханы', 'sort_order' => 13],
            ['district_id' => 12, 'name_az' => 'Şərq', 'name_en' => 'Sharq', 'name_ru' => 'Шарг', 'sort_order' => 14],
            ['district_id' => 12, 'name_az' => 'Yeni Günəşli', 'name_en' => 'Yeni Gunashli', 'name_ru' => 'Ени Гюнешли', 'sort_order' => 15],
            ['district_id' => 12, 'name_az' => 'Yeni Suraxanı', 'name_en' => 'Yeni Surakhani', 'name_ru' => 'Ени Сураханы', 'sort_order' => 16],
            ['district_id' => 12, 'name_az' => 'Zığ', 'name_en' => 'Zigh', 'name_ru' => 'Зыг', 'sort_order' => 17],

            // Yasamal rayonu (district_id: 13)
            ['district_id' => 13, 'name_az' => 'Yasamal', 'name_en' => 'Yasamal', 'name_ru' => 'Ясамал', 'sort_order' => 1],
            ['district_id' => 13, 'name_az' => 'Yeni Yasamal', 'name_en' => 'Yeni Yasamal', 'name_ru' => 'Ени Ясамал', 'sort_order' => 2],
        ];

        foreach ($settlements as $settlement) {
            Settlement::create($settlement);
        }
    }
}
