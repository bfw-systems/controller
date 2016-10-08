<?php

$bfwController = new \BfwController\BfwController($module);

$app = \BFW\Application::getInstance();
$app->attach($bfwController);
