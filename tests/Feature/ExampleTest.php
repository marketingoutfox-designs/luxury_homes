<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_all_public_pages_return_successful_responses(): void
    {
        foreach (['/', '/about-us', '/our-works', '/our-works/aurum-residences', '/services', '/contact-us'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_homepage_uses_real_sections_instead_of_the_flattened_artwork(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('class="home-hero"', false)
            ->assertSee('class="home-expertise"', false)
            ->assertSee('class="home-project-grid"', false)
            ->assertSee('href="https://wa.me/918340000005"', false)
            ->assertDontSee('lp-exact-art', false)
            ->assertDontSee('landing-page-reference', false);
    }

    public function test_admin_login_page_loads_and_admin_redirects_to_login(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_pages_return_successful_responses(): void
    {
        $this->actingAs(User::first());

        Lead::create([
            'name' => 'Demo Lead',
            'phone' => '9999999999',
            'interest' => 'Project consultation',
            'message' => 'Need a consultation.',
        ]);

        $category = ProjectCategory::first();
        $project = Project::first();
        $service = Service::first();
        $content = SiteContent::first();
        $lead = Lead::first();

        foreach ([
            '/admin',
            '/admin/project-categories',
            '/admin/project-categories/create',
            "/admin/project-categories/{$category->id}/edit",
            '/admin/projects',
            '/admin/projects/create',
            "/admin/projects/{$project->slug}/edit",
            '/admin/services',
            '/admin/services/create',
            "/admin/services/{$service->id}/edit",
            '/admin/content',
            '/admin/content/create',
            "/admin/content/{$content->id}/edit",
            '/admin/leads',
            "/admin/leads/{$lead->id}/edit",
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_admin_can_upload_webp_images_and_mixed_popup_media(): void
    {
        $temporaryPublicPath = sys_get_temp_dir().'/luxury-homes-test-'.uniqid();
        File::ensureDirectoryExists($temporaryPublicPath);
        $this->app->usePublicPath($temporaryPublicPath);

        try {
            $project = Project::firstOrFail();

            $response = $this->actingAs(User::firstOrFail())->put(route('admin.projects.update', $project), [
                'title' => $project->title,
                'slug' => $project->slug,
                'status' => $project->status,
                'sort_order' => $project->sort_order,
                'is_active' => '1',
                'card_image_upload' => UploadedFile::fake()->image('card.png', 600, 700),
                'hero_image_upload' => UploadedFile::fake()->image('hero.jpg', 1200, 700),
                'popup_media' => [
                    UploadedFile::fake()->image('room.png', 900, 600),
                    UploadedFile::fake()->create('walkthrough.mp4', 256, 'video/mp4'),
                ],
            ]);

            $response->assertRedirect(route('admin.projects'));
            $project->refresh()->load('media');

            $this->assertStringEndsWith('.webp', $project->image_path);
            $this->assertStringEndsWith('.webp', $project->hero_image_path);
            $this->assertFileExists(public_path(ltrim($project->image_path, '/')));
            $this->assertFileExists(public_path(ltrim($project->hero_image_path, '/')));
            $this->assertSame(['image', 'video'], $project->media->pluck('type')->all());
            $this->assertStringEndsWith('.webp', $project->media->first()->path);
            $this->assertStringEndsWith('.mp4', $project->media->last()->path);
        } finally {
            File::deleteDirectory($temporaryPublicPath);
        }
    }
}
