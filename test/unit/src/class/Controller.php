<?php

namespace BfwController\test\unit;

use \atoum;

$vendorPath = realpath(__DIR__.'/../../../../vendor');
require_once($vendorPath.'/autoload.php');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/helpers/Application.php');

class Controller extends Atoum
{
    use \BFW\Test\Helpers\Application;
    
    protected $mock;
    
    public function beforeTestMethod($testMethod)
    {
        $this->setRootDir(__DIR__.'/../../../..');
        $this->createApp();
        $this->initApp();
    }
    
    public function testConstructAndGetters()
    {
        $this->assert('test Controller::__construct')
            ->object($bfwCtrl = new \BfwController\Test\Helpers\ObjectController)
                ->isInstanceOf('\BfwController\Controller')
        ;
        
        $this->assert('test Controller::getters')
            ->object($bfwCtrl->getApp())
                ->isIdenticalTo(\BFW\Application::getInstance())
            ->object($bfwCtrl->getRequest())
                ->isIdenticalto(\BFW\Request::getInstance())
        ;
    }
}