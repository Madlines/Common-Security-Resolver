<?php

if (!file_exists('vendor/autoload.php')) {
    echo 'Make sure to run `composer install` before running and tests';
    exit(1);
}

require_once 'vendor/autoload.php';