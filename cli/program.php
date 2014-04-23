<?php

namespace TreeCrawler;

require_once sprintf(
    '%s/../vendor/autoload.php',
    __DIR__
);

echo new Hookup(), PHP_EOL;