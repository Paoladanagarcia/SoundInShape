<?php

foreach (explode("\n", file_get_contents('.env')) as $line) {
    list($key, $value) = explode('=', $line, 2);
    $trimmed_value = trim($value);
    // $_ENV[$key] = $trimmed_value;
    putenv("$key=$trimmed_value");
}
