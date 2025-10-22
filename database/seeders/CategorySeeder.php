<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // 1. Məişət Texnikası (Home Appliances)
            [
                'name' => 'Məişət Texnikası',
                'slug' => 'meiset-texnikasi',
                'icon' => 'AirVent',
                'order' => 1,
                'subcategories' => [
                    ['name' => 'Kondisioner təmiri', 'slug' => 'kondisioner-temiri'],
                    ['name' => 'Kombi təmiri', 'slug' => 'kombi-temiri'],
                    ['name' => 'Soyuducu təmiri', 'slug' => 'soyuducu-temiri'],
                    ['name' => 'Paltaryuyan təmiri', 'slug' => 'paltaryuyan-temiri'],
                    ['name' => 'Qabyuyan təmiri', 'slug' => 'qabyuyan-temiri'],
                    ['name' => 'Havalandırma sistemi', 'slug' => 'havalandirma-sistemi'],
                    ['name' => 'Qaz sobası təmiri', 'slug' => 'qaz-sobasi-temiri'],
                    ['name' => 'Su qızdırıcısı təmiri', 'slug' => 'su-qizdiricisi-temiri'],
                    ['name' => 'Ütü təmiri', 'slug' => 'utu-temiri'],
                    ['name' => 'Tozsoran təmiri', 'slug' => 'tozsoran-temiri'],
                    ['name' => 'Mikrodalğalı soba təmiri', 'slug' => 'mikrodalgali-soba-temiri'],
                    ['name' => 'Digər məişət texnikası', 'slug' => 'diger-meiset-texnikasi'],
                ],
            ],

            // 2. Elektronika (Electronics)
            [
                'name' => 'Elektronika',
                'slug' => 'elektronika',
                'icon' => 'Smartphone',
                'order' => 2,
                'subcategories' => [
                    ['name' => 'Telefon təmiri', 'slug' => 'telefon-temiri'],
                    ['name' => 'Kompüter təmiri', 'slug' => 'komputer-temiri'],
                    ['name' => 'Noutbuk təmiri', 'slug' => 'noutbuk-temiri'],
                    ['name' => 'Televizor təmiri', 'slug' => 'televizor-temiri'],
                    ['name' => 'Planşet təmiri', 'slug' => 'planset-temiri'],
                    ['name' => 'Printer təmiri', 'slug' => 'printer-temiri'],
                    ['name' => 'Monitor təmiri', 'slug' => 'monitor-temiri'],
                    ['name' => 'Kamera təmiri', 'slug' => 'kamera-temiri'],
                    ['name' => 'Oyun konsolları təmiri', 'slug' => 'oyun-konsollari-temiri'],
                    ['name' => 'Smart saat təmiri', 'slug' => 'smart-saat-temiri'],
                    ['name' => 'Digər elektronika', 'slug' => 'diger-elektronika'],
                ],
            ],

            // 3. Təmir və Tikinti (Repair & Construction)
            [
                'name' => 'Təmir və Tikinti',
                'slug' => 'temir-tikinti',
                'icon' => 'Hammer',
                'order' => 3,
                'subcategories' => [
                    ['name' => 'Elektrik işləri', 'slug' => 'elektrik-isleri'],
                    ['name' => 'Santexnika', 'slug' => 'santexnika'],
                    ['name' => 'Malyar işləri', 'slug' => 'malyar-isleri'],
                    ['name' => 'Kafel-metlax', 'slug' => 'kafel-metlax'],
                    ['name' => 'Laminat-parket', 'slug' => 'laminat-parket'],
                    ['name' => 'Dartma tavan', 'slug' => 'dartma-tavan'],
                    ['name' => 'Divar kağızı', 'slug' => 'divar-kagizi'],
                    ['name' => 'Plastik qapı-pəncərə', 'slug' => 'plastik-qapi-pencere'],
                    ['name' => 'Cam balkon', 'slug' => 'cam-balkon'],
                    ['name' => 'Çilingər xidməti', 'slug' => 'cilinger-xidmeti'],
                    ['name' => 'Ev təmiri', 'slug' => 'ev-temiri'],
                    ['name' => 'Kanalizasiya', 'slug' => 'kanalizasiya'],
                    ['name' => 'Su sızması', 'slug' => 'su-sizmasi'],
                    ['name' => 'Jalüz quraşdırılması', 'slug' => 'jaluz-qurasdirma'],
                    ['name' => 'Duş kabinası', 'slug' => 'dus-kabinasi'],
                    ['name' => 'Beton işləri', 'slug' => 'beton-isleri'],
                    ['name' => 'Fasad işləri', 'slug' => 'fasad-isleri'],
                    ['name' => 'Dam təmiri', 'slug' => 'dam-temiri'],
                ],
            ],

            // 4. Mebel və Daxili Dizayn (Furniture & Interior)
            [
                'name' => 'Mebel və Daxili Dizayn',
                'slug' => 'mebel-daxili-dizayn',
                'icon' => 'Armchair',
                'order' => 4,
                'subcategories' => [
                    ['name' => 'Mətbəx mebeli quraşdırılması', 'slug' => 'metbex-mebeli-qurasdirilmasi'],
                    ['name' => 'Şkaf quraşdırılması', 'slug' => 'shkaf-qurasdirilmasi'],
                    ['name' => 'Mebel təmiri', 'slug' => 'mebel-temiri'],
                    ['name' => 'Divan üzləşdirilməsi', 'slug' => 'divan-uzlesdirilmesi'],
                    ['name' => 'Kreslo təmiri', 'slug' => 'kreslo-temiri'],
                    ['name' => 'Ofis mebeli', 'slug' => 'ofis-mebeli'],
                    ['name' => 'Mebel dizaynı', 'slug' => 'mebel-dizayni'],
                    ['name' => 'Daxili dizayn', 'slug' => 'daxili-dizayn'],
                    ['name' => 'Dekorasiya', 'slug' => 'dekorasiya'],
                ],
            ],

            // 5. Avtomobil Xidmətləri (Automotive Services)
            [
                'name' => 'Avtomobil Xidmətləri',
                'slug' => 'avtomobil-xidmetleri',
                'icon' => 'Car',
                'order' => 5,
                'subcategories' => [
                    ['name' => 'Avtomobil təmiri', 'slug' => 'avtomobil-temiri'],
                    ['name' => 'Avtomobil elektrikçisi', 'slug' => 'avtomobil-elektrikcisi'],
                    ['name' => 'Avtomobil malyarı', 'slug' => 'avtomobil-malyari'],
                    ['name' => 'Təkər təmiri', 'slug' => 'teker-temiri'],
                    ['name' => 'Avtomobil açarı', 'slug' => 'avtomobil-acari'],
                    ['name' => 'Avtomobil oturacaq üzdənməsi', 'slug' => 'avtomobil-oturacaq-uzdenme'],
                    ['name' => 'Avtomobil təmizliyi', 'slug' => 'avtomobil-temizliyi'],
                    ['name' => 'Avtodiaqnostika', 'slug' => 'avtodiaqnostika'],
                    ['name' => 'Mühərrik təmiri', 'slug' => 'muherrik-temiri'],
                    ['name' => 'Digər avtomobil xidmətləri', 'slug' => 'diger-avtomobil-xidmetleri'],
                ],
            ],

            // 6. Nəqliyyat və Daşınma (Transportation & Moving)
            [
                'name' => 'Nəqliyyat və Daşınma',
                'slug' => 'neqliyyat-dasinma',
                'icon' => 'Truck',
                'order' => 6,
                'subcategories' => [
                    ['name' => 'Yükdaşıma', 'slug' => 'yukdasima'],
                    ['name' => 'Ev köçürülməsi', 'slug' => 'ev-kocurulmesi'],
                    ['name' => 'Ofis köçürülməsi', 'slug' => 'ofis-kocurulmesi'],
                    ['name' => 'Evakuator', 'slug' => 'evakuator'],
                    ['name' => 'Kuryer xidməti', 'slug' => 'kuryer-xidmeti'],
                    ['name' => 'Sürücü xidməti', 'slug' => 'surucu-xidmeti'],
                    ['name' => 'Avtomobil icarəsi', 'slug' => 'avtomobil-icaresi'],
                    ['name' => 'Texnika icarəsi', 'slug' => 'texnika-icaresi'],
                    ['name' => 'Qaldırıcı texnika', 'slug' => 'qaldirici-texnika'],
                ],
            ],

            // 7. Təhsil və Məşq (Education & Training)
            [
                'name' => 'Təhsil və Məşq',
                'slug' => 'tehsil-mesq',
                'icon' => 'GraduationCap',
                'order' => 7,
                'subcategories' => [
                    ['name' => 'Məktəb fənləri müəllimi', 'slug' => 'mekteb-fenleri-muellimi'],
                    ['name' => 'İngilis dili', 'slug' => 'ingilis-dili'],
                    ['name' => 'Rus dili', 'slug' => 'rus-dili'],
                    ['name' => 'Türk dili', 'slug' => 'turk-dili'],
                    ['name' => 'Alman dili', 'slug' => 'alman-dili'],
                    ['name' => 'Riyaziyyat müəllimi', 'slug' => 'riyaziyyat-muellimi'],
                    ['name' => 'Fizika müəllimi', 'slug' => 'fizika-muellimi'],
                    ['name' => 'Kimya müəllimi', 'slug' => 'kimya-muellimi'],
                    ['name' => 'Piano dərsi', 'slug' => 'piano-dersi'],
                    ['name' => 'Gitara dərsi', 'slug' => 'gitara-dersi'],
                    ['name' => 'Vokal dərsi', 'slug' => 'vokal-dersi'],
                    ['name' => 'İdman məşqçisi', 'slug' => 'idman-mesqcisi'],
                    ['name' => 'Yoga təlimçisi', 'slug' => 'yoga-telimcisi'],
                    ['name' => 'Fitness məşqçisi', 'slug' => 'fitness-mesqcisi'],
                    ['name' => 'Şahmat dərsi', 'slug' => 'shahmat-dersi'],
                    ['name' => 'Rəsm dərsi', 'slug' => 'resm-dersi'],
                    ['name' => 'Proqramlaşdırma dərsi', 'slug' => 'proqramlashdirma-dersi'],
                    ['name' => 'Digər təhsil xidmətləri', 'slug' => 'diger-tehsil-xidmetleri'],
                ],
            ],

            // 8. Sağlamlıq və Qulluq (Healthcare & Care)
            [
                'name' => 'Sağlamlıq və Qulluq',
                'slug' => 'saglamliq-qulluq',
                'icon' => 'Heart',
                'order' => 8,
                'subcategories' => [
                    ['name' => 'Tibb bacısı', 'slug' => 'tibb-bacisi'],
                    ['name' => 'Yaşlı qulluğu', 'slug' => 'yasli-qulluqu'],
                    ['name' => 'Xəstə qulluğu', 'slug' => 'xeste-qulluqu'],
                    ['name' => 'Uşaq baxıcısı', 'slug' => 'usaq-baxicisi'],
                    ['name' => 'Fizioterapiya', 'slug' => 'fizioterapiya'],
                    ['name' => 'Masaj terapiyası', 'slug' => 'masaj-terapiyasi'],
                    ['name' => 'Evdə tibbi qulluq', 'slug' => 'evde-tibbi-qulluq'],
                    ['name' => 'Psixoloq məsləhəti', 'slug' => 'psixoloq-mesleheti'],
                    ['name' => 'Digər sağlamlıq xidmətləri', 'slug' => 'diger-saglamliq-xidmetleri'],
                ],
            ],

            // 9. Gözəllik və Şəxsi Qulluq (Beauty & Personal Care)
            [
                'name' => 'Gözəllik və Şəxsi Qulluq',
                'slug' => 'gozellik-sexsi-qulluq',
                'icon' => 'Sparkles',
                'order' => 9,
                'subcategories' => [
                    ['name' => 'Saç kəsimi', 'slug' => 'sac-kesimi'],
                    ['name' => 'Saç rəngləmə', 'slug' => 'sac-rengleme'],
                    ['name' => 'Makiyaj', 'slug' => 'makiyaj'],
                    ['name' => 'Dırnaq ustası', 'slug' => 'dirnaq-ustasi'],
                    ['name' => 'Pedikür', 'slug' => 'pedikur'],
                    ['name' => 'Qaş-kirpik', 'slug' => 'qas-kirpik'],
                    ['name' => 'Bərbər', 'slug' => 'berber'],
                    ['name' => 'Kosmetoloq', 'slug' => 'kosmetolog'],
                    ['name' => 'Epilyasiya', 'slug' => 'epilyasiya'],
                    ['name' => 'SPA xidmətləri', 'slug' => 'spa-xidmetleri'],
                ],
            ],

            // 10. Təmizlik Xidmətləri (Cleaning Services)
            [
                'name' => 'Təmizlik Xidmətləri',
                'slug' => 'temizlik-xidmetleri',
                'icon' => 'Sparkle',
                'order' => 10,
                'subcategories' => [
                    ['name' => 'Ev təmizliyi', 'slug' => 'ev-temizliyi'],
                    ['name' => 'Ofis təmizliyi', 'slug' => 'ofis-temizliyi'],
                    ['name' => 'Pəncərə təmizliyi', 'slug' => 'pencere-temizliyi'],
                    ['name' => 'Təmirin ardınca təmizlik', 'slug' => 'temirin-ardinca-temizlik'],
                    ['name' => 'Xalça təmizliyi', 'slug' => 'xalca-temizliyi'],
                    ['name' => 'Mebel təmizliyi', 'slug' => 'mebel-temizliyi'],
                    ['name' => 'Dezinfeksiya', 'slug' => 'dezinfeksiya'],
                    ['name' => 'Fasad təmizliyi', 'slug' => 'fasad-temizliyi'],
                    ['name' => 'Digər təmizlik xidmətləri', 'slug' => 'diger-temizlik-xidmetleri'],
                ],
            ],

            // 11. Heyvan Qulluğu (Pet Care)
            [
                'name' => 'Heyvan Qulluğu',
                'slug' => 'heyvan-qulluqu',
                'icon' => 'Dog',
                'order' => 11,
                'subcategories' => [
                    ['name' => 'İt gəzdirmə', 'slug' => 'it-gezdirme'],
                    ['name' => 'Heyvan qulluğu', 'slug' => 'heyvan-qulluqu-xidmeti'],
                    ['name' => 'Pet grooming', 'slug' => 'pet-grooming'],
                    ['name' => 'Veterinar xidməti', 'slug' => 'veterinar-xidmeti'],
                    ['name' => 'Heyvan məşqçisi', 'slug' => 'heyvan-mesqcisi'],
                    ['name' => 'Akvarium qulluğu', 'slug' => 'akvarium-qulluqu'],
                ],
            ],

            // 12. Bağ və Landşaft (Garden & Landscaping)
            [
                'name' => 'Bağ və Landşaft',
                'slug' => 'bag-landshaft',
                'icon' => 'Trees',
                'order' => 12,
                'subcategories' => [
                    ['name' => 'Bağ dizaynı', 'slug' => 'bag-dizayni'],
                    ['name' => 'Ağac əkmə', 'slug' => 'agac-ekme'],
                    ['name' => 'Ot biçmə', 'slug' => 'ot-bicme'],
                    ['name' => 'Bağ qulluğu', 'slug' => 'bag-qulluqu'],
                    ['name' => 'Suvarma sistemi', 'slug' => 'suvarma-sistemi'],
                    ['name' => 'Hovuz tikintisi', 'slug' => 'hovuz-tikintisi'],
                    ['name' => 'Landşaft dizaynı', 'slug' => 'landshaft-dizayni'],
                    ['name' => 'Ağac budama', 'slug' => 'agac-budama'],
                ],
            ],

            // 13. Tədbirlər və Əyləncə (Events & Entertainment)
            [
                'name' => 'Tədbirlər və Əyləncə',
                'slug' => 'tedbirler-eylence',
                'icon' => 'PartyPopper',
                'order' => 13,
                'subcategories' => [
                    ['name' => 'Toylara xidmət', 'slug' => 'toylara-xidmet'],
                    ['name' => 'Ad günü təşkili', 'slug' => 'ad-gunu-teskili'],
                    ['name' => 'Tədbir planlaşdırılması', 'slug' => 'tedbir-planlasdirma'],
                    ['name' => 'DJ xidməti', 'slug' => 'dj-xidmeti'],
                    ['name' => 'Foto çəkiliş', 'slug' => 'foto-cekilis'],
                    ['name' => 'Video çəkiliş', 'slug' => 'video-cekilis'],
                    ['name' => 'Tamada xidməti', 'slug' => 'tamada-xidmeti'],
                    ['name' => 'Dekorasiya xidməti', 'slug' => 'dekorasiya-xidmeti'],
                    ['name' => 'Tort hazırlanması', 'slug' => 'tort-hazirlanmasi'],
                    ['name' => 'Katerinq', 'slug' => 'katering'],
                    ['name' => 'Animator', 'slug' => 'animator'],
                    ['name' => 'Musiqi qrupu', 'slug' => 'musiqi-qrupu'],
                ],
            ],

            // 14. Reklam və Dizayn (Advertising & Design)
            [
                'name' => 'Reklam və Dizayn',
                'slug' => 'reklam-dizayn',
                'icon' => 'Palette',
                'order' => 14,
                'subcategories' => [
                    ['name' => 'Qrafik dizayn', 'slug' => 'qrafik-dizayn'],
                    ['name' => 'Logo dizaynı', 'slug' => 'logo-dizayni'],
                    ['name' => 'UI/UX dizayn', 'slug' => 'ui-ux-dizayn'],
                    ['name' => 'Veb dizayn', 'slug' => 'veb-dizayn'],
                    ['name' => 'Çap işləri', 'slug' => 'cap-isleri'],
                    ['name' => 'Banner hazırlanması', 'slug' => 'banner-hazirlanmasi'],
                    ['name' => 'Vizitka dizaynı', 'slug' => 'vizitka-dizayni'],
                    ['name' => 'Brend dizaynı', 'slug' => 'brend-dizayni'],
                    ['name' => '3D dizayn', 'slug' => '3d-dizayn'],
                    ['name' => 'Animasiya', 'slug' => 'animasiya'],
                    ['name' => 'Video montaj', 'slug' => 'video-montaj'],
                    ['name' => 'SMM xidməti', 'slug' => 'smm-xidmeti'],
                ],
            ],

            // 15. İT və Proqramlaşdırma (IT & Programming)
            [
                'name' => 'İT və Proqramlaşdırma',
                'slug' => 'it-proqramlashdirma',
                'icon' => 'Code',
                'order' => 15,
                'subcategories' => [
                    ['name' => 'Veb proqramlaşdırma', 'slug' => 'veb-proqramlashdirma'],
                    ['name' => 'Frontend proqramlaşdırma', 'slug' => 'frontend-proqramlashdirma'],
                    ['name' => 'Backend proqramlaşdırma', 'slug' => 'backend-proqramlashdirma'],
                    ['name' => 'Full Stack proqramlaşdırma', 'slug' => 'fullstack-proqramlashdirma'],
                    ['name' => 'Mobil proqramlaşdırma', 'slug' => 'mobil-proqramlashdirma'],
                    ['name' => 'iOS proqramlaşdırma', 'slug' => 'ios-proqramlashdirma'],
                    ['name' => 'Android proqramlaşdırma', 'slug' => 'android-proqramlashdirma'],
                    ['name' => 'WordPress xidməti', 'slug' => 'wordpress-xidmeti'],
                    ['name' => 'E-ticarət saytı', 'slug' => 'e-ticaret-sayti'],
                    ['name' => 'Proqram təminatı təmiri', 'slug' => 'proqram-teminati-temiri'],
                    ['name' => 'Şəbəkə quraşdırılması', 'slug' => 'sebeke-qurasdirma'],
                    ['name' => 'Server quraşdırılması', 'slug' => 'server-qurasdirma'],
                    ['name' => 'Kibertəhlükəsizlik', 'slug' => 'kibertehlikesizlik'],
                    ['name' => 'Data analizi', 'slug' => 'data-analizi'],
                    ['name' => 'Digər İT xidmətləri', 'slug' => 'diger-it-xidmetleri'],
                ],
            ],

            // 16. Yazı və Tərcümə (Writing & Translation)
            [
                'name' => 'Yazı və Tərcümə',
                'slug' => 'yazi-tercume',
                'icon' => 'FileText',
                'order' => 16,
                'subcategories' => [
                    ['name' => 'Məzmun yazısı', 'slug' => 'mezmun-yazisi'],
                    ['name' => 'Tərcümə xidməti', 'slug' => 'tercume-xidmeti'],
                    ['name' => 'Redaktə', 'slug' => 'redakte'],
                    ['name' => 'Korrektə', 'slug' => 'korrekte'],
                    ['name' => 'Texniki yazı', 'slug' => 'texniki-yazi'],
                    ['name' => 'Reklam mətnləri', 'slug' => 'reklam-metnleri'],
                    ['name' => 'Ssenari yazısı', 'slug' => 'ssenari-yazisi'],
                    ['name' => 'Kitab yazısı', 'slug' => 'kitab-yazisi'],
                ],
            ],

            // 17. Maliyyə və Hüquq (Finance & Legal)
            [
                'name' => 'Maliyyə və Hüquq',
                'slug' => 'maliyye-huquq',
                'icon' => 'Scale',
                'order' => 17,
                'subcategories' => [
                    ['name' => 'Mühasibatlıq', 'slug' => 'muhasibatliq'],
                    ['name' => 'Vergi məsləhəti', 'slug' => 'vergi-mesleheti'],
                    ['name' => 'Hüquq məsləhəti', 'slug' => 'huquq-mesleheti'],
                    ['name' => 'Notarius xidməti', 'slug' => 'notarius-xidmeti'],
                    ['name' => 'Biznes planı hazırlanması', 'slug' => 'biznes-plani-hazirlanmasi'],
                    ['name' => 'Maliyyə planlaşdırması', 'slug' => 'maliyye-planlasdirmasi'],
                    ['name' => 'Müqavilə hazırlanması', 'slug' => 'muqavile-hazirlanmasi'],
                ],
            ],

            // 18. Marketinq və Satış (Marketing & Sales)
            [
                'name' => 'Marketinq və Satış',
                'slug' => 'marketinq-satis',
                'icon' => 'TrendingUp',
                'order' => 18,
                'subcategories' => [
                    ['name' => 'Rəqəmsal marketinq', 'slug' => 'reqemsal-marketinq'],
                    ['name' => 'SEO xidməti', 'slug' => 'seo-xidmeti'],
                    ['name' => 'Sosial media marketinqi', 'slug' => 'sosial-media-marketinqi'],
                    ['name' => 'Google Ads', 'slug' => 'google-ads'],
                    ['name' => 'Facebook Ads', 'slug' => 'facebook-ads'],
                    ['name' => 'E-poçt marketinqi', 'slug' => 'e-poct-marketinqi'],
                    ['name' => 'Məzmun marketinqi', 'slug' => 'mezmun-marketinqi'],
                    ['name' => 'Satış məsləhəti', 'slug' => 'satis-mesleheti'],
                ],
            ],

            // 19. Kənd Təsərrüfatı (Agriculture)
            [
                'name' => 'Kənd Təsərrüfatı',
                'slug' => 'kend-teserrufati',
                'icon' => 'Wheat',
                'order' => 19,
                'subcategories' => [
                    ['name' => 'Əkinçilik xidməti', 'slug' => 'ekincilik-xidmeti'],
                    ['name' => 'Heyvandarlıq məsləhəti', 'slug' => 'heyvandarliqliq-mesleheti'],
                    ['name' => 'Bağçılıq', 'slug' => 'bagcilik'],
                    ['name' => 'Arıçılıq', 'slug' => 'aricilik'],
                    ['name' => 'Ferma qurulması', 'slug' => 'ferma-qurulmasi'],
                    ['name' => 'Toxum məsləhəti', 'slug' => 'toxum-mesleheti'],
                ],
            ],

            // 20. Digər Xidmətlər (Other Services)
            [
                'name' => 'Digər Xidmətlər',
                'slug' => 'diger-xidmetler',
                'icon' => 'MoreHorizontal',
                'order' => 20,
                'subcategories' => [
                    ['name' => 'Sənədlərin tərcüməsi', 'slug' => 'senedlerin-tercumesi'],
                    ['name' => 'Alış-veriş köməkçisi', 'slug' => 'alis-veris-komekcisi'],
                    ['name' => 'Tullantı utilizasiyası', 'slug' => 'tullanti-utilizasiyasi'],
                    ['name' => 'Metal qəbulu', 'slug' => 'metal-qebulu'],
                    ['name' => 'Təhlükəsizlik xidməti', 'slug' => 'tehlukesizlik-xidmeti'],
                    ['name' => 'Təlimatçı', 'slug' => 'telimatci'],
                    ['name' => 'Virtual assistent', 'slug' => 'virtual-assistent'],
                    ['name' => 'Digər xidmətlər', 'slug' => 'diger-xidmetler-xususi'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);

            $category = Category::create($categoryData);

            foreach ($subcategories as $index => $subData) {
                $subData['parent_id'] = $category->id;
                $subData['order'] = $index;
                $subData['icon'] = null; // Subcategories don't need icons
                Category::create($subData);
            }
        }

        $this->command->info('Categories seeded successfully! Total: ' . Category::count() . ' categories created.');
    }
}
