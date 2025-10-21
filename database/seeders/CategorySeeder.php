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
            [
                'name' => 'Veb Proqramlaşdırma',
                'slug' => 'web-development',
                'icon' => 'Code',
                'order' => 1,
                'subcategories' => [
                    ['name' => 'Frontend Proqramlaşdırma', 'slug' => 'frontend-development', 'icon' => 'Monitor'],
                    ['name' => 'Backend Proqramlaşdırma', 'slug' => 'backend-development', 'icon' => 'Server'],
                    ['name' => 'Full Stack Proqramlaşdırma', 'slug' => 'fullstack-development', 'icon' => 'Layers'],
                ],
            ],
            [
                'name' => 'Mobil Proqramlaşdırma',
                'slug' => 'mobile-development',
                'icon' => 'Smartphone',
                'order' => 2,
                'subcategories' => [
                    ['name' => 'iOS Proqramlaşdırma', 'slug' => 'ios-development', 'icon' => 'Apple'],
                    ['name' => 'Android Proqramlaşdırma', 'slug' => 'android-development', 'icon' => 'Smartphone'],
                    ['name' => 'React Native', 'slug' => 'react-native', 'icon' => 'Smartphone'],
                ],
            ],
            [
                'name' => 'Dizayn və Kreativ',
                'slug' => 'design-creative',
                'icon' => 'Palette',
                'order' => 3,
                'subcategories' => [
                    ['name' => 'UI/UX Dizayn', 'slug' => 'ui-ux-design', 'icon' => 'Layout'],
                    ['name' => 'Qrafik Dizayn', 'slug' => 'graphic-design', 'icon' => 'Image'],
                    ['name' => 'Loqo Dizaynı', 'slug' => 'logo-design', 'icon' => 'Sparkles'],
                ],
            ],
            [
                'name' => 'Yazı və Tərcümə',
                'slug' => 'writing-translation',
                'icon' => 'FileText',
                'order' => 4,
                'subcategories' => [
                    ['name' => 'Kontent Yazısı', 'slug' => 'content-writing', 'icon' => 'PenTool'],
                    ['name' => 'Tərcümə', 'slug' => 'translation', 'icon' => 'Languages'],
                    ['name' => 'Reklam Mətnləri', 'slug' => 'copywriting', 'icon' => 'Type'],
                ],
            ],
            [
                'name' => 'Marketinq və Satış',
                'slug' => 'marketing-sales',
                'icon' => 'TrendingUp',
                'order' => 5,
                'subcategories' => [
                    ['name' => 'Rəqəmsal Marketinq', 'slug' => 'digital-marketing', 'icon' => 'Globe'],
                    ['name' => 'SEO', 'slug' => 'seo', 'icon' => 'Search'],
                    ['name' => 'Sosial Media Marketinqi', 'slug' => 'social-media-marketing', 'icon' => 'Share2'],
                ],
            ],
            [
                'name' => 'Video və Animasiya',
                'slug' => 'video-animation',
                'icon' => 'Video',
                'order' => 6,
                'subcategories' => [
                    ['name' => 'Video Montaj', 'slug' => 'video-editing', 'icon' => 'Film'],
                    ['name' => '3D Animasiya', 'slug' => '3d-animation', 'icon' => 'Box'],
                    ['name' => 'Motion Qrafika', 'slug' => 'motion-graphics', 'icon' => 'Zap'],
                ],
            ],
            [
                'name' => 'Data və Analitika',
                'slug' => 'data-analytics',
                'icon' => 'BarChart',
                'order' => 7,
                'subcategories' => [
                    ['name' => 'Data Analizi', 'slug' => 'data-analysis', 'icon' => 'PieChart'],
                    ['name' => 'Data Daxilolması', 'slug' => 'data-entry', 'icon' => 'Database'],
                    ['name' => 'Biznes İntellekti', 'slug' => 'business-intelligence', 'icon' => 'Activity'],
                ],
            ],
            [
                'name' => 'İdarəetmə və Dəstək',
                'slug' => 'admin-support',
                'icon' => 'Headphones',
                'order' => 8,
                'subcategories' => [
                    ['name' => 'Virtual Assistent', 'slug' => 'virtual-assistant', 'icon' => 'Users'],
                    ['name' => 'Müştəri Xidməti', 'slug' => 'customer-service', 'icon' => 'MessageCircle'],
                    ['name' => 'Texniki Dəstək', 'slug' => 'technical-support', 'icon' => 'Tool'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);

            $category = Category::create($categoryData);

            foreach ($subcategories as $subData) {
                $subData['parent_id'] = $category->id;
                $subData['order'] = 0;
                Category::create($subData);
            }
        }

        $this->command->info('Categories seeded successfully!');
    }
}
