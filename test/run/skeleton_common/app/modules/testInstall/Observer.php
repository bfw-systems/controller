<?php

namespace Modules\testInstall;

class Observer implements \SplObserver
{
    protected $module;
    
    public function __construct($module)
    {
        $this->module = $module;
    }
    
    public function update(\SplSubject $subject)
    {
        if ($subject->getAction() === 'bfw_ctrlRouterLink_subject_added') {
            $app = \BFW\Application::getInstance();
            $app->getSubjectList()
                ->getSubjectForName('ctrlRouterLink')
                ->attach($this)
            ;
        } elseif ($subject->getAction() === 'ctrlRouterLink_exec_searchRoute') {
            $this->addTarget($subject);
        }
    }
    
    protected function addTarget($subject)
    {
        $moduleConfig    = $this->module->getConfig();
        $ctrlRouterInfos = $subject->getContext();
        
        $ctrlRouterInfos->isFound = true;
        $ctrlRouterInfos->forWho  = 'bfw-controller';
        $ctrlRouterInfos->target  = $moduleConfig->getValue('target');
    }
}
