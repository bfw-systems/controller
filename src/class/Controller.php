<?php

namespace BfwController;

/**
 * Class to extends for controller object format
 * Extends is optional.
 */
abstract class Controller
{
    /**
     * @var \BFW\Request $request : Request instance to get informations
     *      on the http request
     */
    protected $request;
    
    /**
     * Constructor
     * Get \BFW\Request instance.
     */
    public function __construct()
    {
        $this->request = \BFW\Request::getInstance();
    }
}
