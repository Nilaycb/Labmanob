<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['affiliate_partners']['query'] = "CREATE TABLE `affiliate_partners` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`firstname` varchar(150) NOT NULL, 
`lastname` varchar(150) NOT NULL, 
`sex` varchar(15) NOT NULL, 
`phone_no` varchar(100) NOT NULL, 
`email` varchar(150) NOT NULL default '', 
`img_id` int(11) UNSIGNED NOT NULL default 1, 
`current_address` varchar(255) NOT NULL, 
`permanent_address` varchar(255) NOT NULL default '', 
`current_city` varchar(50) NOT NULL, 
`permanent_city` varchar(50) NOT NULL default '', 
`extra_info` varchar(255) NOT NULL default '', 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['affiliate_partners']['name'] = "affiliate_partners";

$db_tables['affiliate_partners']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'firstname' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'lastname' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'sex' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'phone_no' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'email' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'default' => '',
        ),
        'img_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'default' => 1,
        ),
        'current_address' => array(
            'type' => 'VARCHAR',
            'constraint' => '255',
        ),
        'permanent_address' => array(
            'type' => 'VARCHAR',
            'constraint' => '255',
            'default' => '',
        ),
        'current_city' => array(
            'type' => 'VARCHAR',
            'constraint' => '50',
        ),
        'permanent_city' => array(
            'type' => 'VARCHAR',
            'constraint' => '50',
            'default' => '',
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