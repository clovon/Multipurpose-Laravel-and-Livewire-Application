<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
	protected $listeners = ['deleteConfirmed' => 'deleteAppointment'];

	public $appointmentIdBeingRemoved = null;

	public $status = null;

	protected $queryString = ['status'];

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

	public function filterAppointmentsByStatus($status = null)
	{
		$this->resetPage();
		
		$this->status = $status;
	}

    public function render()
    {
    	$appointments = Appointment::with('client')
    		->when($this->status, function ($query, $status) {
    			return $query->where('status', $status);
    		})
    		->latest()
    		->paginate(3);

    	$appointmentsCount = Appointment::count();
    	$scheduledAppointmentsCount = Appointment::where('status', 'scheduled')->count();
    	$closedAppointmentsCount = Appointment::where('status', 'closed')->count();

        return view('livewire.admin.appointments.list-appointments', [
        	'appointments' => $appointments,
        	'appointmentsCount' => $appointmentsCount,
        	'scheduledAppointmentsCount' => $scheduledAppointmentsCount,
        	'closedAppointmentsCount' => $closedAppointmentsCount,
        ]);
    }
}
