<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class ItemObject
{
    public $messageID;
    
    public function __construct($messageID)
    {
        $this->messageID = $messageID;
    }    

}
