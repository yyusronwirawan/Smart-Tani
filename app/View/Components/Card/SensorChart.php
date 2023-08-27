<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class SensorChart extends Component
{
    /**
     *
     * @return string
     */
    public $title;

    /**
     *
     * @return string
     */
    public $chartUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($chartUrl, $title)
    {
        $this->title = $title;
        $this->chartUrl = $chartUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.sensor-chart');
    }
}
