<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Livewire\Component;

class CreateAppointmentForm extends Component
{
	public $state = [];

	public function createAppointment()
	{
		//validate
		$this->state['time'] = '00:00:00';
		$this->state['status'] = 'open';
		Appointment::create($this->state);

		$this->dispatchBrowserEvent('alert', ['message' => 'Appointment created successfully!']);
	}

    public function render()
    {
    	$clients = Client::all();

        return view('livewire.admin.appointments.create-appointment-form', [
        	'clients' => $clients,
        ]);
    }
}
