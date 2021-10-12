<?php

namespace Tests\Feature\Http\Livewire\Admin\Appointments;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Livewire\Admin\Appointments\CreateAppointmentForm;
use App\Models\Appointment;

class CreateAppointmentFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_the_create_appointment_page()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get('/admin/appointments/create')
            ->assertStatus(200);
    }

    /** @test */
    public function it_performs_a_validation()
    {
        Livewire::test(CreateAppointmentForm::class)
            ->set('state', [
                'client_id' => '',
                'members' => '',
                'color' => '',
                'date' => '',
                'time' => '',
                'status' => '',
            ])
            ->call('createAppointment')
            ->assertHasErrors([
                'client_id' => 'required',
                'members' => 'required',
                'color' => 'required',
				'date' => 'required',
				'time' => 'required',
				'status' => 'required',
            ]);
    }

    /** @test */
    public function it_requires_a_valid_status_value()
    {
        Livewire::test(CreateAppointmentForm::class)
            ->set('state', ['status' => 'INVALID'])
            ->call('createAppointment')
            ->assertHasErrors(['status']);
    }

    /** @test */
    public function it_can_create_appointment()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(CreateAppointmentForm::class)
            ->set('state', $attributes = [
                'client_id' => Client::factory()->create()->id,
                'members' => 'one',
                'color' => '#000000',
                'date' => '2021-08-27',
                'time' => '2:00am',
                'status' => 'CLOSED',
                'order_position' => 0,
            ])->call('createAppointment')
            ->assertRedirect(route('admin.appointments'));

        tap(Appointment::first(), function ($appointment) use ($attributes) {
            $this->assertEquals($attributes['client_id'], $appointment->client_id);
            $this->assertEquals('one', $appointment->members);
            $this->assertEquals('#000000', $appointment->color);
            $this->assertEquals('2021-08-27', $appointment->date);
            $this->assertEquals('02:00 AM', $appointment->time);
            $this->assertEquals('CLOSED', $appointment->status);
            $this->assertEquals('0', $appointment->order_position);
        });
    }
}
