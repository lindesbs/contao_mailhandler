<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

abstract class ActorAbstractClass
{
	abstract public function fetchAllItems();
	abstract public function getItem($strMessageID);
    
    protected $arrConfig = array();
    
    public function getConfigDCA()
    {
        
    
    }
    
    
    public function setConfig($arrConfig)
    {
        $this->arrConfig = deserialize($arrConfig);
        
    }
}