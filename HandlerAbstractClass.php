<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');



abstract class HandlerAbstractClass extends System
{
    public function __construct()
    {   
    }
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        // $objItem : actual item in actions row
        // $objItemData : source Mail info object
        // $objActor : Infos about the ActorConfiguration 
    
    }

}
