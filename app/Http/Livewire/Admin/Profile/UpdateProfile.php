<?php

namespace App\Http\Livewire\Admin\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;

    public function updatedImage()
    {
        $path = $this->image->store('/', 'avatars');

        auth()->user()->update(['avatar' => $path]);

        $this->dispatchBrowserEvent('updated', ['message' => 'Profile changed successfully!']);
    }

    public function render()
    {
        return view('livewire.admin.profile.update-profile');
    }
}
