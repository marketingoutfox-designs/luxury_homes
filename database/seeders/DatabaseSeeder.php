<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@luxuryhomes.local'],
            ['name' => 'Luxury Homes Admin', 'password' => Hash::make('admin12345')]
        );

        $completed = ProjectCategory::updateOrCreate(['slug' => 'completed'], ['name' => 'Completed', 'sort_order' => 1, 'is_active' => true]);
        $ongoing = ProjectCategory::updateOrCreate(['slug' => 'ongoing'], ['name' => 'Ongoing', 'sort_order' => 2, 'is_active' => true]);
        $upcoming = ProjectCategory::updateOrCreate(['slug' => 'upcoming'], ['name' => 'Ongoing', 'sort_order' => 3, 'is_active' => true]);

        collect([
            ['Aurum Residences', 'aurum-residences', 'New Delhi', $completed->id],
            ['The Courtyard House', 'the-courtyard-house', 'Gurugram', $completed->id],
            ['The Sculpted Home', 'the-sculpted-home', 'New Delhi', $ongoing->id],
            ['Nirman Residence', 'nirman-residence', 'New Delhi', $completed->id],
            ['The Garden Villa', 'the-garden-villa', 'Noida', $upcoming->id],
            ['The Quiet House', 'the-quiet-house', 'Gurugram', $completed->id],
        ])->each(function (array $project, int $index): void {
            Project::updateOrCreate(
                ['slug' => $project[1]],
                [
                    'project_category_id' => $project[3],
                    'title' => $project[0],
                    'location' => $project[2],
                    'status' => $index === 2 ? 'Ongoing' : ($index === 4 ? 'Ongoing' : 'Completed'),
                    'image_path' => '/images/luxury-homes/hero.jpg',
                    'hero_image_path' => '/images/luxury-homes/hero.jpg',
                    'summary' => 'A refined residence shaped around proportion, light, and long-term value.',
                    'description' => "This project can be fully edited from the admin panel.\nAdd project story, materials, scope, location, and gallery image paths here.",
                    'sort_order' => $index + 1,
                    'is_featured' => $index === 0,
                    'is_active' => true,
                ]
            );
        });

        collect([
            ['Architecture & Planning', 'architecture-planning', '01', 'Site-sensitive planning, spatial strategy, and architecture shaped around the way you live.'],
            ['Interior Design', 'interior-design', '02', 'Material-led interiors with a refined balance of comfort, function, and character.'],
            ['Turnkey Construction', 'turnkey-construction', '03', 'Carefully managed execution, from civil work and services to finishes and final detailing.'],
            ['Project Management', 'project-management', '04', 'Clear budgets, considered timelines, and transparent coordination across every discipline.'],
            ['Handover & Aftercare', 'handover-aftercare', '05', 'A meticulous final review and responsive support beyond the day you move in.'],
        ])->each(fn (array $service, int $index) => Service::updateOrCreate(
            ['slug' => $service[1]],
            ['title' => $service[0], 'icon' => $service[2], 'summary' => $service[3], 'sort_order' => $index + 1, 'is_active' => true]
        ));

        collect([
            ['home_landing', 'Home Landing Artwork Path', 'Home Landing Page', '/images/luxury-homes/landing-page-reference.png'],
            ['about_intro', 'About Intro', 'About Luxury Homes', "Luxury Homes was built on a simple belief — that homes deserve more thought, more care, and greater accountability.\nWe focus on fewer developments, ensuring each project is approached with clarity, precision, and long-term value in mind."],
            ['about_rohit', 'Rohit Kapoor Bio', 'ROHIT KAPOOR', "At Luxury Homes, we create more than just residences — we craft thoughtfully designed living spaces that bring comfort, security, and a lasting sense of belonging.\nDriven by a commitment to excellence, we combine refined design, superior craftsmanship, and modern construction practices to deliver homes that are both timeless and enduring.\nOur approach is rooted in transparency, integrity, and customer trust. We ensure a seamless and rewarding experience from concept to completion."],
            ['about_hitesh', 'Hitesh Kapoor Bio', 'HITESH VINOD KAPOOR', "As a Co-Founder, Hitesh brings a hospitality-driven perspective to luxury residential design.\nWith a deep understanding of how spaces are experienced, his approach focuses on creating homes that feel intuitive, refined, and timeless.\nFrom spatial planning to material selection, every detail is thoughtfully considered."],
            ['services_intro', 'Services Intro', 'A COMPLETE APPROACH TO EXCEPTIONAL HOMES.', 'Our integrated process brings design, construction, and delivery together—giving every decision greater clarity and every detail the attention it deserves.'],
        ])->each(fn (array $content) => SiteContent::updateOrCreate(
            ['key' => $content[0]],
            ['label' => $content[1], 'title' => $content[2], 'body' => $content[3]]
        ));
    }
}
