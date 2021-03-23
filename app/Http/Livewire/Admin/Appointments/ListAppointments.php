<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
	protected $listeners = ['deleteConfirmed' => 'deleteAppointment'];

	public $appointmentIdBeingRemoved = null;

	public function confirmAppointmentRemoval($appointmentId)
	{
		$this->appointmentIdBeingRemoved = $appointmentId;

		$this->dispatchBrowserEvent('show-delete-confirmation');
	}

	public function deleteAppointment()
	{
		$appointment = Appointment::findOrFail($this->appointmentIdBeingRemoved);

		$appointment->delete();

		$this->dispatchBrowserEvent('deleted', ['message' => 'Appointment deleted successfully!']);
	}

    public function render()
    {
    	$appointments = Appointment::with('client')
    		->latest()
    		->paginate();

        return view('livewire.admin.appointments.list-appointments', [
        	'appointments' => $appointments,
        ]);
    }
}
