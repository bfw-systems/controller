<?php

namespace BfwController\test\unit;

use \atoum;
use \BFW\test\helpers\ApplicationInit as AppInit;

require_once(__DIR__.'/../../../vendor/autoload.php');

//Mock \BFW\Application
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/helpers/ApplicationInit.php');

class Controller extends atoum
{
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    public function testConstruct()
    {
        AppInit::init([
            'vendorDir' => __DIR__.'/../../../vendor'
        ]);
        
        $this->assert('test Controller::constructor')
            ->if($this->class = new \BfwController\test\unit\mocks\MyController)
            ->then
            ->object($this->class->getRequest())
                ->isIdenticalTo(\BFW\Request::getInstance())
            ->object($this->class->getApp())
                ->isInstanceOf('\BFW\Application');
    }
}
