<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class HandlerLogging extends HandlerAbstractClass
{
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        
        /*
         * print_a($objItem);
        
        print_a($objItemData);
        print_a($objActor);
        */
        $this->log(sprintf("%s - %s - %s",$objItemData->Subject,$objItem['title'],$objActor['provider']),"HandlerLogging::runItem","MAILHANDLER");
    
    }

}
