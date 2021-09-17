<?php

namespace App\View\Components;


use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;
    public string $message;
    public ?string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type, string $message, ?string $class = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.alert');
    }
}
