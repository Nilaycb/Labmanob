<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['test_invoice_logs']['query'] = "CREATE TABLE `test_invoice_logs` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL,  
`username` varchar(30) NOT NULL, 
`prev_total` varchar(15) NOT NULL, 
`prev_discount` varchar(15) NOT NULL default '', 
`prev_discount_by` varchar(200) NOT NULL default '', 
`prev_subtotal` varchar(15) NOT NULL,
`prev_is_full_paid` int(3) NOT NULL, 
`prev_paid_amount` varchar(15) NOT NULL,  
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(200) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`is_full_paid` int(3) NOT NULL, 
`paid_amount` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['test_invoice_logs']['name'] = "test_invoice_logs";

$db_tables['test_invoice_logs']['fields'] = array(
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
        
        'username' => array(
            'type' => 'VARCHAR',
            'constraint' => '30',
        ),
        'prev_total' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'prev_discount' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
            'default' => '',
        ),
        'prev_discount_by' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'default' => '',
        ),
        'prev_subtotal' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'prev_is_full_paid' => array(
            'type' => 'INT',
            'constraint' => 3,
        ),
        'prev_paid_amount' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
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