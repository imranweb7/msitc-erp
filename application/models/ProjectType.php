<?php

class ProjectType extends ActiveRecord\Model {
    static $table_name = 'project_types';

    static $has_many = array(
        array("projects"),
    );

}
