<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Support\Str;

class CategoryAndSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define main categories
        $mainCategories = [
            [
                'name' => 'Web Development',
                'description' => 'Website and web application development services',
                'icon' => 'code',
                'skills' => [
                    'HTML', 'CSS', 'JavaScript', 'TypeScript', 'PHP', 'Python', 'Ruby', 'Java',
                    'React', 'Angular', 'Vue.js', 'Node.js', 'Laravel', 'Django', 'Ruby on Rails',
                    'WordPress', 'Shopify', 'Magento', 'Drupal', 'Joomla', 'Express.js',
                    'Next.js', 'Nuxt.js', 'Gatsby', 'Svelte', 'jQuery', 'Bootstrap', 'Tailwind CSS'
                ]
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Mobile application development for iOS and Android',
                'icon' => 'smartphone',
                'skills' => [
                    'Swift', 'Objective-C', 'Kotlin', 'Java (Android)', 'React Native', 'Flutter',
                    'Xamarin', 'Ionic', 'Android Studio', 'Xcode', 'Firebase', 'Mobile UI Design',
                    'App Store Optimization', 'Mobile App Testing', 'Push Notifications'
                ]
            ],
            [
                'name' => 'Design',
                'description' => 'Graphic, UI/UX, and visual design services',
                'icon' => 'brush',
                'skills' => [
                    'UI Design', 'UX Design', 'Graphic Design', 'Logo Design', 'Illustration',
                    'Figma', 'Adobe XD', 'Sketch', 'Photoshop', 'Illustrator', 'InDesign',
                    'After Effects', 'Premiere Pro', 'Brand Identity', 'Web Design',
                    'App Design', 'Print Design', 'Animation', 'Typography', 'Icon Design',
                    'Wireframing', 'Prototyping'
                ]
            ],
            [
                'name' => 'Writing & Translation',
                'description' => 'Content writing, copywriting, and translation services',
                'icon' => 'edit',
                'skills' => [
                    'Content Writing', 'Copywriting', 'Technical Writing', 'SEO Writing',
                    'Blog Writing', 'Creative Writing', 'Editing', 'Proofreading', 'Translation',
                    'Localization', 'Transcription', 'Research Writing', 'Grant Writing',
                    'Ghostwriting', 'Resume Writing', 'Product Descriptions'
                ]
            ],
            [
                'name' => 'Data Science & Analytics',
                'description' => 'Data analysis, machine learning, and statistical services',
                'icon' => 'bar-chart',
                'skills' => [
                    'Data Analysis', 'Machine Learning', 'Deep Learning', 'Natural Language Processing',
                    'Computer Vision', 'Statistical Analysis', 'Python for Data Science', 'R Programming',
                    'SQL', 'Tableau', 'Power BI', 'Excel', 'Data Visualization', 'TensorFlow', 'PyTorch',
                    'Scikit-learn', 'Pandas', 'NumPy', 'Big Data', 'Hadoop', 'Spark'
                ]
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Online marketing, SEO, and advertising services',
                'icon' => 'trending-up',
                'skills' => [
                    'SEO', 'SEM', 'Social Media Marketing', 'Content Marketing', 'Email Marketing',
                    'Google Ads', 'Facebook Ads', 'Instagram Marketing', 'LinkedIn Marketing',
                    'TikTok Marketing', 'YouTube Marketing', 'Influencer Marketing', 'Affiliate Marketing',
                    'Marketing Strategy', 'Analytics', 'Conversion Rate Optimization', 'A/B Testing'
                ]
            ],
            [
                'name' => 'Business & Finance',
                'description' => 'Business consulting, accounting, and financial services',
                'icon' => 'briefcase',
                'skills' => [
                    'Business Analysis', 'Financial Analysis', 'Business Strategy', 'Consulting',
                    'Accounting', 'Bookkeeping', 'Financial Modeling', 'Valuation', 'Tax Preparation',
                    'Business Planning', 'Market Research', 'Project Management', 'Virtual Assistance',
                    'Customer Service', 'Data Entry', 'Excel', 'QuickBooks', 'Financial Reporting'
                ]
            ],
            [
                'name' => 'Audio & Video',
                'description' => 'Audio engineering, video editing, and production services',
                'icon' => 'video',
                'skills' => [
                    'Video Editing', 'Audio Editing', 'Voice Over', 'Video Production', 'Animation',
                    'Motion Graphics', '3D Modeling', 'Podcast Production', 'Music Production',
                    'Sound Design', 'Mixing', 'Mastering', 'Filming', 'Post-production', 'Color Grading',
                    'Captioning', 'Subtitling'
                ]
            ],
        ];

        // Create main categories and their skills
        foreach ($mainCategories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
            ]);

            // Create skills for this category
            foreach ($categoryData['skills'] as $skillName) {
                Skill::create([
                    'name' => $skillName,
                    'slug' => Str::slug($skillName),
                    'description' => 'Skill in ' . $skillName,
                    'category_id' => $category->id
                ]);
            }
        }

        // Add subcategories to Web Development
        $webDevCategory = Category::where('slug', 'web-development')->first();
        if ($webDevCategory) {
            $webDevSubcategories = [
                [
                    'name' => 'Frontend Development',
                    'description' => 'Client-side web development',
                    'icon' => 'layout'
                ],
                [
                    'name' => 'Backend Development',
                    'description' => 'Server-side web development',
                    'icon' => 'server'
                ],
                [
                    'name' => 'CMS Development',
                    'description' => 'Content Management System development',
                    'icon' => 'file-text'
                ],
                [
                    'name' => 'E-commerce Development',
                    'description' => 'Online store and shopping cart development',
                    'icon' => 'shopping-cart'
                ],
            ];

            foreach ($webDevSubcategories as $subcategory) {
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => Str::slug($subcategory['name']),
                    'description' => $subcategory['description'],
                    'icon' => $subcategory['icon'],
                    'parent_id' => $webDevCategory->id
                ]);
            }
        }

        // Add subcategories to Design
        $designCategory = Category::where('slug', 'design')->first();
        if ($designCategory) {
            $designSubcategories = [
                [
                    'name' => 'UI/UX Design',
                    'description' => 'User interface and user experience design',
                    'icon' => 'layers'
                ],
                [
                    'name' => 'Graphic Design',
                    'description' => 'Visual and brand identity design',
                    'icon' => 'image'
                ],
                [
                    'name' => 'Logo Design',
                    'description' => 'Brand marks and visual identity design',
                    'icon' => 'award'
                ],
                [
                    'name' => 'Illustration',
                    'description' => 'Digital and traditional illustration',
                    'icon' => 'pen-tool'
                ],
            ];

            foreach ($designSubcategories as $subcategory) {
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => Str::slug($subcategory['name']),
                    'description' => $subcategory['description'],
                    'icon' => $subcategory['icon'],
                    'parent_id' => $designCategory->id
                ]);
            }
        }
    }
} 