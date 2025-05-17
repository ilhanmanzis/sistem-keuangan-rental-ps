<?php

namespace App\View\Components;

use Closure;
use App\Models\Profile;
use App\Models\Shifts;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Navbar extends Component
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
            'profile' => Profile::first(),
            'shifts' => Shifts::all()
        ];
        return view('components.navbar', $data);
    }
}
