<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpdateSetting extends Component
{
    public $state = [];

    public function mount()
    {
        $setting = Setting::first();

        if ($setting) {
            $this->state = $setting->toArray();
        }
    }

    public function updateSetting()
    {
        $setting = Setting::first();

        if ($setting) {
            $setting->update($this->state);
        } else {
            Setting::create($this->state);
        }

        Cache::forget('setting');

        $this->dispatch('updated', ['message' => 'Settings updated successfully!']);
    }

    public function render()
    {
        return view('livewire.admin.settings.update-setting');
    }
}
