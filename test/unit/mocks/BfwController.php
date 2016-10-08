<?php

namespace BfwController\test\unit\mocks;

class BfwController extends \BfwController\BfwController
{
    public function getModule()
    {
        return $this->module;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function getRouterLinker()
    {
        return $this->routerLinker;
    }
}
