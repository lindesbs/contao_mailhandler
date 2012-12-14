<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


$GLOBALS['TL_DCA']['tl_mailhandler_incomingmail'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'closed'                      => true,
		'notEditable'                 => true
	),

	// List
	'list'  => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('tstamp DESC', 'id DESC'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('tstamp', 'mail_subject','mail_to','mail_from'),
			'format'                  => '<span style="color:#b3b3b3;padding-right:3px">[%s]</span> %s<br>%s<br>%s',
			'maxCharacters'           => 96,
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['tstamp'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 6
		),
		'mail_subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['source'],
			'filter'                  => true,
			'sorting'                 => true,
			'reference'               => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']
		),
		'mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['action'],
			'filter'                  => true,
			'sorting'                 => true
		),
		'mail_to' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['username'],
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true
		),
		'mail_useragent' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_incomingmail']['browser'],
			'sorting'                 => true,
			'search'                  => true
		)
	)
);
