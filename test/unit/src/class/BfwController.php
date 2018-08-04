<?php

namespace BfwController\test\unit;

use \atoum;

$vendorPath = realpath(__DIR__.'/../../../../vendor');
require_once($vendorPath.'/autoload.php');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/helpers/Application.php');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/mocks/src/class/Module.php');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/mocks/src/class/Subject.php');

class BfwController extends Atoum
{
    use \BFW\Test\Helpers\Application;
    use \BfwController\Test\Helpers\Module;
    
    protected $mock;
    
    public function beforeTestMethod($testMethod)
    {
        //Define PHP_SAPI on namespace BFW (mock) to have the methode
        //BFW\Application::initCtrlRouterLink executed
        eval('namespace BFW {const PHP_SAPI = \'www\';}');
        
        $this->setRootDir(__DIR__.'/../../../..');
        $this->createApp();
        $this->disableSomeCoreSystem();
        $this->initApp();
        $this->removeLoadModules();
        $this->createModule();
        $this->app->run();
        
        if ($testMethod === 'testConstructAndGetters') {
            return;
        }
        
        $this->mockGenerator
            ->makeVisible('obtainCtrlRouterInfos')
            ->makeVisible('run')
            ->makeVisible('runObject')
            ->makeVisible('runProcedural')
            ->generate('BfwController\BfwController')
        ;
        $this->mock = new \mock\BfwController\BfwController($this->module);
    }
    
    public function testConstructAndGetters()
    {
        $this->assert('test BfwController::__construct')
            ->object($bfwCtrl = new \BfwController\BfwController($this->module))
                ->isInstanceOf('\SplObserver')
        ;
        
        $this->assert('test BfwController::getters')
            ->object($bfwCtrl->getModule())
                ->isIdenticalTo($this->module)
            ->object($bfwCtrl->getConfig())
                ->isIdenticalto($this->module->getConfig())
            ->string($bfwCtrl->getExecRouteSystemName())
                ->isEqualTo('bfw-controller')
        ;
    }
    
    public function testUpdate()
    {
        $this->assert('test BfwController::update - prepare')
            ->given($subject = new \BFW\Test\Mock\Subject)
        ;
        
        $this->assert('test BfwController::update for run system')
            ->given($ctrlRouterInfos = $this->app->getCtrlRouterLink())
            ->if($ctrlRouterInfos->isFound = true)
            ->and($ctrlRouterInfos->forWho = $this->mock->getExecRouteSystemName())
            ->then
            ->given($subject = new \BFW\Test\Mock\Subject)
            ->and($subject->setAction('ctrlRouterLink_exec_execRoute'))
            ->and($subject->setContext($ctrlRouterInfos))
            ->then
            ->if($this->calling($this->mock)->run = null)
            ->then
            ->variable($this->mock->update($subject))
                ->isNull()
            ->object($this->mock->getCtrlRouterInfos())
                ->isIdenticalTo($this->app->getCtrlRouterLink())
            ->mock($this->mock)
                ->call('run')
                    ->once()
        ;
    }
    
    public function testRunFromCli()
    {
        $this->assert('test BfwController::run - prepare')
            ->if($this->calling($this->mock)->runObject = null)
            ->and($this->calling($this->mock)->runProcedural = null)
        ;
        
        $this->assert('test BfwController::run called from cli')
            ->if($this->constant->PHP_SAPI = 'cli')
            ->then
            ->variable($this->mock->run())
                ->isNull()
            ->mock($this->mock)
                ->call('runObject')
                    ->never()
                ->call('runProcedural')
                    ->never()
        ;
    }
    
    public function testRun()
    {
        $this->assert('test BfwController::run - prepare')
            ->if($this->constant->PHP_SAPI = 'www')
            ->then
            ->given($ctrlRouterInfos = $this->app->getCtrlRouterLink())
            ->if($ctrlRouterInfos->isFound = true)
            ->and($ctrlRouterInfos->forWho = $this->mock->getExecRouteSystemName())
            ->then
            ->given($subject = new \BFW\Test\Mock\Subject)
            ->and($subject->setAction('execRoute'))
            ->and($subject->setContext($ctrlRouterInfos))
            ->and($this->mock->obtainCtrlRouterInfos($subject))
            ->then
            ->if($this->calling($this->mock)->runObject = null)
            ->and($this->calling($this->mock)->runProcedural = null)
        ;
        
        $this->assert('test BfwController::run without target')
            ->if($ctrlRouterInfos->target = null)
            ->then
            ->variable($this->mock->run())
                ->isNull()
            ->mock($this->mock)
                ->call('runObject')
                    ->never()
                ->call('runProcedural')
                    ->never()
        ;
        
        $this->assert('test BfwController::run with object')
            ->if($ctrlRouterInfos->target = 'MyController')
            ->and($this->module->getConfig()->setConfigKeyForFilename('config.php', 'useClass', true))
            ->then
            ->variable($this->mock->run())
                ->isNull()
            ->mock($this->mock)
                ->call('runObject')
                    ->once()
                ->call('runProcedural')
                    ->never()
        ;
        
        $this->assert('test BfwController::run with procedural')
            ->if($ctrlRouterInfos->target = 'MyController')
            ->and($this->module->getConfig()->setConfigKeyForFilename('config.php', 'useClass', false))
            ->then
            ->variable($this->mock->run())
                ->isNull()
            ->mock($this->mock)
                ->call('runObject')
                    ->never()
                ->call('runProcedural')
                    ->once()
        ;
    }
    
    public function testRunObject()
    {
        $this->assert('test BfwController::runObject - prepare')
            ->given($ctrlRouterInfos = $this->app->getCtrlRouterLink())
            ->if($ctrlRouterInfos->isFound = true)
            ->and($ctrlRouterInfos->forWho = $this->mock->getExecRouteSystemName())
            ->and($ctrlRouterInfos->target = null)
            ->then
            ->given($subject = new \BFW\Test\Mock\Subject)
            ->and($subject->setAction('execRoute'))
            ->and($subject->setContext($ctrlRouterInfos))
            ->and($this->mock->obtainCtrlRouterInfos($subject))
        ;
        
        $this->assert('test BfwController::runObject for missing all property exception')
            ->if($ctrlRouterInfos->target = (object) [])
            ->then
            ->exception(function() {
                $this->mock->runObject();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED)
        ;
        
        $this->assert('test BfwController::runObject for missing method property exception')
            ->if($ctrlRouterInfos->target = (object) [
                'class' => '\BfwController\Test\Helpers\ObjectController'
            ])
            ->then
            ->exception(function() {
                $this->mock->runObject();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED)
        ;
        
        $this->assert('test BfwController::runObject for missing class property exception')
            ->if($ctrlRouterInfos->target = (object) [
                'method' => 'index'
            ])
            ->then
            ->exception(function() {
                $this->mock->runObject();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED)
        ;
        
        $this->assert('test BfwController::runObject for class not exist exception')
            ->if($ctrlRouterInfos->target = (object) [
                'class'  => '\BfwController\Test\Helpers\NotExistingClass',
                'method' => 'index'
            ])
            ->then
            ->exception(function() {
                $this->mock->runObject();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_OBJECT_CLASS_NOT_FOUND)
        ;
        
        $this->assert('test BfwController::runObject for method not exist exception')
            ->if($ctrlRouterInfos->target = (object) [
                'class'  => '\BfwController\Test\Helpers\ObjectController',
                'method' => 'notExist'
            ])
            ->then
            ->exception(function() {
                $this->mock->runObject();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_OBJECT_METHOD_NOT_FOUND)
        ;
        
        $this->assert('test BfwController::runObject call controller')
            ->if($ctrlRouterInfos->target = (object) [
                'class'  => '\BfwController\Test\Helpers\ObjectController',
                'method' => 'index'
            ])
            ->then
            ->output(function() {
                $this->mock->runObject();
            })
                ->isEqualTo('coucou index')
        ;
    }
    
    public function testRunProcedural()
    {
        $this->assert('test BfwController::runProcedural - prepare')
            ->given($ctrlRouterInfos = $this->app->getCtrlRouterLink())
            ->if($ctrlRouterInfos->isFound = true)
            ->and($ctrlRouterInfos->forWho = $this->mock->getExecRouteSystemName())
            ->and($ctrlRouterInfos->target = null)
            ->then
            ->given($subject = new \BFW\Test\Mock\Subject)
            ->and($subject->setAction('execRoute'))
            ->and($subject->setContext($ctrlRouterInfos))
            ->and($this->mock->obtainCtrlRouterInfos($subject))
            ->then
            ->given($this->constant->CTRL_DIR = __DIR__.'/../../helpers/')
        ;
        
        $this->assert('test BfwController::runProcedural with not existing file')
            ->if($ctrlRouterInfos->target = 'fileNotExist.php')
            ->then
            ->exception(function() {
                $this->mock->runProcedural();
            })
                ->hasCode(\BfwController\BfwController::ERR_RUN_PROCEDURAL_FILE_NOT_FOUND)
        ;
        
        $this->assert('test BfwController::runProcedural with existing file')
            ->if($ctrlRouterInfos->target = 'ProceduralController.php')
            ->then
            ->output(function() {
                $this->mock->runProcedural();
            })
                ->isEqualTo('coucou index')
        ;
    }
}