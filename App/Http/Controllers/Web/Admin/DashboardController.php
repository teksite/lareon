<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin;

use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        return view('lareon::admin.pages.dashboard');
    }
}
