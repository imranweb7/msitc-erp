<?php

class Project extends ActiveRecord\Model {
	static $belongs_to = array(
     array('company'),
     array('project_type', 'class_name' => 'ProjectType', 'foreign_key' => 'project_type_id'),
  );

	static $has_many = array(
    array("project_has_tasks"),
        array("project_has_items",
            'class_name' => 'ProjectHasItem',
            'foreign_key' => 'project_id',
            'conditions' => 'type = "regular"'
        ),

        array("project_has_shipping_items",
            'class_name' => 'ProjectHasItem',
            'foreign_key' => 'project_id',
            'conditions' => 'type = "shipping"'
        ),
    array('project_has_files'),
    array('project_has_workers'),
    array('project_has_invoices'),
    array('project_has_activities',
           'order'    => 'datetime DESC'),
    array('messages')
    );
}
