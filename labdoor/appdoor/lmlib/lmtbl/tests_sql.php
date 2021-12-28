<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['tests']['query'] = "CREATE TABLE `tests` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_name` varchar(150) NOT NULL, 
`test_codename` varchar(150) NOT NULL, 
`test_category_id` int(11) UNSIGNED NOT NULL, 
`test_price` varchar(15) NOT NULL, 
`test_description` varchar(255) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `test_codename` (`test_codename`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['tests']['name'] = "tests";

$db_tables['tests']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'test_name' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'test_codename' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'unique' => TRUE,
        ),
		'test_category_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
        ),
		'test_price' => array(
            'type' => 'VARCHAR',
            'constraint' => '15',
        ),
        'test_description' => array(
            'type' => 'VARCHAR',
            'constraint' => '255',
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