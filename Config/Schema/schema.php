<?php

class NodesSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $EshopItems = array(
		'id' => array('type' => 'integer', 'null' => false, 'lenght' => 11, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => false, 'lenght' => 11),
		'parent_id' => array('type' => 'integer', 'null' => true, 'lenght' => 11),
		'lft' => array('type' => 'integer', 'null' => true, 'lenght' => 11),
		'rght' => array('type' => 'integer', 'null' => true, 'lenght' => 11),
		'eshop_supplier_id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'default' => 0),
		'title' => array('type' => 'string', 'null' => false, 'length' => 200, 'default' => 'title'),
		'description' => array('type' => 'string', 'null' => true, 'length' => 250, 'default' => ''),
		'order_code' => array('type' => 'string', 'null' => true, 'length' => 50),
		'supplier_order_code' => array('type' => 'string', 'null' => true, 'length' => 50),
		'supplier_price' => array('type' => 'float', 'null' => true),
		'vat' => array('type' => 'float', 'null' => false, 'default' => 19),
		'price_without_vat' => array('type' => 'float', 'null' => false),
		'delivery_days' => array('type' => 'integer', 'null' => true, 'length' => 4, 'default' => 14),
		'on_stock' => array('type' => 'integer', 'null' => true, 'length' => 4, 'default' => 2),
		'discount_percentage' => array('type' => 'float', 'null' => true),
		'note' => array('type' => 'text', 'null' => true),
		'created' => array('type' => 'timestamp', 'null' => false, 'length' => NULL),
		'updated' => array('type' => 'timestamp', 'null' => false, 'length' => NULL),
		'tableParameters' => array('charset' => 'utf8', 'engine' => 'MyISAM')
	);

	public $eshopOrders = array(
		'id' => array('type' => 'integer', 'null' => false, 'lenght' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'adress_street' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'adress_city' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'adress_zip' => array('type' => 'string', 'null' => true, 'lenth' => 6),
		'adress_country' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'contact_phone' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'contact_fax' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'contact_email' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'companyid' => array('type' => 'string', 'null' => true, 'lenth' => 20),
		'companyid_vat' => array('type' => 'string', 'null' => true, 'lenth' => 20),
		'delivery_adress_name' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'delivery_adress_street' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'delivery_adress_city' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'delivery_adress_zip' => array('type' => 'string', 'null' => true, 'lenth' => 6),
		'delivery_country' => array('type' => 'string', 'null' => true, 'lenth' => 200),
		'items' => array('type' => 'text', 'null' => false),
		'order_note' => array('type' => 'text', 'null' => true),
		'shipping' => array('type' => 'string', 'null' => false, 'lenth' => 50),
		'note' => array('type' => 'text', 'null' => true),
		'status' => array('type' => 'string', 'null' => false, 'lenth' => 50),
		'payement' => array('type' => 'string', 'null' => false, 'lenth' => 50),
		'created' => array('type' => 'timestamp', 'null' => true),
		'updated' => array('type' => 'timestamp', 'null' => true),
		'tableParameters' => array('charset' => 'utf8', 'engine' => 'MyISAM')
	);

	public $EshopSuppliers = array(
		'id' => array('type' => 'integer', 'null' => false, 'lenght' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'created' => array('type' => 'timestamp', 'null' => false, 'length' => NULL),
		'updated' => array('type' => 'timestamp', 'null' => false, 'length' => NULL),
		'tableParameters' => array('charset' => 'utf8', 'engine' => 'MyISAM')
	);

}
