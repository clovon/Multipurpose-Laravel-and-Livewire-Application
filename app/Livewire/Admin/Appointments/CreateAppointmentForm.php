<?php

namespace App\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateAppointmentForm extends Component
{
    public $state = [
        'status' => 'SCHEDULED',
        'order_position' => 0,
    ];

    public function createAppointment()
    {
        Validator::make(
            $this->state,
            [
                'client_id' => 'required',
                'members' => 'required',
                'color' => 'required',
                'date' => 'required',
                'time' => 'required',
                'note' => 'nullable',
                'status' => 'required|in:SCHEDULED,CLOSED',
            ],
            [
                'client_id.required' => 'The client field is required.',
            ])->validate();

        Appointment::create($this->state);

        $this->dispatch('alert', ['message' => 'Appointment created successfully!']);

        return redirect()->route('admin.appointments');
    }

    public function render()
    {
        $clients = Client::all();

        return view('livewire.admin.appointments.create-appointment-form', [
            'clients' => $clients,
        ]);
    }
}
