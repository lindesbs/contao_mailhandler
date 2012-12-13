<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


$GLOBALS['BE_MOD']['mailhandler'] = array(

	'mailhandler_settings'	=> array('tables' => array('tl_mailhandler_settings')),
	'mailhandler_actor'	=> array('tables' => array('tl_mailhandler_actor')),
	'mailhandler_action'	=> array('tables'=> array('tl_mailhandler_action','tl_mailhandler_action_item'))
);


if ($GLOBALS['TL_CONFIG']['mailhandler_store_incomingmail'])
{
	
	$GLOBALS['BE_MOD']['mailhandler']['mailhandler_incomingmail']['tables']	= array('tl_mailhandler_incomingmail');
	
}


$GLOBALS['TL_MAILHANDLER_ACTORS']['actor_demomail'] = "ActorDemoMail";


$GLOBALS['TL_MAILHANDLER_HANDLER']['LOGGING'] = "HandlerLogging";
$GLOBALS['TL_MAILHANDLER_HANDLER']['ADDNEWS'] = "HandlerAddNews";
$GLOBALS['TL_MAILHANDLER_HANDLER']['SENDMAIL'] = "HandlerSendMail";
