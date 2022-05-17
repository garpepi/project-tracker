<?php

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes, $output = "active")
{
    foreach ($routes as $route)
    {
        if (request()->is(''.$route.'*')) return $output;
    }

}

/*
|--------------------------------------------------------------------------
| Detect Collapse Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is collapse.
|
*/
function areCollapseRoutes(Array $routes, $output = "", $default = "collapsed")
{
    foreach ($routes as $route)
    {
        if (request()->is(''.$route.'*')) return $output;
    }

    return $default;

}
