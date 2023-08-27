<?php

namespace App\View\Components\Modal\Edit;

use Illuminate\View\Component;

class Lamp extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $device;

    public function __construct($device)
    {
        return $this->device = $device;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal.edit.lamp');
    }
}
