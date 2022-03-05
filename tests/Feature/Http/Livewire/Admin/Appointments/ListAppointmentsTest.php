<?php

namespace Tests\Feature\Http\Livewire\Admin\Appointments;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAppointmentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_list_appointments_page()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/admin/appointments')
            ->assertOk();
    }

    public function test_it_shows_all_the_appointments_by_default()
    {
        $this->actingAs(User::factory()->admin()->create());

        $appointment1 = Appointment::factory()->scheduled()->create();
        $appointment2 = Appointment::factory()->closed()->create(['date' => now()->addDay(1)]);

        $this->get('/admin/appointments')
            ->assertSee($appointment1->client->name)
            ->assertSee($appointment2->client->name)
            ->assertSee($appointment1->date)
            ->assertSee($appointment2->date)
            ->assertSee($appointment1->status)
            ->assertSee($appointment2->status);
    }

    public function test_it_can_show_scheduled_appointments()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->admin()->create());

        $appointment1 = Appointment::factory()->scheduled()->create();
        $appointment2 = Appointment::factory()->closed()->create(['date' => now()->addDay(1)]);

        $this->get('/admin/appointments?status=scheduled')
            ->assertSee($appointment1->client->name)
            ->assertDontSee($appointment2->client->name)
            ->assertSee($appointment1->date)
            ->assertDontSee($appointment2->date)
            ->assertSee('<span class="badge badge-primary">scheduled</span>', false)
            ->assertDontSee('<span class="badge badge-success">closed</span>', false);
    }

    public function test_it_can_show_closed_appointments()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->admin()->create());

        $appointment1 = Appointment::factory()->closed()->create(['date' => now()->addDay(1)]);
        $appointment2 = Appointment::factory()->scheduled()->create();

        $this->get('/admin/appointments?status=closed')
            ->assertSee($appointment1->client->name)
            ->assertDontSee($appointment2->client->name)
            ->assertSee($appointment1->date)
            ->assertDontSee($appointment2->date)
            ->assertSee('<span class="badge badge-success">closed</span>', false)
            ->assertDontSee('<span class="badge badge-primary">scheduled</span>', false);
    }
}
