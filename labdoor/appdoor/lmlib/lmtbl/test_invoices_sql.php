<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['test_invoices']['query'] = "CREATE TABLE `test_invoices` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`patient_id` int(11) UNSIGNED NOT NULL, 
`patient_age` varchar(30) NOT NULL, 
`ref_by` varchar(200) NOT NULL default '', 
`affiliate_partner_id` int(11) UNSIGNED NOT NULL default 1, 
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(200) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`extra_info` varchar(255) NOT NULL default '', 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['test_invoices']['name'] = "test_invoices";

$db_tables['test_invoices']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'patient_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
        ),
        'patient_age' => array(
            'type' => 'VARCHAR',
            'constraint' => '30',
        ),
        'ref_by' => array(
            'type' => 'VARCHAR',
            'constraint' => '200',
            'default' => '',
        ),
        'affiliate_partner_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'default' => 1,
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
            'constraint' => '200',
            'default' => '',
        ),
        'subtotal' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'extra_info' => array(
            'type' => 'VARCHAR',
            'constraint' => '255',
            'default' => '',
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