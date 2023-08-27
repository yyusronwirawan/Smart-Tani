<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Maps extends Component
{
    /**
     *
     *
     * @var string
     */
    public $device;
    public $location;
    public $zoom;

    /**
     * Create a new component instance.
     *
     * @param string $device
     * @param string $location
     * @return void
     */
    public function __construct($device, $location, $zoom)
    {
        $this->zoom = $zoom;
        $this->device = $device;
        $this->location = $location;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.maps');
    }
}
