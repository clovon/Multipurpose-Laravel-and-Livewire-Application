<?php

namespace Tests\Feature\Http\Livewire\Admin\Appointments;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Livewire\Admin\Appointments\ListAppointments;

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

    public function test_it_can_mark_selected_appointments_as_scheduled()
    {
        $this->actingAs(User::factory()->admin()->create());

        [$appointment1, $appointment2] = Appointment::factory()->closed()->count(2)->create();

        Livewire::test(ListAppointments::class)
            ->set('selectedRows', ['1', '2'])
            ->call('markAllAsScheduled');

        $this->assertEquals(Appointment::STATUS_SCHEDULED, $appointment1->fresh()->status);
        $this->assertEquals(Appointment::STATUS_SCHEDULED, $appointment2->fresh()->status);
    }

    public function test_it_can_mark_selected_appointments_as_closed()
    {
        $this->actingAs(User::factory()->admin()->create());

        [$appointment1, $appointment2] = Appointment::factory()->scheduled()->count(2)->create();

        Livewire::test(ListAppointments::class)
            ->set('selectedRows', ['1', '2'])
            ->call('markAllAsClosed');

        $this->assertEquals(Appointment::STATUS_CLOSED, $appointment1->fresh()->status);
        $this->assertEquals(Appointment::STATUS_CLOSED, $appointment2->fresh()->status);
    }

    public function test_it_can_delete_all_selected_appointments()
    {
        $this->actingAs(User::factory()->admin()->create());

        [$appointment1, $appointment2] = Appointment::factory()->count(2)->create();

        Livewire::test(ListAppointments::class)
            ->set('selectedRows', ['1', '2'])
            ->call('deleteSelectedRows');

        $this->assertDatabaseMissing('appointments', [$appointment1, $appointment2]);
    }

    public function test_it_can_delete_appointment()
    {
        $this->actingAs(User::factory()->admin()->create());

        $appointment = Appointment::factory()->create();

        Livewire::test(ListAppointments::class)
            ->set('appointmentIdBeingRemoved', $appointment->id)
            ->call('deleteAppointment');

        $this->assertDatabaseMissing('appointments', [$appointment]);
    }
}
