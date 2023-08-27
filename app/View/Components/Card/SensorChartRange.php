<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class SensorChartRange extends Component
{
    /**
     *
     * @return string
     */
    public $chartRangeUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($chartRangeUrl)
    {
        $this->chartRangeUrl = $chartRangeUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.sensor-chart-range');
    }
}
