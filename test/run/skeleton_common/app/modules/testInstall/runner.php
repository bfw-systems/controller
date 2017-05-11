<?php

$config = $this->getConfig();
$linker = \BFW\ControllerRouterLink::getInstance();
$linker->setTarget($config->getValue('target'));
