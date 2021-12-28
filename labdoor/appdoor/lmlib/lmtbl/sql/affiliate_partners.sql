CREATE TABLE `affiliate_partners` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
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
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `affiliate_partners` (`firstname`, `lastname`, `sex`, `phone_no`, `email`, `img_id`, `current_address`, `permanent_address`, `current_city`, `permanent_city`, `extra_info`, `ctrl__status`, `created`, `modified`) VALUES ('Master', 'Affiliate Partners', 'undefined', '0123456789', 'master@affiliate_partners.test', 1, 'affiliate_partners current_address', 'affiliate_partners permanent_address', 'affiliate_partners current_city', 'affiliate_partners permanent_city', '', 1, NOW(), NOW()); **/ 