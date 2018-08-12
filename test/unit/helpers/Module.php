<?php

namespace BfwController\Test\Helpers;

$vendorPath = realpath(__DIR__.'/../../../vendor');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/helpers/Application.php');
require_once($vendorPath.'/bulton-fr/bfw/test/unit/mocks/src/Module.php');

trait Module
{
    protected $module;
    
    protected function disableSomeCoreSystem()
    {
        $coreSystemList = $this->app->getCoreSystemList();
        unset($coreSystemList['cli']);
        $this->app->setCoreSystemList($coreSystemList);
    }
    
    protected function removeLoadModules()
    {
        $runTasks = $this->app->getRunTasks();
        $allSteps = $runTasks->getRunSteps();
        unset($allSteps['moduleList']);
        $runTasks->setRunSteps($allSteps);
    }
    
    protected function createModule()
    {
        $config     = new \BFW\Config('bfw-controller');
        $moduleList = $this->app->getModuleList();
        $moduleList->setModuleConfig('bfw-controller', $config);
        $moduleList->addModule('bfw-controller');
        
        $this->module = $moduleList->getModuleByName('bfw-controller');
        
        $this->module->monolog = new \BFW\Monolog(
            'bfw-controller',
            \BFW\Application::getInstance()->getConfig()
        );
        $this->module->monolog->addAllHandlers();
        
        $config->setConfigForFilename(
            'config.php',
            [
                'useClass' => false
            ]
        );
    }
}
