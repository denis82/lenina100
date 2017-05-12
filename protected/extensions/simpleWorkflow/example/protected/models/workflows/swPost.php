<?php	
	return array(
		'initial' => 'draft',
		'node' => array(
			array('id'=>'draft',	 'transition'=>'correction'),
			array('id'=>'ready',
				'constraint' => '!empty($this->tags)',	 
				'transition'=>'draft,correction,published'),
			array('id'=>'correction','transition'=>'draft,ready'),
			array('id'=>'published', 'transition'=>'ready,archived'),
			array('id'=>'archived',	 'transition'=>'ready'),
		)
	)
?>