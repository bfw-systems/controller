<?php

$bfwController = new \BfwController\BfwController($this);

$app        = \BFW\Application::getInstance();
$appSubject = $app->getSubjectList()->getSubjectForName('ApplicationTasks');
$appSubject->attach($bfwController);
