<?php

$this->monolog = new \BFW\Monolog(
    'bfw-controller',
    \BFW\Application::getInstance()->getConfig()
);
$this->monolog->addAllHandlers();

$bfwController = new \BfwController\BfwController($this);

$app        = \BFW\Application::getInstance();
$appSubject = $app->getSubjectList()->getSubjectByName('ctrlRouterLink');
$appSubject->attach($bfwController);
