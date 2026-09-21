<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Language;
use App\Models\Skill;
use App\Models\JobOffer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
            AdminUserSeeder::class,
        ]);
    
        // Seeder les langues
        $languages = [
            ['name' => 'Français', 'code' => 'fr'],
            ['name' => 'Anglais', 'code' => 'en'],
            ['name' => 'Espagnol', 'code' => 'es'],
            ['name' => 'Allemand', 'code' => 'de'],
            ['name' => 'Portugais', 'code' => 'pt'],
            ['name' => 'Chinois', 'code' => 'zh'],
            ['name' => 'Japonais', 'code' => 'ja'],
            ['name' => 'Arabe', 'code' => 'ar'],
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['code' => $language['code']], $language);
        }

        // Seeder les compétences
        $skills = [
            ['name' => 'PHP', 'category' => 'Programming'],
            ['name' => 'Laravel', 'category' => 'Framework'],
            ['name' => 'JavaScript', 'category' => 'Programming'],
            ['name' => 'React', 'category' => 'Framework'],
            ['name' => 'Vue.js', 'category' => 'Framework'],
            ['name' => 'Python', 'category' => 'Programming'],
            ['name' => 'Django', 'category' => 'Framework'],
            ['name' => 'Java', 'category' => 'Programming'],
            ['name' => 'Spring Boot', 'category' => 'Framework'],
            ['name' => 'SQL', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'Database'],
            ['name' => 'Git', 'category' => 'DevOps'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'Cloud'],
            ['name' => 'Azure', 'category' => 'Cloud'],
            ['name' => 'Communication', 'category' => 'Soft Skills'],
            ['name' => 'Leadership', 'category' => 'Soft Skills'],
            ['name' => 'Project Management', 'category' => 'Soft Skills'],
            ['name' => 'Team Work', 'category' => 'Soft Skills'],
            ['name' => 'Problem Solving', 'category' => 'Soft Skills'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        // Seeder les offres d'emploi
        $jobOffers = [
            [
                'title' => 'Senior Laravel Developer',
                'description' => 'Rejoignez notre équipe en tant que développeur Laravel senior avec 5+ ans d\'expérience. Vous travaillerez sur des projets innovants.',
                'company' => 'TechCorp Inc.',
                'location' => 'Paris, France',
                'salary_min' => 50000,
                'salary_max' => 70000,
                'employment_type' => 'full_time',
                'required_experience' => '5+ years',
                'required_skills' => ['Laravel', 'PHP', 'SQL', 'Git'],
                'benefits' => ['Health Insurance', 'Home Office', 'Training Budget'],
                'is_active' => true,
            ],
            [
                'title' => 'Frontend React Developer',
                'description' => 'Nous cherchons un développeur React expérimenté pour rejoindre notre équipe produit.',
                'company' => 'WebDesign Studios',
                'location' => 'Lyon, France',
                'salary_min' => 40000,
                'salary_max' => 55000,
                'employment_type' => 'full_time',
                'required_experience' => '3+ years',
                'required_skills' => ['React', 'JavaScript', 'CSS'],
                'benefits' => ['Flexible Hours', 'Team Bonding', 'Remote Work'],
                'is_active' => true,
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Nous recherchons un ingénieur DevOps pour gérer notre infrastructure cloud.',
                'company' => 'CloudServices Ltd',
                'location' => 'Toulouse, France',
                'salary_min' => 45000,
                'salary_max' => 60000,
                'employment_type' => 'full_time',
                'required_experience' => '4+ years',
                'required_skills' => ['Docker', 'AWS', 'Git', 'Linux'],
                'benefits' => ['Stock Options', 'Professional Development', 'Health Insurance'],
                'is_active' => true,
            ],
            [
                'title' => 'Python Developer',
                'description' => 'Opportunité pour un développeur Python dans une startup innovante.',
                'company' => 'StartUp AI',
                'location' => 'Bordeaux, France',
                'salary_min' => 35000,
                'salary_max' => 50000,
                'employment_type' => 'full_time',
                'required_experience' => '2+ years',
                'required_skills' => ['Python', 'Django', 'SQL'],
                'benefits' => ['Equity', 'Flexible Schedule', 'Learning Opportunities'],
                'is_active' => true,
            ],
            [
                'title' => 'Full Stack Developer',
                'description' => 'Postes à temps plein pour développeurs fullstack JavaScript/Node.js',
                'company' => 'Digital Agency',
                'location' => 'Marseille, France',
                'salary_min' => 38000,
                'salary_max' => 52000,
                'employment_type' => 'full_time',
                'required_experience' => '3+ years',
                'required_skills' => ['JavaScript', 'Node.js', 'React', 'MongoDB'],
                'benefits' => ['Bonus', 'Professional Growth', 'Team Events'],
                'is_active' => true,
            ],
        ];

        foreach ($jobOffers as $offer) {
            JobOffer::firstOrCreate(
                ['title' => $offer['title'], 'company' => $offer['company']],
                $offer
            );
        }

        // // Créer un utilisateur de test
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
