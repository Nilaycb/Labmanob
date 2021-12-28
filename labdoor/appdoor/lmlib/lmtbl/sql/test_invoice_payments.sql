CREATE TABLE `test_invoice_payments` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL, 
`is_full_paid` int(3) NOT NULL, 
`paid_amount` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `test_invoice_id` (`test_invoice_id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `test_invoice_payments` (`test_invoice_id`, `is_full_paid`, `paid_amount`, `ctrl__status`, `created`, `modified`) VALUES (1, 1, '400', 1, NOW(), NOW()); **/ 
