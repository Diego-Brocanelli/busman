<?php

namespace Busman\Utils\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;

class RouteListController extends Controller
{
    protected $router;

    function __construct(Router $router)
    {
        if (! App::environment('local'))
            return abort(404);

        $this->router = $router;
    }

    public function index()
    {
        return view('utils::routes')->with('routes', $this->router->getRoutes());
    }
}
