<?php

define('TL_MODE', 'FE');
require ('../../initialize.php');

/**
 * Class CronJob
 *
 * Cron job controller.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class MailHandlerCron extends Frontend
{

	/**
	 * Initialize the object (do not remove)
	 */
	public function __construct()
	{
		parent::__construct();

		// See #4099
		define('BE_USER_LOGGED_IN', false);
		define('FE_USER_LOGGED_IN', false);
	}

	/**
	 * Run the controller
	 */
	public function run()
	{

		$objActions = $this -> Database -> prepare("SELECT * FROM tl_mailhandler_action WHERE active='1' ORDER BY sorting ASC") -> execute();

		while ($objActions -> next())
		{
			$arrActors = deserialize($objActions -> actors);
			$arrObjectActor = array();

			foreach ($arrActors as $actorID)
			{
				$objDBActor = $this -> Database -> prepare("SELECT * FROM tl_mailhandler_actor WHERE id=?") -> limit(1) -> execute($actorID);

				if (class_exists($GLOBALS['TL_MAILHANDLER_ACTORS'][$objDBActor -> provider]))
				{

					$objAct = new $GLOBALS['TL_MAILHANDLER_ACTORS'][$objDBActor->provider]();
					$objAct -> setConfig($objDBActor -> provider_config);

					$arrItems = $objAct -> fetchAllItems();

					if ((is_array($arrItems)) && (count($arrItems) > 0))
					{
						foreach ($arrItems as $itemID)
						{
							try
							{
								$objItemData = $objAct -> getItem($itemID);

							}
							catch (Exception $ex)
							{

							}

							$objActionItems = $this -> Database -> prepare("SELECT * FROM tl_mailhandler_action_item WHERE pid=? AND active='1' ORDER BY sorting ASC") -> execute($objActions -> id);

							while ($objActionItems -> next())
							{
								if (class_exists($GLOBALS['TL_MAILHANDLER_HANDLER'][$objActionItems -> type]))
								{
									try
									{

										$objItem = new $GLOBALS['TL_MAILHANDLER_HANDLER'][$objActionItems->type]();
										$objItem->setDCAConfig($objActionItems->handler_config);
										
										$objItem -> runItem($objActionItems -> row(), $objItemData, $objDBActor -> row());

									}
									catch (Exception $ex)
									{

									}

									if ($objItem -> stopAction)
									{
										break;
									}

								}

							}
						}

					}
				}
			}
		}
	}

}

/**
 * Instantiate controller
 */
$objMailHandlerCron = new MailHandlerCron();
$objMailHandlerCron -> run();
?>