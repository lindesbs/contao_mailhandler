<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

class ActorImapMail extends ActorAbstractClass
{
    public function getItem($strMessageID)
    {
       
        list($uid,$messageID) = explode("::",$strMessageID);
        
        $objBody = imap_body($this->mbox, $uid);
        $objHeader = imap_header($this->mbox, $uid);
         
        $objItem = new ItemObject($strMessageID);
        
        
        
           $objItem->From=$objHeader->fromaddress;
           $objItem->To = $objHeader->toaddress;
           $objItem->Subject =  imap_utf7_decode($objHeader->Subject);
           $objItem->Body = "";
           $objItem->Attachments = "";
           
        return $objItem;
    }
    
    
    public function fetchAllItems()
    {
            $this->mbox = imap_open($this->arrConfig['imapCheckFolder'], 
                                    $this->arrConfig['imapUser'],
                                    $this->arrConfig['imapPassword'], OP_READONLY);
           
           $check = imap_check($this->mbox);
           $overviews = imap_fetch_overview($this->mbox,"1:{$check->Nmsgs}",FT_UID);
           
           $arrReturn = array();
           foreach ($overviews as $imapNumber=>$imapItem)
           {
               if (strlen(trim($imapItem->uid))>0)
                    $arrReturn[] = $imapItem->uid.'::'.$imapItem->message_id;
               
           }
           
        return $arrReturn;
    }
    
    
    
    
    public function getDCA()
    {
        return array(
            
                'imapHost' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapHost'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255,'mandatory'=>true,'tl_class'=>'w50')
                    ),
                'imapPort' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapPort'],
                        'default'               => 143,
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255,'mandatory'=>true,'tl_class'=>'w50')
                    ),
                'imapUser' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapUser'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255,'mandatory'=>true,'tl_class'=>'w50')
                    ),
                'imapPassword' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapPassword'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('rgxp' => 'password','maxlength'=>255,'mandatory'=>true,'tl_class'=>'w50')
                    ),
                
                'imapOptions' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapOptions'],
                        'exclude'                 => false,
                        'inputType'               => 'checkbox',
                        'options'          => array(
                                                    'secure'=>'secure',
                                                    'imap'=>'imap',
                                                    'imap2'=>'imap2',
                                                    'imap4'=>'imap4',
                                                    'ssl'=>'ssl',
                                                    'validate-cert'=>'validate-cert',
                                                    'novalidate-cert'=> 'novalidate-cert',
                                                    'tls' => 'tls',
                                                    'notls'=>'notls',
                                                    'readonly'=>'readonly'
                                               ),
                        'eval'                    => array('multiple'=>true)
                    ),
                    
                    'imapCheckFolder' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['imapCheckFolder'],
                        'exclude'                 => false,
                        'inputType'               => 'select',
                        'options_callback'          => array('ActorImapMail','getIMapFolders'),
                        'eval'                    => array('mandatory'=>false)
                    ),
                    
        );    
    
    }


    public function getIMapFolders(DataContainer $dc)
    {
        
        $strImapConnect = sprintf("{%s:%d/%s}",$dc->getData("imapHost"),$dc->getData("imapPort"),implode("/",deserialize($dc->getData("imapOptions"))));
       
@set_error_handler(null);
@set_exception_handler(null);
@ini_set('display_errors', 0);
error_reporting(0);
     
         $this->mbox = imap_open($strImapConnect, trim($dc->getData("imapUser")),trim($dc->getData("imapPassword")), OP_READONLY);
          
@set_error_handler('__error');
@set_exception_handler('__exception');          
@ini_set('display_errors', ($GLOBALS['TL_CONFIG']['displayErrors'] ? 1 : 0));
error_reporting(($GLOBALS['TL_CONFIG']['displayErrors'] || $GLOBALS['TL_CONFIG']['logErrors'] ? E_ALL|E_STRICT : 0));
          
        
        $arrReturn = array();
        
        if ($this->mbox)
        {
            
            $list = imap_list($this->mbox, $strImapConnect, "*");
            if (is_array($list)) 
            {
                foreach ($list as $val) 
                {
                    $arrReturn[imap_utf7_decode($val)] = str_replace($strImapConnect, "", imap_utf7_decode($val));
                }
            } 
            else 
            {

                
                $_SESSION['TL_ERROR'][] = "imap_list failed: " . imap_last_error();
            }
            
            imap_close($mbox);
        }
        else
            {
                
                $_SESSION['TL_ERROR'][] = "Can't connect: " . imap_last_error();
            }
        return $arrReturn;

    }
}