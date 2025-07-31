<?php
function handle_request($routes) {
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_method = $_SERVER['REQUEST_METHOD'];
    $uri = strtok($request_uri, '?');
    if (array_key_exists($uri, $routes) && array_key_exists($request_method, $routes[$uri])) {
        $callback = $routes[$uri][$request_method];
        call_user_func($callback);
    } else {
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
    }
} 