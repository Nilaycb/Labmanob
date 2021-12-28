<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['login_attempts']['query'] = "CREATE TABLE `login_attempts` (`id` int(11) NOT NULL AUTO_INCREMENT, 
`uid` int(11) NOT NULL, 
`ip` varchar(50) NOT NULL, 
`agent` varchar(255) NOT NULL,  
`time_value` varchar(30) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, `date_time` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db_tables['login_attempts']['name'] = "login_attempts";

$db_tables['login_attempts']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'uid' => array(
            'type' => 'INT',
            'constraint' => 11,
            ),
        'ip' => array(
            'type' => 'VARCHAR',
            'constraint' => '50',
        ),
        'agent' => array(
            'type' => 'VARCHAR',
            'constraint' => '255',
        ),
        'time_value' => array(
            'type' => 'VARCHAR',
            'constraint' => '30',
        ),
        'ctrl__status' => array(
            'type' => 'INT',
            'constraint' => 3,
            'default' => 1,
        ),
        'date_time' => array(
            'type' => 'DATETIME',
        ),
    );

?>