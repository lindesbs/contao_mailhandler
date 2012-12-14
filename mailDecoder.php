<?php

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('system/initialize.php');


class MailDecode extends Frontend
{


	public function __construct()
	{
		parent::__construct();

		define('BE_USER_LOGGED_IN', false);
		define('FE_USER_LOGGED_IN', false);
	}


	/**
	 * Run the controller
	 */
	public function run()
	{
		

		if (php_sapi_name()!='cli')
			die();
		
		
		include('Mail/mimeDecode.php');
		
		
		$params['include_bodies'] = true;
		$params['decode_bodies']  = true;
		$params['decode_headers'] = true;
		
		
		$sock = fopen ("php://stdin", 'r');
		stream_set_blocking($sock,false);
		$email = '';
		
		//Read e-mail into buffer
		while (!feof($sock))
		{
		    $strReadLine = fread($sock, 1024);
			
			if (empty($strReadLine))
			{
				$email = false;
				break;
			}
			
			$email .= $strReadLine;
		}
		
		//Close socket
		fclose($sock);
		
		
		if ($email!==FALSE)
		{
			$decoder = new Mail_mimeDecode($email);
			$structure = $decoder->decode($params);
			
			if ($GLOBALS['TL_CONFIG']['mailhandler_store_incomingmail'])
			{
				$objDataExists = $this->Database->prepare("SELECT id FROM tl_mailhandler_incomingmail WHERE message_id=?")->execute((string) $structure->headers['message-id']);
				
				if ($objDataExists->numRows==0)
				{
					
					$arrSet = array(
						'tstamp'	=> time(),
						'mail_date' => $structure->headers['date'],
						'mail_useragent' => $structure->headers['user-agent'],
						
						'message_id' => $structure->headers['message-id'],
						'mail_to'	=> $structure->headers['to'],
						'mail_from'	=> $structure->headers['from'],
						'mail_subject'	=> $structure->headers['subject'],
					);
					
					
					$this->Database->prepare("INSERT INTO tl_mailhandler_incomingmail %s")->set($arrSet)->execute();
				}
			}
		}
		
	}


}


$objMailDecode = new MailDecode();
$objMailDecode->run();

?>