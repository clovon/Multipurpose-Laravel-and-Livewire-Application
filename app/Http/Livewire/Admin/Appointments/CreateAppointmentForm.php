<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Client;
use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

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
				'client_id.required' => 'The client field is required.'
			])->validate();

		Appointment::create($this->state);

		$this->dispatchBrowserEvent('alert', ['message' => 'Appointment created successfully!']);

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
