<?php

namespace BfwController;

/**
 * Controller system class
 */
class BfwController implements \SplObserver
{
    /**
     * @var \BFW\Module $module The bfw module instance for this module
     */
    protected $module;
    
    /**
     * @var \BFW\Config $config The bfw config instance for this module
     */
    protected $config;
    
    /**
     * @var \BFW\ControllerRouterLink $routerLinker Linker between
     *  controller and router instance
     */
    protected $routerLinker;
    
    /**
     * Constructor
     * Get config and linker instance
     * 
     * @param \BFW\Module $module
     */
    public function __construct(\BFW\Module $module)
    {
        $this->module = $module;
        $this->config = $module->getConfig();
        
        $this->routerLinker = \BFW\ControllerRouterLink::getInstance();
    }
    
    /**
     * Observer update method
     * Call run method on action "bfw_run_finish".
     * 
     * @param \SplSubject $subject
     * 
     * @return void
     */
    public function update(\SplSubject $subject)
    {
        if ($subject->getAction() === 'bfw_run_finish') {
            $this->run();
            
            $app = \BFW\Application::getInstance();
            $app->notifyAction('BfwController_run_finish');
        }
    }
    
    /**
     * Run controller system if application is not run in cli mode
     * 
     * @return void
     */
    protected function run()
    {
        if (PHP_SAPI === 'cli') {
            return;
        }
        
        if ($this->routerLinker->getTarget() === null) {
            return;
        }
        
        $useClass = $this->config->getValue('useClass');
        
        if ($useClass === true) {
            $this->runObject();
        } else {
            $this->runProcedural();
        }
    }
    
    /**
     * Call controller when is an object.
     * 
     * @return void
     */
    protected function runObject()
    {
        $targetInfos = (object) $this->routerLinker->getTarget();
        
        if (
            !property_exists($targetInfos, 'class') ||
            !property_exists($targetInfos, 'method')
        ) {
            throw new \Exception(
                'You must define properties "class" and "method" for'
                .' the current route in the router configuration.'
            );
        }
        
        $class  = $targetInfos->class;
        $method = $targetInfos->method;
        
        if (!class_exists($class)) {
            throw new \Exception('Class '.$class.' not found');
        }
        
        $classInstance = new $class;
        if (!method_exists($classInstance, $method)) {
            throw new \Exception(
                'Method '.$method.' not found in class '.$class
            );
        }
        
        $classInstance->{$method}();
    }
    
    /**
     * Call controler when is a procedural file
     * 
     * @return void
     */
    protected function runProcedural()
    {
        $routerLinker = $this->routerLinker;
        
        $runFct = function() use ($routerLinker) {
            $controllerFile = (string) $routerLinker->getTarget();
            
            if (!file_exists(CTRL_DIR.$controllerFile)) {
                throw new \Exception(
                    'Controller file '.$controllerFile.' not found.'
                );
            }
            
            include(CTRL_DIR.$controllerFile);
        };
        
        $runFct();
    }
}
