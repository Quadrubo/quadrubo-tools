<?php

namespace Tests\Feature;

use App\Actions\CompleteHabitAction;
use App\Actions\UncompleteHabitAction;
use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\HabitFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class UncompleteHabitTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class RoleSeeder');
        $this->artisan('db:seed --class PermissionSeeder');
        $this->artisan('db:seed --class RoleHasPermissionsSeeder');
    }

    public function test_user_can_uncomplete_habit_he_is_member_of()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        (new CompleteHabitAction())->execute($habit, $day, $user);

        // Execute
        (new UncompleteHabitAction())->execute($habit, $day, $user);
        
        // Test
        $this->assertFalse($user->hasCompletedHabit($habit, $day));
    }

    public function test_user_can_not_uncomplete_habit_he_is_not_member_of()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->create();

        $day = Carbon::parse('2023-01-01');

        (new CompleteHabitAction())->execute($habit, $day, $user);

        $habit->members()->detach($user->id);

        // Execute
        (new UncompleteHabitAction())->execute($habit, $day, $user);
        
        // Test
        $this->assertTrue($user->hasCompletedHabit($habit, $day));
    }

    public function test_user_can_not_uncomplete_habit_he_already_uncompleted()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        (new CompleteHabitAction())->execute($habit, $day, $user);

        (new UncompleteHabitAction())->execute($habit, $day, $user);

        // Execute
        (new UncompleteHabitAction())->execute($habit, $day, $user);
            
        // Test
        $this->assertFalse($user->hasCompletedHabit($habit, $day));
        $this->assertCount(0, $user->completedHabits()->get());
    }

    public function test_unauthenticated_user_can_not_uncomplete_habit()
    {
        // Prepare
        $user = User::factory()->create();

        $habit = Habit::factory()->for($user, 'owner')->hasAttached($user, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        $habit->completedHabits()->create(['user_id' => $user->id, 'completed_on' => $day]);

        // Execute
        (new UncompleteHabitAction())->execute($habit, $day, $user);
            
        // Test
        $this->assertTrue($user->hasCompletedHabit($habit, $day));
        $this->assertCount(1, $user->completedHabits()->get());
    }

    public function test_user_can_not_uncomplete_habit_of_different_user()
    {
        // Prepare
        $user = User::factory()->create();

        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $habit = Habit::factory()->for($otherUser, 'owner')->hasAttached($otherUser, [], 'members')->create();

        $day = Carbon::parse('2023-01-01');

        $habit->completedHabits()->create(['user_id' => $otherUser->id, 'completed_on' => $day]);

        // Execute
        (new UncompleteHabitAction())->execute($habit, $day, $otherUser);
            
        // Test
        $this->assertTrue($otherUser->hasCompletedHabit($habit, $day));
        $this->assertCount(1, $otherUser->completedHabits()->get());
    }
}
