<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$db_tables['users']['query'] = "CREATE TABLE `users` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`username` varchar(30) NOT NULL, 
`firstname` varchar(150) NOT NULL, 
`lastname` varchar(150) NOT NULL, 
`email` varchar(150) NOT NULL, 
`password` varchar(128) NOT NULL, 
`pin_code` varchar(10) NOT NULL default '', 
`token` varchar(150) NOT NULL default '',
`verified` int(2) NOT NULL default 0,
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `username` (`username`), UNIQUE KEY `email_verified` (`email`, `verified`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8"; 

$db_tables['users']['insert_query'] = 'INSERT INTO `users` (`username`, `firstname`, `lastname`, `email`, `password`, `pin_code`, `token`, `verified`, `ctrl__status`, `created`, `modified`) VALUES ("master", "Master", "Account", "labmanob@outlook.com", "$2y$10$CG97vNaYB6qlwWZEPjJX5O7ltCYC0EPrLxoUI/23HhqHlEx9pG1cS", "555123", "master5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05"), ("admin", "Admin", "Account", "admin.labmanob@outlook.com", "$2y$10$6/Pl5evfgSnqoX1XO2aipO/CWAi9aEDdjMAfLpcAbPGD5X7VbOoYu", "555123", "admin5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05"), ("Nonadmin", "Nonadmin", "Account", "nonadmin.labmanob@outlook.com", "$2y$10$tVogipHPeA8FIkVN2/tUvOn2HFWECY8/A7fxCwQMDqV1Omj54wGKi", "555123", "nonadmin5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05")';

$db_tables['users']['name'] = "users";

$db_tables['users']['fields'] = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ),
        'username' => array(
            'type' => 'VARCHAR',
            'constraint' => '30',
            'unique' => TRUE,
        ),
        'firstname' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'lastname' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'email' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
        ),
        'password' => array(
            'type' => 'VARCHAR',
            'constraint' => '128',
        ),
        'pin_code' => array(
            'type' => 'VARCHAR',
            'constraint' => '10',
            'default' => '',
        ),
        'token' => array(
            'type' => 'VARCHAR',
            'constraint' => '150',
            'default' => '',
        ),
        'verified' => array(
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
        'modified' => array(
            'type' => 'DATETIME',
        ),
    );

$db_tables['users']['insert_fields'] = array(
        array(
            'username' => 'master', 
            'firstname' => 'Master', 
            'lastname' => 'Account', 
            'email' => 'labmanob@outlook.com', 
            'password' => '$2y$10$8m5636GiL3CdzetpYvBuJ.dJ2oy9K.7ibWCy.Kn3Yhn3sUBazkvRy', 
            'pin_code' => '555123', 
            'token' => 'master5551235555555555555555555555555555555555555555555555555555', 
            'verified' => 1, 
            'ctrl__status' => 1, 
            'created' => '2017-03-01 13:45:05', 
            'modified' => '2017-03-01 13:45:05' 
        ),
        array(
            'username' => 'admin', 
            'firstname' => 'Admin', 
            'lastname' => 'Account', 
            'email' => 'admin.labmanob@outlook.com', 
            'password' => '$2y$10$LZVLtf4.N9E9MCK6LKBvYeja5.fZ1CwzmyG6Hcl.meVZKQ3w93M1W', 
            'pin_code' => '555123', 
            'token' => 'admin5551235555555555555555555555555555555555555555555555555555', 
            'verified' => 1, 
            'ctrl__status' => 1, 
            'created' => '2017-03-01 13:45:05', 
            'modified' => '2017-03-01 13:45:05' 
        ),
        array(
            'username' => 'nonadmin', 
            'firstname' => 'Nonadmin', 
            'lastname' => 'Account', 
            'email' => 'nonadmin.labmanob@outlook.com', 
            'password' => '$2y$10$tVogipHPeA8FIkVN2/tUvOn2HFWECY8/A7fxCwQMDqV1Omj54wGKi', 
            'pin_code' => '555123', 
            'token' => 'nonadmin5551235555555555555555555555555555555555555555555555555555', 
            'verified' => 1, 
            'ctrl__status' => 1, 
            'created' => '2017-03-01 13:45:05', 
            'modified' => '2017-03-01 13:45:05' 
        ),
    ); 

?>