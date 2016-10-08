<?php

namespace BfwController\test\unit;

use \atoum;

require_once(__DIR__.'/../../../vendor/autoload.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/ConfigForceDatas.php');
require_once(__DIR__.'/../../../vendor/bulton-fr/bfw/test/unit/mocks/src/class/Module.php');

class BfwController extends atoum
{
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    protected $module;
    
    /**
     * Instanciation de la class avant chaque méthode de test
     */
    public function beforeTestMethod($testMethod)
    {
        define('CTRL_DIR', 'controllers/');
        define('CONFIG_DIR', 'config/');
        define('MODULES_DIR', 'modules/');
        
        $config = new \BFW\test\unit\mocks\ConfigForceDatas('unit_test');
        $config->forceConfig(
            'config',
            (object) [
                'useClass' => false
            ]
        );
        
        $this->module = new \BFW\test\unit\mocks\Module('unit_test', false);
        $this->module->forceConfig($config);
        
        if ($testMethod === 'testConstruct') {
            return;
        }
        
        $this->class = new \BfwController\test\unit\mocks\BfwController($this->module);
    }
    
    public function testConstruct()
    {
        $this->assert('test BfwController::__construct')
            ->if($this->class = new \BfwController\test\unit\mocks\BfwController($this->module))
            ->then
            ->object($this->class->getModule())
                ->isIdenticalTo($this->module)
            ->object($this->class->getConfig())
            ->object($this->class->getRouterLinker())
                ->isIdenticalTo(\BFW\ControllerRouterLink::getInstance());
    }
    
    public function testNotifyAndRunProcedural()
    {
        $this->assert('test BfwController::notify without run')
            ->if($subject = new \BFW\Subjects)
            ->and($this->class->getRouterLinker()->setTarget('unit_test.php'))
            ->and($this->constant->PHP_SAPI = 'apache')
            ->then
            ->variable($this->class->update($subject))
                ->isNull();
        
        $this->assert('test BfwController::notify with run in procedural mode with file not found exception')
            ->then
            ->given($class = $this->class)
            ->and($subject->setAction('bfw_run_finish'))
            ->exception(function() use ($class, $subject) {
                $class->update($subject);
            })
                ->hasMessage('Controller file unit_test.php not found.');
    }
    
    public function testNotifyAndRunObject()
    {
        $this->assert('test BfwController::notify without run')
            ->if($subject = new \BFW\Subjects)
            ->and($this->class->getConfig()->forceConfig(
                'config',
                (object) [
                    'useClass' => true
                ]
            ))
            ->and($this->class->getRouterLinker()->setTarget([
                'class'  => 'testClass',
                'method' => 'testMethod'
            ]))
            ->and($this->constant->PHP_SAPI = 'apache')
            ->then
            ->variable($this->class->update($subject))
                ->isNull();
        
        $this->assert('test BfwController::notify with run in object mode with exception on class')
            ->then
            ->given($class = $this->class)
            ->and($subject->setAction('bfw_run_finish'))
            ->exception(function() use ($class, $subject) {
                $class->update($subject);
            })
                ->hasMessage('Class testClass not found');
        
        $this->assert('test BfwController::notify with run in object mode with exception on method')
            ->and($this->class->getRouterLinker()->setTarget([
                'class'  => '\BFW\Subjects',
                'method' => 'testMethod'
            ]))
            ->exception(function() use ($class, $subject) {
                $class->update($subject);
            })
                ->hasMessage('Method testMethod not found in class \BFW\Subjects');
    }
}
