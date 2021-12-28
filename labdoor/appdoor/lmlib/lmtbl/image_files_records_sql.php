<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['image_files_records']['query'] = "CREATE TABLE `image_files_records` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`file_id` int(11) UNSIGNED NOT NULL,  
`image_width` varchar(10) NOT NULL, 
`image_height` varchar(10) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `file_id` (`file_id`))
ENGINE=InnoDB DEFAULT CHARSET=utf8"; 

$db_tables['image_files_records']['insert_query'] = 'INSERT INTO `image_files_records` (`file_id`, `image_width`, `image_height`, `ctrl__status`, `created`) VALUES (1, "1255", "680", 1, "2017-03-01 13:45:05")';

$db_tables['image_files_records']['name'] = "image_files_records";

$db_tables['image_files_records']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'file_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'unique' => TRUE,
        ),
        'image_width' => array(
            'type' => 'VARCHAR',
            'constraint' => '10',
        ),
        'image_height' => array(
            'type' => 'VARCHAR',
            'constraint' => '10',
        ),
        'ctrl__status' => array(
            'type' => 'INT',
            'constraint' => 3,
            'default' => 1,
        ),
        'created' => array(
            'type' => 'DATETIME',
        ),
    );

$db_tables['image_files_records']['insert_fields'] = array(
        array(
            'file_id' => 1, 
            'image_width' => '1255', 
            'image_height' => '680', 
            'ctrl__status' => 1, 
            'created' => '2017-03-01 13:45:05'
        )
    ); 

?>