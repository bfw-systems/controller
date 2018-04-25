<?php

namespace BfwController\Test\Helpers;

class ObjectController extends \BfwController\Controller
{
    public function getApp()
    {
        return $this->app;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function index()
    {
        echo 'coucou index';
    }
}
