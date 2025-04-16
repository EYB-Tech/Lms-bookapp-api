<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FloatingTextarea extends Component
{
    public $name;
    public $value;
    public $rows;
    public $placeholder;
    public $label;
    public $class;
    public $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name = '',
        $value = '',
        $rows = 4,
        $placeholder = '',
        $label = '',
        $class = '',
        $id = ''
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->rows = $rows;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->class = $class;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.floating-textarea');
    }
}
