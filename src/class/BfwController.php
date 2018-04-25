<?php

namespace BfwController;

use Exception;

/**
 * Controller system class
 */
class BfwController implements \SplObserver
{
    /**
     * @const ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED Error code if the class
     * and the method is not declared for the current route, in object mode.
     */
    const ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED = 2001001;
    
    /**
     * @const ERR_RUN_OBJECT_CLASS_NOT_FOUND Error code if the class declared
     * for the route is not found. In object mode only.
     */
    const ERR_RUN_OBJECT_CLASS_NOT_FOUND = 2001002;
    
    /**
     * @const ERR_RUN_OBJECT_METHOD_NOT_FOUND Error code if the method declared
     * for the route is not found. In object mode only.
     */
    const ERR_RUN_OBJECT_METHOD_NOT_FOUND = 2001003;
    
    /**
     * @const ERR_RUN_PROCEDURAL_FILE_NOT_FOUND Error code if the file to use
     * for the route is not found. In procedural mode only.
     */
    const ERR_RUN_PROCEDURAL_FILE_NOT_FOUND = 2001004;
    
    /**
     * @var \BFW\Module $module The bfw module instance for this module
     */
    protected $module;
    
    /**
     * @var \BFW\Config $config The bfw config instance for this module
     */
    protected $config;
    
    /**
     * @var \stdClass|null $ctrlRouterInfos The context object passed to
     * subject for the action "searchRoute".
     */
    protected $ctrlRouterInfos;
    
    /**
     * @var string $execRouteSystemName The name of the current system. Used on
     * event "execRoute". Allow to extends this class in another module :)
     */
    protected $execRouteSystemName = 'bfw-controller';
    
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
    }
    
    /**
     * Observer update method
     * 
     * @param \SplSubject $subject
     * 
     * @return void
     */
    public function update(\SplSubject $subject)
    {
        if ($subject->getAction() === 'bfw_ctrlRouterLink_subject_added') {
            $app = \BFW\Application::getInstance();
            $app->getSubjectList()
                ->getSubjectForName('ctrlRouterLink')
                ->attach($this)
            ;
        } elseif ($subject->getAction() === 'execRoute') {
            $this->obtainCtrlRouterInfos($subject);
            
            if (
                $this->ctrlRouterInfos->isFound === true &&
                $this->ctrlRouterInfos->forWho === $this->execRouteSystemName
            ) {
                $this->run();
            }
        }
    }
    
    /**
     * Set the property ctrlRouterInfos with the context object obtain linked
     * to the subject.
     * Allow override to get only some part. And used for unit test.
     * 
     * @param \BFW\Subject $subject
     * 
     * @return void
     */
    protected function obtainCtrlRouterInfos($subject)
    {
        $this->ctrlRouterInfos = $subject->getContext();
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
        
        if ($this->ctrlRouterInfos->target === null) {
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
        $targetInfos = (object) $this->ctrlRouterInfos->target;
        
        if (
            !property_exists($targetInfos, 'class') ||
            !property_exists($targetInfos, 'method')
        ) {
            throw new Exception(
                'You must define properties "class" and "method" for'
                .' the current route in the router configuration.',
                self::ERR_RUN_OBJECT_CLASS_AND_METHOD_UNDEFINED
            );
        }
        
        $class  = $targetInfos->class;
        $method = $targetInfos->method;
        
        if (!class_exists($class)) {
            throw new Exception(
                'Class '.$class.' not found',
                self::ERR_RUN_OBJECT_CLASS_NOT_FOUND
            );
        }
        
        $classInstance = new $class;
        if (!method_exists($classInstance, $method)) {
            throw new Exception(
                'Method '.$method.' not found in class '.$class,
                self::ERR_RUN_OBJECT_METHOD_NOT_FOUND
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
        $routerLinker = $this->ctrlRouterInfos;
        
        $runFct = function() use ($routerLinker) {
            $controllerFile = (string) $routerLinker->target;
            
            if (!file_exists(CTRL_DIR.$controllerFile)) {
                throw new Exception(
                    'Controller file '.$controllerFile.' not found.',
                    self::ERR_RUN_PROCEDURAL_FILE_NOT_FOUND
                );
            }
            
            include(CTRL_DIR.$controllerFile);
        };
        
        $runFct();
    }
}
