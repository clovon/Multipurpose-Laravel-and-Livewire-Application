<div>
    <x-loading-indicator />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Appointments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <a href="{{ route('admin.appointments.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New Appointment</button>
                            </a>

                            @if ($selectedRows)
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-default">Bulk Actions</button>
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a wire:click.prevent="deleteSelectedRows" class="dropdown-item" href="#">Delete Selected</a>
                                    <a wire:click.prevent="markAllAsScheduled" class="dropdown-item" href="#">Mark as Scheduled</a>
                                    <a wire:click.prevent="markAllAsClosed" class="dropdown-item" href="#">Mark as Closed</a>
                                    <a wire:click.prevent="export" class="dropdown-item" href="#">Export</a>
                                </div>
                            </div>

                            <span class="ml-2">selected {{ count($selectedRows) }} {{ Str::plural('appointment', count($selectedRows)) }}</span>
                            @endif

                        </div>
                        <div class="btn-group">
                            <button wire:click="filterAppointmentsByStatus" type="button" class="btn {{ is_null($status) ? 'btn-secondary' : 'btn-default' }}">
                                <span class="mr-1">All</span>
                                <span class="badge badge-pill badge-info">{{ $appointmentsCount }}</span>
                            </button>

                            <button wire:click="filterAppointmentsByStatus('scheduled')" type="button" class="btn {{ ($status === 'scheduled') ? 'btn-secondary' : 'btn-default' }}">
                                <span class="mr-1">Scheduled</span>
                                <span class="badge badge-pill badge-primary">{{ $scheduledAppointmentsCount }}</span>
                            </button>

                            <button wire:click="filterAppointmentsByStatus('closed')" type="button" class="btn {{ ($status === 'closed') ? 'btn-secondary' : 'btn-default' }}">
                                <span class="mr-1">Closed</span>
                                <span class="badge badge-pill badge-success">{{ $closedAppointmentsCount }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input wire:model.live="selectPageRows" type="checkbox" value="" name="todo2" id="todoCheck2">
                                                <label for="todoCheck2"></label>
                                            </div>
                                        </th>
                                        <th scope="col">#</th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>
                                <tbody wire:sortable="updateAppointmentOrder">
                                    @foreach ($appointments as $appointment)
                                    <tr wire:sortable.item="{{ $appointment->id }}" wire:key="appointment-{{ $appointment->id }}">
                                        <td wire:sortable.handle style="width: 10px; cursor: move;"><i class="fa fa-arrows-alt text-muted"></i></td>
                                        <th style="width: 10px;">
                                            <div class="icheck-primary d-inline">
                                                <input wire:model.live="selectedRows" type="checkbox" value="{{ $appointment->id }}" name="todo2" id="{{ $appointment->id }}">
                                                <label for="{{ $appointment->id }}"></label>
                                            </div>
                                        </th>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $appointment->client->name }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->status_badge }}">{{ $appointment->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}">
                                                <i class="fa fa-edit mr-2"></i>
                                            </a>

                                            <a href="" wire:click.prevent="confirmAppointmentRemoval({{ $appointment->id }})">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            {!! $appointments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <x-confirmation-alert />
</div>

@push('styles')
<style>
    .draggable-mirror {
        background-color: white;
        width: 950px;
        display: flex;
        justify-content: space-between;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@push('after-livewire-scripts')
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush
