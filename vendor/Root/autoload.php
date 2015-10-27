<?php

require_once join( DS, array('System', 'Application.php'));

return array( 'routes' => array(
		'^(.*)$'      => array(
			'call'    => 'Main\view\index.php',
			'rawcall' => 'Main/view/index.php',		
		),
	),
);