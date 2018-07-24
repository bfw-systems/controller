<?php

$observer = new \Modules\testInstall\Observer($this);

$app        = \BFW\Application::getInstance();
$appSubject = $app->getSubjectList()->getSubjectForName('ApplicationTasks');
$appSubject->attach($observer);
