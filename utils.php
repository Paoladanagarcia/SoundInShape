<?php

#echo __FILE__ . '<br>';


$CSS_stylesheets = [
    'global-styles.css',
    'header.css',
    'footer.css',
];

function addCSS($css_filename)
{
    global $CSS_stylesheets;
    array_push($CSS_stylesheets, $css_filename);
}

function addCSSTags()
{
    global $CSS_stylesheets;
    foreach ($CSS_stylesheets as $css) {
        echo '<link rel="stylesheet" href="' . url("/view/css/{$css}") . '">' . "\n";
    }
}

function dd($var)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

function url($path)
{
    return getenv('DOMAIN_NAME') . $path;
}

function require_view($view_name)
{
    // If requesting a "view/..." with a ".php" at the end, echo 'english' or 'french' depending on the cookie
    if (str_starts_with($view_name, 'view/') && str_ends_with($view_name, '.php')) {
        if (isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en') {
            // Strip the "view/" part
            $view_name = substr($view_name, 5);
            $new_view_name = 'view/en-view/' . $view_name;
            // echo $new_view_name;
            require_once $new_view_name;
        } else {
            // echo $view_name;
            require_once $view_name;
        }
    } else {
        // echo "cannot request view: $view_name";
    }
}

function JSONResponse($status, $message, $redirect_to = '')
{
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'redirect_to' => $redirect_to
    ]);

    if ($status == 'error') {
        return false;
    }

    return true;
}

function JSONResponseFromArray($array)
{
    header('Content-Type: application/json');
    echo json_encode($array);
}

function write_error_log($message)
{
    file_put_contents(
        'C:/wamp64/www/SoundInShape/myerrors.txt',
        json_encode($message, JSON_PRETTY_PRINT) . "\n",
        FILE_APPEND
    );
}
