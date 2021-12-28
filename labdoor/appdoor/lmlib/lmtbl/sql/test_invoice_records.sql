CREATE TABLE `test_invoice_records` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL, 
`test_id` int(11) UNSIGNED NOT NULL, 
`test_price` varchar(15) NOT NULL, 
`quantity` int(3) UNSIGNED NOT NULL, 
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(150) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `test_invoice_records` (`test_invoice_id`, `test_id`, `test_price`, `quantity`, `total`, `discount`, `discount_by`, `subtotal`, `ctrl__status`, `created`, `modified`) VALUES (1, 1, '100', 5, '500', '100', 'discount by name', '400', 'no extra information', 1, NOW(), NOW()); **/ 
