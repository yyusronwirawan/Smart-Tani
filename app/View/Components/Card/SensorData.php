<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class SensorData extends Component
{
    public $device;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($device)
    {
        $this->device = $device;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.sensor-data');
    }
}
