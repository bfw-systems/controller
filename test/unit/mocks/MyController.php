<?php

namespace BfwController\test\unit\mocks;

class MyController extends \BfwController\Controller
{
    public function getRequest()
    {
        return $this->request;
    }
    
    public function index()
    {
        echo 'coucou index';
    }
}