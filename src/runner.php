<?php

$bfwController = new \BfwController\BfwController($this);

$app = \BFW\Application::getInstance();
$app->attach($bfwController);
