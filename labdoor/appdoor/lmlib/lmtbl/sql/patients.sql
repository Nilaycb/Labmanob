CREATE TABLE `patients` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
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


/** INSERT INTO `patients` (`firstname`, `lastname`, `sex`, `phone_no`, `email`, `img_id`, `current_address`, `permanent_address`, `current_city`, `permanent_city`, `extra_info`, `ctrl__status`, `created`, `modified`) VALUES ('Master', 'Patient', 'undefined', '0123456789', 'master@patients.test', 1, 'master_patient current_address', 'master_patient permanent_address', 'master_patient current_city', 'master_patient permanent_city', '', 1, NOW(), NOW()); **/ 