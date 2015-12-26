<?php

class ProjectHasItem extends ActiveRecord\Model {
    static $table_name = 'project_has_items';

    static $belongs_to = array(
        array('project', 'class_name' => 'Project', 'foreign_key' => 'project_id'),
        array('item', 'class_name' => 'Item', 'foreign_key' => 'item_id')
  	);
}
