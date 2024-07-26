<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $items;
    public $columns;
    public $fields;
    public $editRoute;
    public $deleteRoute;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items, $columns, $fields, $editRoute, $deleteRoute)
    {
        $this->items = $items;
        $this->columns = $columns;
        $this->fields = $fields;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
