<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['test_invoice_records']['query'] = "CREATE TABLE `test_invoice_records` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL, 
`test_id` int(11) UNSIGNED NOT NULL, 
`test_price` varchar(15) NOT NULL, 
`quantity` int(3) UNSIGNED NOT NULL, 
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(150) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['test_invoice_records']['name'] = "test_invoice_records";

$db_tables['test_invoice_records']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'test_invoice_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
        ),
        'test_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
        ),
        'test_price' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'quantity' => array(
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => TRUE,
        ),
        'total' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'discount' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
            'default' => '',
        ),
        'discount_by' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'default' => '',
        ),
        'subtotal' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'ctrl__status' => array(
            'type' => 'INT',
            'constraint' => 3,
            'default' => 1,
        ),
        'created' => array(
            'type' => 'DATETIME',
        ),
        'modified' => array(
            'type' => 'DATETIME',
        ),
    ); 

?>