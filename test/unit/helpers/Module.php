<?php

namespace BfwController\Test\Helpers;

trait Module
{
    protected $module;
    
    protected function createModule()
    {
        $config     = new \BFW\Config('bfw-controller');
        $moduleList = $this->app->getModuleList();
        $moduleList->setModuleConfig('bfw-controller', $config);
        $moduleList->addModule('bfw-controller');
        
        $this->module = $this->app->getModuleForName('bfw-controller');
        
        $this->module->monolog = new \BFW\Monolog(
            'bfw-controller',
            \BFW\Application::getInstance()->getConfig()
        );
        $this->module->monolog->addAllHandlers();
        
        $config->setConfigForFile(
            'config.php',
            (object) [
                'useClass' => false
            ]
        );
    }
}
