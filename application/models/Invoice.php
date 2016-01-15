<?php

class Invoice extends ActiveRecord\Model {
    static $belongs_to = array(
        array('company'),        
        array('project')
    );

    static $has_many = array(
        array("invoice_has_items",
            'class_name' => 'InvoiceHasItem',
            'foreign_key' => 'invoice_id',
            'conditions' => 'shipping_item = "0"'
        ),

        array("invoice_has_shipping_items",
            'class_name' => 'InvoiceHasItem',
            'foreign_key' => 'invoice_id',
            'conditions' => 'shipping_item = "1"'
        ),


        array('invoice_has_payments'),
        array('invoice_has_trackings'),
        array('invoice_has_addresses'),
        array('items', 'through' => 'invoice_has_items')
 	);

}

class InvoiceHasPayment extends ActiveRecord\Model {
    static $belongs_to = array(
    array('invoice'),
    array('user')
    );
}

class InvoiceHasTracking extends ActiveRecord\Model {
    static $belongs_to = array(
        array('invoice')
    );
}

class InvoiceHasAddress extends ActiveRecord\Model {
    static $belongs_to = array(
        array('invoice'),
        array('company')
    );
}

class InvoiceHasItem extends ActiveRecord\Model {
   	static $belongs_to = array(
    array('invoice'),
    array('item')
    );
}

class Item extends ActiveRecord\Model {
   	static $has_many = array(
    array('invoice_has_items')
    );
} 