<?php

$observer = new \Modules\forceRoute\Observer($this);

$app        = \BFW\Application::getInstance();
$appSubject = $app->getSubjectList()->getSubjectForName('ApplicationTasks');
$appSubject->attach($observer);
