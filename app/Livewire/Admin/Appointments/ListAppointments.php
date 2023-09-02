<?php

namespace App\Livewire\Admin\Appointments;

use App\Exports\AppointmentsExport;
use App\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
    protected $listeners = ['deleteConfirmed' => 'deleteAppointment'];

    public $appointmentIdBeingRemoved = null;

    public $status = null;

    protected $queryString = ['status'];

    public $selectedRows = [];

    public $selectPageRows = false;

    public function confirmAppointmentRemoval($appointmentId)
    {
        $this->appointmentIdBeingRemoved = $appointmentId;

        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAppointment()
    {
        $appointment = Appointment::findOrFail($this->appointmentIdBeingRemoved);

        $appointment->delete();

        $this->dispatch('deleted', ['message' => 'Appointment deleted successfully!']);
    }

    public function filterAppointmentsByStatus($status = null)
    {
        $this->resetPage();

        $this->status = $status;
    }

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->appointments->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getAppointmentsProperty()
    {
        return Appointment::with('client')
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('order_position', 'asc')
            ->paginate(10);
    }

    public function markAllAsScheduled()
    {
        Appointment::whereIn('id', $this->selectedRows)->update(['status' => Appointment::STATUS_SCHEDULED]);

        $this->dispatch('updated', ['message' => 'Appointments marked as scheduled']);

        $this->reset(['selectPageRows', 'selectedRows']);
    }

    public function markAllAsClosed()
    {
        Appointment::whereIn('id', $this->selectedRows)->update(['status' => Appointment::STATUS_CLOSED]);

        $this->dispatch('updated', ['message' => 'Appointments marked as closed.']);

        $this->reset(['selectPageRows', 'selectedRows']);
    }

    public function deleteSelectedRows()
    {
        Appointment::whereIn('id', $this->selectedRows)->delete();

        $this->dispatch('deleted', ['message' => 'All selected appointment got deleted.']);

        $this->reset(['selectPageRows', 'selectedRows']);
    }

    public function export()
    {
        return (new AppointmentsExport($this->selectedRows))->download('appointments.xls');
    }

    public function updateAppointmentOrder($items)
    {
        foreach ($items as $item) {
            Appointment::find($item['value'])->update(['order_position' => $item['order']]);
        }

        $this->dispatch('updated', ['message' => 'Appointments sorted successfully.']);
    }

    public function render()
    {
        $appointments = $this->appointments;

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
