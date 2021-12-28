<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['test_invoice_payments']['query'] = "CREATE TABLE `test_invoice_payments` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL, 
`is_full_paid` int(3) NOT NULL, 
`paid_amount` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `test_invoice_id` (`test_invoice_id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['test_invoice_payments']['name'] = "test_invoice_payments";

$db_tables['test_invoice_payments']['fields'] = array(
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
            'unique' => TRUE,
        ),
        'is_full_paid' => array(
            'type' => 'INT',
            'constraint' => 3,
        ),
        'paid_amount' => array(
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