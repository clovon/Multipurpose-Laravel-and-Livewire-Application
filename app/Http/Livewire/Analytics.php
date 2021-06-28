<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Analytics extends Component
{
    public $days = [];

    public $subscribers = [30, 36, 42, 78, 88, 109, 205, 325, 349, 480, 556];

    public $recentSubscribers = 556;

    public function mount()
    {
        $this->days = collect(range(13, 24))->map(function ($number) {
            return 'Jun ' . $number;
        });
    }

    public function fetchData()
    {
        // $this->recentSubscribers += 10;
        $subscribers = array_replace($this->subscribers, [10 => $this->recentSubscribers += 10]);

        $this->emit('refreshChart', ['seriesData' => $subscribers]);
    }

    public function render()
    {
        return view('livewire.analytics')->layout('layouts.realtime');
    }
}
