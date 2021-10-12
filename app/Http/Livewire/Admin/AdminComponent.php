<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class AdminComponent extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';
}
