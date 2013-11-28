<?php

return array(
	'initial' => 'registered',
	'node' => array(
		array(
			'id' => 'registered',
			'label' => 'Registered',
			'transition' => 'active'
		),
		array(
			'id' => 'active',
			'label' => 'Active',
			'transition' => 'banned'
		),
		array(
			'id' => 'banned',
			'label' => 'Banned',
			'transition' => 'active'
		),
	),
);
