<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Test Youth',
            'email' => 'youth@example.com',
            'password' => bcrypt('Secret123!'),
            'is_active' => true,
            'activated_at' => now(),
            'email_verified_at' => now(),
        ], $attributes));
    }

    public function test_active_role_less_user_can_log_into_admin_panel(): void
    {
        $this->makeUser();

        Livewire::test(Login::class)
            ->fillForm(['email' => 'youth@example.com', 'password' => 'Secret123!'])
            ->call('authenticate')
            ->assertHasNoErrors();

        $this->assertAuthenticated();
        $this->assertSame('youth@example.com', auth()->user()->email);
    }

    public function test_inactive_user_is_rejected_from_admin_panel(): void
    {
        $this->makeUser([
            'email' => 'inactive@example.com',
            'is_active' => false,
            'activated_at' => null,
        ]);

        Livewire::test(Login::class)
            ->fillForm(['email' => 'inactive@example.com', 'password' => 'Secret123!'])
            ->call('authenticate');

        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected_from_admin_panel(): void
    {
        $this->makeUser();

        Livewire::test(Login::class)
            ->fillForm(['email' => 'youth@example.com', 'password' => 'WrongPass!'])
            ->call('authenticate')
            ->assertHasErrors();

        $this->assertGuest();
    }

    public function test_youth_sees_only_own_applications_in_panel(): void
    {
        $youth = $this->makeUser();
        $other = $this->makeUser(['email' => 'other@example.com']);

        $opportunity = \App\Models\Opportunity::create([
            'title' => 'Youth Coding Bootcamp',
            'slug' => 'youth-coding-bootcamp',
            'category' => \App\Enums\OpportunityCategory::Training->value,
            'summary' => 'Learn to code.',
            'description' => 'A full description of the bootcamp programme.',
            'status' => \App\Enums\ContentStatus::Published->value,
            'published_at' => now(),
        ]);

        \App\Models\OpportunityApplication::create([
            'opportunity_id' => $opportunity->id,
            'user_id' => $youth->id,
            'status' => \App\Enums\ApplicationStatus::Submitted->value,
        ]);

        \App\Models\OpportunityApplication::create([
            'opportunity_id' => $opportunity->id,
            'user_id' => $other->id,
            'status' => \App\Enums\ApplicationStatus::Submitted->value,
        ]);

        $this->actingAs($youth);

        $list = \App\Filament\Resources\OpportunityApplications\Pages\ListOpportunityApplications::class;

        Livewire::test($list)
            ->assertSuccessful();

        $query = \App\Filament\Resources\OpportunityApplications\OpportunityApplicationResource::getEloquentQuery();
        $this->assertSame(1, $query->count(), 'Youth should only see their own applications');
        $this->assertSame($youth->id, (int) $query->first()->user_id);
    }

    public function test_youth_cannot_manage_content_resources(): void
    {
        $youth = $this->makeUser();

        $this->actingAs($youth);

        $this->assertFalse(
            \App\Filament\Resources\News\NewsResource::canViewAny(),
            'Youth must not see back-office-only resources'
        );
        $this->assertFalse(
            \App\Filament\Resources\Users\UserResource::canViewAny(),
            'Youth must not see the users resource'
        );
        $this->assertTrue(
            \App\Filament\Resources\Programmes\ProgrammeResource::canViewAny(),
            'Youth should see programmes'
        );
        $this->assertTrue(
            \App\Filament\Resources\Opportunities\OpportunityResource::canViewAny(),
            'Youth should see opportunities'
        );
    }
}
