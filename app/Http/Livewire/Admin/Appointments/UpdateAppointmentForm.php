<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateAppointmentForm extends Component
{
	public $state = [];

	public $appointment;

	public function mount(Appointment $appointment)
	{
		$this->state = $appointment->toArray();

		$this->appointment = $appointment;
	}

	public function updateAppointment()
	{
		Validator::make(
			$this->state,
			[
				'client_id' => 'required',
				'date' => 'required',
				'time' => 'required',
				'note' => 'nullable',
				'status' => 'required|in:SCHEDULED,CLOSED',
			],
			[
				'client_id.required' => 'The client field is required.'
			])->validate();

		$this->appointment->update($this->state);

		$this->dispatchBrowserEvent('alert', ['message' => 'Appointment updated successfully!']);
	}

    public function render()
    {
    	$clients = Client::all();

        return view('livewire.admin.appointments.update-appointment-form', [
        	'clients' => $clients,
        ]);
    }
}
