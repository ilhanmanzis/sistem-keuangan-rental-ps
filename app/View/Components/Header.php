<?php

namespace App\View\Components;

use Closure;
use App\Models\Profile;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = [
            'profile' => Profile::first()
        ];
        return view('components.header', $data);
    }
}
