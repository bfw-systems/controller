<?php

$observer = new \Modules\forceRoute\Observer($this);

$app        = \BFW\Application::getInstance();
$appSubject = $app->getSubjectList()->getSubjectByName('ctrlRouterLink');
$appSubject->attach($observer);
