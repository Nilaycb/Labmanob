CREATE TABLE `test_invoice_logs` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`test_invoice_id` int(11) UNSIGNED NOT NULL,  
`username` varchar(30) NOT NULL, 
`prev_total` varchar(15) NOT NULL, 
`prev_discount` varchar(15) NOT NULL default '', 
`prev_discount_by` varchar(200) NOT NULL default '', 
`prev_subtotal` varchar(15) NOT NULL,
`prev_is_full_paid` int(3) NOT NULL, 
`prev_paid_amount` varchar(15) NOT NULL,  
`total` varchar(15) NOT NULL, 
`discount` varchar(15) NOT NULL default '', 
`discount_by` varchar(200) NOT NULL default '', 
`subtotal` varchar(15) NOT NULL, 
`is_full_paid` int(3) NOT NULL, 
`paid_amount` varchar(15) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, 
`created` datetime NOT NULL, 
`modified` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8; 



