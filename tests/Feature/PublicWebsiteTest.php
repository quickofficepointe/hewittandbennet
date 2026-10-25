<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\courses;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** The public website: every page loads, homepage anchors exist, and the contact form works. */
class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_every_public_page_loads(): void
    {
        $course = courses::firstOrFail();
        $pages = [
            '/', '/courses', '/courses?search='.urlencode($course->name), '/course/'.$course->slug, '/contact',
            '/courses/othercourses', '/courses/caregivercourses', '/courses/cnacourses', '/courses/hosipitality',
            '/accreditations', '/feesstructure', '/registration', '/apply', '/workabroad', '/gallery',
            '/hewittandbennet/news', '/jobs', '/attachment', '/login',
            '/director/message', '/principal/message', '/dean/message', '/Captain/message',
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $this->assertSame(200, $response->status(), "GET {$url} returned {$response->status()}".
                ($response->status() >= 500 ? ': '.($response->exception?->getMessage() ?? '') : ''));
        }
    }

    public function test_homepage_has_the_sections_the_menu_links_to(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        foreach (['about', 'courses', 'admissions', 'campuses', 'work-abroad', 'news', 'gallery', 'contact'] as $id) {
            $this->assertStringContainsString("id=\"{$id}\"", $html, "Homepage is missing #{$id}");
        }
        $this->assertStringContainsString('og:image', $html);
        $this->assertStringNotContainsString('href="#"', $html);
    }

    public function test_course_search_filters_the_list(): void
    {
        [$first, $second] = courses::take(2)->get()->all() + [null, null];
        $this->assertNotNull($second, 'Demo data needs at least two courses.');

        $this->get('/courses?search='.urlencode($first->name))
            ->assertSee($first->name)
            ->assertDontSee('>'.e($second->name).'</a>', false);
    }

    public function test_contact_form_saves_message_and_admin_can_handle_it(): void
    {
        $this->post('/contact', [
            'name' => 'Amina Otieno',
            'email' => 'amina@example.com',
            'phone' => '+254700000000',
            'subject' => 'Work Abroad Program',
            'message' => 'I would like to know about the Germany program.',
        ])->assertRedirect()->assertSessionHas('success');

        $message = ContactMessage::sole();
        $this->assertSame('Work Abroad Program', $message->subject);

        $admin = User::where('username', 'admin')->firstOrFail();
        $this->actingAs($admin)->get(route('portal.admin.contact-messages.index'))->assertOk()->assertSee('Amina Otieno');
        $this->actingAs($admin)->patch(route('portal.admin.contact-messages.read', $message))->assertRedirect();
        $this->assertTrue($message->fresh()->is_read);
    }

    public function test_contact_form_validates_and_ignores_bots(): void
    {
        $this->post('/contact', ['name' => '', 'email' => 'not-an-email', 'subject' => 'Hacking', 'message' => ''])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->post('/contact', [
            'name' => 'Bot', 'email' => 'bot@example.com', 'subject' => 'General Enquiry', 'message' => 'spam', 'website' => 'http://spam.test',
        ])->assertSessionHas('success');

        $this->assertSame(0, ContactMessage::count());
    }
}
