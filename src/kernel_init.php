<?php
/**
 * Actions à effectuer lors de l'initialisation du module par le framework.
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @package bfw-controller
 * @version 1.0
 */

require_once($rootPath.'configs/bfw-controller/config.php');

$ctr = new \BFWCtr\Controller($bfwCtrConfig);

//La page
if(
    file_exists($rootPath.'controllers/'.$ctr->getFileArbo())
    && !$bfwCtrConfig->useClass
)
{
    require_once($rootPath.'controllers/'.$ctr->getFileArbo());
}
elseif($bfwCtrConfig->useClass)
{
    if(
        method_exists('\controller\\'.$ctr->getNameCtr(), $ctr->getMethode())
        && $bfwCtrConfig->useClass
    )
    {
        $ctrName = '\controller\\'.$ctr->getNameCtr();
        $methodeName = $ctr->getMethode();
        
        call_user_func(array($ctrName, $methodeName));
    }
    elseif(
        method_exists('\controller\index', $ctr->getMethode())
        && $bfwCtrConfig->useClass
    )
    {
        call_user_func(array('\controller\index', $ctr->getMethode()));
    }
    else
    {
        ErrorView(404);
    }
}
else
{
    ErrorView(404, false);
}
