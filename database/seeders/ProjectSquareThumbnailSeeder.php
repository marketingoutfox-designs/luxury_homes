<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProjectSquareThumbnailSeeder extends Seeder
{
    public function run(): void
    {
        $entries = json_decode(file_get_contents(database_path('data/project-square-thumbnails.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($entries as $entry) {
            Project::where('slug', $entry['slug'])->firstOrFail();
            $imageFile = ltrim($entry['thumbnail'], '/');
            // Hostinger serves images from public_html beside the private Laravel folder.
            if (!is_file(public_path($imageFile)) && !is_file(dirname(base_path()).'/'.$imageFile)) {
                throw new RuntimeException('Missing square thumbnail: '.$entry['thumbnail']);
            }
        }
        DB::transaction(function () use ($entries) {
            foreach ($entries as $entry) {
                Project::where('slug', $entry['slug'])->firstOrFail()->update([
                    'image_path' => $entry['thumbnail'],
                ]);
            }
        });
    }
}
