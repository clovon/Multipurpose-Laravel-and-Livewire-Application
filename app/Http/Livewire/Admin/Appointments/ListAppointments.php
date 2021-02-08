<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;

class ListAppointments extends AdminComponent
{
    public function render()
    {
        return view('livewire.admin.appointments.list-appointments');
    }
}
