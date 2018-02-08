<?php

if(getenv('ENV') === 'wercker'){
    putenv('APP_URL=http://localhost:8000');
} else {
    putenv('APP_URL=http://localhost');
}

require __DIR__.'/../vendor/autoload.php';
