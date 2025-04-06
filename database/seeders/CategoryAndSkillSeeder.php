<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Skill;

class CategoryAndSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records to avoid duplicates
        DB::table('skills')->truncate();
        DB::table('categories')->truncate();
        
        // Define categories
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Development of websites and web applications',
                'icon' => 'code',
                'skills' => [
                    'HTML', 'CSS', 'JavaScript', 'TypeScript', 'React', 'Vue.js', 'Angular',
                    'Node.js', 'PHP', 'Laravel', 'WordPress', 'Django', 'Ruby on Rails',
                    'ASP.NET', 'Express.js', 'Gatsby', 'Next.js', 'Svelte'
                ]
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Development of mobile applications for iOS and Android',
                'icon' => 'mobile',
                'skills' => [
                    'iOS', 'Swift', 'Android', 'Kotlin', 'Java', 'React Native',
                    'Flutter', 'Xamarin', 'Ionic', 'Objective-C', 'Firebase'
                ]
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'User interface and user experience design',
                'icon' => 'design',
                'skills' => [
                    'Wireframing', 'Prototyping', 'User Research', 'Usability Testing',
                    'Interaction Design', 'Visual Design', 'Figma', 'Adobe XD',
                    'Sketch', 'InVision', 'User Flows', 'Information Architecture'
                ]
            ],
            [
                'name' => 'Graphic Design',
                'slug' => 'graphic-design',
                'description' => 'Creation of visual content to communicate messages',
                'icon' => 'palette',
                'skills' => [
                    'Adobe Photoshop', 'Adobe Illustrator', 'Adobe InDesign',
                    'Logo Design', 'Brand Identity', 'Typography', 'Print Design',
                    'Icon Design', 'Illustration', 'GIMP', 'CorelDRAW'
                ]
            ],
            [
                'name' => 'Content Writing',
                'slug' => 'content-writing',
                'description' => 'Creation of written content for websites, blogs, and marketing materials',
                'icon' => 'pencil',
                'skills' => [
                    'Copywriting', 'Blog Writing', 'Technical Writing', 'SEO Writing',
                    'Content Strategy', 'Editing', 'Proofreading', 'Research',
                    'Storytelling', 'Creative Writing', 'Product Descriptions'
                ]
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Promotion of products or services using digital channels',
                'icon' => 'megaphone',
                'skills' => [
                    'SEO', 'SEM', 'SMM', 'Email Marketing', 'Content Marketing',
                    'Google Ads', 'Facebook Ads', 'Analytics', 'Conversion Optimization',
                    'Marketing Automation', 'Growth Hacking', 'Influencer Marketing'
                ]
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Extraction of knowledge and insights from data',
                'icon' => 'chart',
                'skills' => [
                    'Python', 'R', 'SQL', 'Machine Learning', 'Data Visualization',
                    'Statistical Analysis', 'Big Data', 'TensorFlow', 'PyTorch',
                    'Pandas', 'NumPy', 'Deep Learning', 'NLP', 'Data Mining'
                ]
            ],
            [
                'name' => 'Project Management',
                'slug' => 'project-management',
                'description' => 'Planning, organizing, and overseeing projects',
                'icon' => 'clipboard',
                'skills' => [
                    'Agile', 'Scrum', 'Kanban', 'JIRA', 'Microsoft Project',
                    'Risk Management', 'Budgeting', 'Team Leadership',
                    'Stakeholder Management', 'PMP', 'Prince2', 'Trello'
                ]
            ],
            [
                'name' => 'Virtual Assistance',
                'slug' => 'virtual-assistance',
                'description' => 'Remote administrative and business support services',
                'icon' => 'assistant',
                'skills' => [
                    'Administrative Support', 'Email Management', 'Calendar Management',
                    'Customer Service', 'Data Entry', 'Bookkeeping', 'CRM Management',
                    'Travel Arrangements', 'Social Media Management', 'Research'
                ]
            ],
            [
                'name' => 'Video Production',
                'slug' => 'video-production',
                'description' => 'Creation of video content for various platforms',
                'icon' => 'video',
                'skills' => [
                    'Video Editing', 'Animation', 'Motion Graphics', 'Adobe Premiere Pro',
                    'After Effects', 'Final Cut Pro', 'Videography', 'Storytelling',
                    'Color Grading', 'Sound Design', 'Scriptwriting'
                ]
            ],
        ];
        
        // Insert categories and skills
        foreach ($categories as $categoryData) {
            $skills = $categoryData['skills'];
            unset($categoryData['skills']);
            
            // Create category
            $category = Category::create($categoryData);
            
            // Create skills for this category
            foreach ($skills as $skillName) {
                Skill::create([
                    'name' => $skillName,
                    'slug' => Str::slug($skillName),
                    'category_id' => $category->id
                ]);
            }
        }
    }
} 