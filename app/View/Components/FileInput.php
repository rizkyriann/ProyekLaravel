<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileInput extends Component
{
    public string $label;
    public string $name;

    public function __construct(string $label = 'Upload File', string $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    public function render()
    {
        return view('components.file-input');
    }
}
