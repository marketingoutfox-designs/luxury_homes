<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectDriveMediaSeeder extends Seeder
{
    public function run(): void
    {
        $entries = json_decode(file_get_contents(database_path('data/project-drive-media.json')), true, 512, JSON_THROW_ON_ERROR);
        // Validate all projects before changing any records.
        foreach ($entries as $entry) {
            Project::where('slug', $entry['slug'])->firstOrFail();
        }
        DB::transaction(function () use ($entries) {
            foreach ($entries as $entry) {
                $project = Project::where('slug', $entry['slug'])->firstOrFail();
                $project->update(['image_path' => $entry['thumbnail'], 'hero_image_path' => $entry['hero']]);
                foreach ($entry['media'] as $media) {
                    $project->media()->updateOrCreate(['path' => $media['path']], [
                        'type' => 'image', 'original_name' => $media['original_name'],
                        'mime_type' => 'image/webp', 'sort_order' => $media['sort_order'],
                    ]);
                }
            }
        });
    }
}
