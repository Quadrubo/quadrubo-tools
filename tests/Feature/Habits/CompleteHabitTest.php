<?php

namespace Tests\Feature;

use App\Actions\CompleteHabitAction;
use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\HabitFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class CompleteHabitTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class RoleSeeder');
        $this->artisan('db:seed --class PermissionSeeder');
        $this->artisan('db:seed --class RoleHasPermissionsSeeder');
    }

    public function test_user_can_complete_habit_he_is_member_of()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        // Execute
        (new CompleteHabitAction())->execute($habit, $day, $user);
        
        // Test
        $this->assertTrue($user->hasCompletedHabit($habit, $day));
    }

    public function test_user_can_not_complete_habit_he_is_not_member_of()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->create();

        $habit->members()->detach($user->id);

        $day = Carbon::parse('2023-01-01');

        // Execute
        (new CompleteHabitAction())->execute($habit, $day, $user);
        
        // Test
        $this->assertFalse($user->hasCompletedHabit($habit, $day));
    }

    public function test_user_can_not_complete_habit_he_already_completed()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        (new CompleteHabitAction())->execute($habit, $day, $user);

        // Execute
        (new CompleteHabitAction())->execute($habit, $day, $user);
            
        // Test
        $this->assertTrue($user->hasCompletedHabit($habit, $day));
        $this->assertCount(1, $user->completedHabits()->get());
    }

    public function test_unauthenticated_user_can_not_complete_habit()
    {
        // Prepare
        $user = User::factory()->create();

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        // Execute
        (new CompleteHabitAction())->execute($habit, $day, $user);
            
        // Test
        $this->assertFalse($user->hasCompletedHabit($habit, $day));
        $this->assertCount(0, $user->completedHabits()->get());
    }

    public function test_user_can_not_complete_habit_of_different_user()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $habit = Habit::factory()->for($otherUser, 'owner')->hasAttached($otherUser, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        // Execute
        (new CompleteHabitAction())->execute($habit, $day, $otherUser);
            
        // Test
        $this->assertFalse($otherUser->hasCompletedHabit($habit, $day));
        $this->assertCount(0, $otherUser->completedHabits()->get());
    }
}
