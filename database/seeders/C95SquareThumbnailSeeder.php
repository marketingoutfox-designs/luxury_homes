<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class C95SquareThumbnailSeeder extends Seeder
{
    public function run(): void
    {
        Project::where('slug', 'c-95-nirman-vihar')->firstOrFail()->update([
            'image_path' => '/images/projects/c-95-nirman-vihar/c-95-square-ai.png',
        ]);
    }
}
