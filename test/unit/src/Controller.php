<?php

namespace BfwController\test\unit;
use \atoum;

require_once(__DIR__.'/../../../vendor/autoload.php');

//Mock \BFW\Application
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/ApplicationForceConfig.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/Application.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/ConfigForceDatas.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/Modules.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/helpers/Application.php');

class Controller extends atoum
{
    use \BFW\test\helpers\Application;
    
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    public function testConstruct()
    {
        $this->initApp('');
        
        $this->assert('test Controller::constructor')
            ->if($this->class = new \BfwController\test\unit\mocks\MyController)
            ->then
            ->object($this->class->getRequest())
                ->isIdenticalTo(\BFW\Request::getInstance())
            ->object($this->class->getApp())
                ->isInstanceOf('\BFW\Application');
    }
}
