<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Settings extends Component
{
    /**
     *
     * @return string
     *
     */
    public $device;
    public $updateUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($device, $updateUrl)
    {
        $this->device = $device;
        $this->$updateUrl = $updateUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.settings');
    }
}
