<?php

$bfwController = \BfwController\BfwController::getInstance($module);

$app = \BFW\Application::getInstance();
$app->attach($bfwController);
