<?php
$page_title = '';
$Ctr = new \BFWCtr\Controler();
$Ctr->setDefaultPage($DefaultControler);

//La page
if(file_exists('cache/'.$Ctr->getFileArbo().'.phtml') && $tpl_module == 'BFW_Template')
{
    //Cache de BFW_Template
    require_once('cache/'.$Ctr->getFileArbo().'.phtml');
}
elseif(file_exists('controlers/'.$Ctr->getFileArbo().'.php') && !$ctr_class)
{
    require_once('controlers/'.$Ctr->getFileArbo().'.php');
}
elseif($ctr_class)
{
    if(method_exists('\controler\\'.$Ctr->getNameCtr(), $Ctr->getMethode()) && $ctr_class)
    {
        $ctrName = '\controler\\'.$Ctr->getNameCtr();
        $methodeName = $Ctr->getMethode();
        
        call_user_func(array($ctrName, $methodeName));
    }
    elseif(method_exists('\controler\index', $Ctr->getMethode()) && $ctr_class)
    {
        call_user_func(array('\controler\index', $Ctr->getMethode()));
    }
    else
    {
        ErrorView(404);
    }
}
else
{
    ErrorView(404);
}
?>