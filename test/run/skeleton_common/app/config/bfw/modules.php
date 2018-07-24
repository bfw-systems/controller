<?php

$config = require(__DIR__.'/modules.php.original');

$config['modules']['controller']['name']    = 'bfw-controller';
$config['modules']['controller']['enabled'] = true;

return $config;
