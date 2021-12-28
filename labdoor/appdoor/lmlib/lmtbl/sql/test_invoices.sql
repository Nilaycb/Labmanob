CREATE TABLE `test_invoices` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`patient_id` int(11) UNSIGNED NOT NULL, 
`patient_age` varchar(30) NOT NULL, 
`ref_by` varchar(200) NOT NULL default '', 
`affiliate_partner_id` int(11) UNSIGNED NOT NULL default 1, 
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(200) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`extra_info` varchar(255) NOT NULL default '', 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


/** INSERT INTO `test_vouchers` (`patient_id`, `patient_age`, `ref_by`, `affiliate_partner_id`, `total`, `discount`, `discount_by`, `subtotal`, `extra_info`, `ctrl__status`, `created`, `modified`) VALUES (1, '20', 'referred by name', '0', '500', '100', 'discount by name', '400', 'no extra information', 1, NOW(), NOW()); **/ 
