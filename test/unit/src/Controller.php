<?php

namespace BfwController\test\unit;
use \atoum;

require_once(__DIR__.'/../../../vendor/autoload.php');

class Controller extends atoum
{
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    public function testConstruct()
    {
        $this->assert('test Controller::constructor')
            ->if($this->class = new \BfwController\test\unit\mocks\MyController)
            ->then
            ->object($this->class->getRequest())
                ->isIdenticalTo(\BFW\Request::getInstance());
    }
}
