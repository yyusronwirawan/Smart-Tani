<?php

namespace App\View\Components\Page\Device;

use Illuminate\View\Component;

class ListDevice extends Component
{
    public $device;

    /**
     * House ID
     *
     * @var string
     */

    public $houseId;


    /**
     * Create a new component instance.
     *
     * @param string $houseId
     * @return void
     */


    public function __construct($device, $houseId = '')
    {
        $this->device = $device;
        $this->houseId = $houseId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.page.device.list-device');
    }
}
