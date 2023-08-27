<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Setup extends Component
{
    /**
     *
     *
     * @return string
     */
    public $device;
    public $updateUrl;
    public $houseId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($device, $updateUrl = '', $houseId = '')
    {
        $this->device = $device;
        $this->updateUrl = $updateUrl;
        $this->houseId = $houseId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.setup');
    }
}
