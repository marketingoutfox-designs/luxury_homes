<?php
namespace Database\Seeders;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ProjectPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $rows = json_decode(<<<'JSON'
[["151 Madhuvan Enclave", "2018–2021", "Completed"], ["C-95 Nirman Vihar", "2022–2023", "Completed"], ["A-23 Nirman Vihar", "2023–2024", "Completed"], ["A-61 Nirman Vihar", "2024–2025", "Completed"], ["A-72 Preet Vihar", "2024–2027", "Ongoing"], ["A-64 Madhuvan", "2024–2026", "Completed"], ["E-326 Nirman Vihar", "2025–2026", "Completed"], ["C-442 Nirman Vihar", "2025–2027", "Ongoing"], ["B-41 Swasthya Vihar", "2025–2027", "Ongoing"], ["C-98 Nirman Vihar", "2025–2027", "Ongoing"], ["65 AGCR Enclave", "2026–2027", "Ongoing"], ["B-417 Nirman Vihar", "2026–2027", "Ongoing"], ["92 Rajdhani Enclave", "2027–2028", "Ongoing"], ["98 Golf Link", "2027–2029", "Ongoing"]]
JSON, true);
        DB::transaction(function () use ($rows) {
            $slugs = array_map(fn ($row) => Str::slug($row[0]), $rows);
            Project::whereNotIn('slug', $slugs)->update(['is_active' => false]);
            foreach ($rows as $index => [$title, $years, $status]) {
                $project = Project::firstOrNew(['slug' => $slugs[$index]]);
                $project->fill([
                    'title' => $title, 'status' => $status,
                    'facts' => array_merge($project->facts ?? [], ['address' => $title, 'years' => $years]),
                    'sort_order' => $index + 1, 'is_active' => true,
                ]);
                if (! $project->exists) {
                    $project->image_path = '/images/luxury-homes/project-photo-pending.svg';
                    $project->hero_image_path = '/images/luxury-homes/project-photo-pending.svg';
                }
                $project->save();
            }
        });
    }
}
