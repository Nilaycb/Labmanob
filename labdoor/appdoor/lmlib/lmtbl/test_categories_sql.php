<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['test_categories']['query'] = "CREATE TABLE `test_categories` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`category_name` varchar(150) NOT NULL, 
`category_codename` varchar(150) NOT NULL, 
`category_description` varchar(255) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `category_codename` (`category_codename`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['test_categories']['name'] = "test_categories";

$db_tables['test_categories']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'category_name' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'category_codename' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'unique' => TRUE,
        ),
        'category_description' => array(
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