<?php

namespace Lareon\CMS\App\Http\Controllers\Web\Admin\Appearance;

use Lareon\CMS\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IconsController extends Controller
{
    public function index()
    {
        return view('lareon::admin.pages.icons.index');
    }
}
