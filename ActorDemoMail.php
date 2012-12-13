<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

class ActorDemoMail extends ActorAbstractClass
{
    public function getItem($strMessageID)
    {
        $objItem = new ItemObject($strMessageID);
        
           $objItem->From=($this->arrConfig['ownFromField']) ? $this->arrConfig['ownFromField'] : "admin-from@musicacademy.com";
           $objItem->To = ($this->arrConfig['ownToField']) ? $this->arrConfig['ownToField'] : "admin-to@musicacademy.com";
           $objItem->Subject = ($this->arrConfig['ownSubjectField']) ? $this->arrConfig['ownSubjectField'] : "Hello Welt ".$strMessageID;
           $objItem->Body = ($this->arrConfig['ownBodyField']) ? $this->arrConfig['ownBodyField'] : "Hello Welt ".$strMessageID;
           $objItem->Attachments = ($this->arrConfig['ownAttachementField']) ? $this->arrConfig['ownAttachementField'] : "";
           $objItem->Header['useragent'] = "Thunderbird Stuff";
        
        return $objItem;
    }
    
    
    public function fetchAllItems()
    {      
           
        return array("demoID1","demoID2","demoID3","demoID4","demoID5");
    }
    
    
    
    
    public function getDCA()
    {
        return array(
            'palettes' => 'ownToField,ownFromField,ownUserAgentField,ownSubjectField,ownBodyField,ownAttachementField',
            'fields' => array(
                'ownToField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownToField'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255)
                    ),
                'ownFromField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownFromField'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255)
                    ),
                'ownUserAgentField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownUserAgentField'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255)
                    ),
                'ownSubjectField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownSubjectField'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255)
                    ),
                'ownBodyField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownBodyField'],
                        'exclude'                 => false,
                        'inputType'               => 'textarea',
                        'eval'                    => array('rte'=>'tinyMCE')
                    ),
                'ownAttachementField' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['ownAttachementField'],
                        'exclude'                 => false,
                        'inputType'               => 'fileTree',
                        'eval'                    => array('multiple'=>true,'fieldType'=>'checkbox', 'files'=>true)
                    ),
            ),
            
        );    
    
    }
}