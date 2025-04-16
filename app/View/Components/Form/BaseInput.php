<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseInput extends Component
{
    public $type;
    public $name;
    public $value;
    public $placeholder;
    public $label;
    public $accept;
    public $attrs;
    public $class;
    public $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $type = 'text',
        $name = '',
        $value = '',
        $placeholder = '',
        $label = '',
        $accept = null,
        $attrs = [],
        $class = '',
        $id = ''
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->accept = $accept;
        $this->class = $class;
        $this->id = $id;
        $this->attrs = $attrs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.base-input');
    }
}
