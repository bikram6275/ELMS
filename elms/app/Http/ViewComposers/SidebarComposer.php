<?php

namespace App\Http\ViewComposers;

use App\Models\Roles\Menu;
use Illuminate\Contracts\View\View;

class SidebarComposer
{

    public function compose(View $view)
    {
        $view->with('sidebar_menus', Menu::getAllowdedMenu());
    }
}
