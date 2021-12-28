CREATE TABLE `test_categories` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`category_name` varchar(150) NOT NULL, 
`category_codename` varchar(150) NOT NULL, 
`category_description` varchar(255) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `category_codename` (`category_codename`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `test_categories` (`category_name`, `category_codename`, `category_description`, `ctrl__status`, `created`, `modified`) VALUES ('master test_category', 'master_test_category_codename', 'This is a sample description for master test_category', 1, NOW(), NOW()); **/ 
