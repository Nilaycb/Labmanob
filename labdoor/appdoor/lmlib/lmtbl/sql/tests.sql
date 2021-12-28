CREATE TABLE `tests` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_name` varchar(150) NOT NULL, 
`test_codename` varchar(150) NOT NULL, 
`test_category_id` int(11) UNSIGNED NOT NULL, 
`test_price` varchar(15) NOT NULL, 
`test_description` varchar(255) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `test_codename` (`test_codename`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `tests` (`test_name`, `test_codename`, `test_category_id`, `test_price`, `test_description`, `ctrl__status`, `created`, `modified`) VALUES ('master test name', 'master_test_codename', 1, '500', 'This is a sample description for master test', 1, NOW(), NOW()); **/ 
