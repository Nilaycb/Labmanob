<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['files']['query'] = "CREATE TABLE `files` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`file_name` varchar(150) NOT NULL, 
`file_type` varchar(100) NOT NULL, 
`file_path` varchar(253) NOT NULL, 
`file_size` varchar(25) NOT NULL, 
`file_ext` varchar(10) NOT NULL, 
'encode_level' int(2) NOT NULL default 0,
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
PRIMARY KEY (`id`))
ENGINE=InnoDB DEFAULT CHARSET=utf8"; 

$db_tables['files']['insert_query'] = 'INSERT INTO `files` (`file_name`, `file_type`, `file_path`, `file_size`, `file_ext`, `encode_level`, `ctrl__status`, `created`) VALUES ("f018e7275c57283fcedd8b0b506db828.png.txt", "image/png", "images/", "34.81", ".png", 2, 1, "2017-03-01 13:45:05")';

$db_tables['files']['name'] = "files";

$db_tables['files']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'file_name' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'file_type' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'file_path' => array(
            'type' => 'VARCHAR',
            'constraint' => '253',
        ),
        'file_size' => array(
            'type' => 'VARCHAR',
            'constraint' => '25',
        ),
        'file_ext' => array(
            'type' => 'VARCHAR',
            'constraint' => '10',
        ),
        'encode_level' => array(
            'type' => 'INT',
            'constraint' => 2,
            'default' => 0,
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

$db_tables['files']['insert_fields'] = array(
        array(
            'file_name' => 'f018e7275c57283fcedd8b0b506db828.png.txt', 
            'file_type' => 'image/png', 
            'file_path' => 'images/', 
            'file_size' => '34.81', 
            'file_ext' => '.png', 
            'encode_level' => 2, 
            'ctrl__status' => 1, 
            'created' => '2017-03-01 13:45:05', 
        )
    ); 

?>