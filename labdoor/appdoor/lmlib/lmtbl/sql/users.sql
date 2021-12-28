CREATE TABLE `users` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
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
ENGINE=InnoDB DEFAULT CHARSET=utf8; 


INSERT INTO `users` (`username`, `firstname`, `lastname`, `email`, `password`, `pin_code`, `token`, `verified`, `ctrl__status`, `created`, `modified`) VALUES ("master", "Master", "Account", "labmanob@outlook.com", "$2y$10$8m5636GiL3CdzetpYvBuJ.dJ2oy9K.7ibWCy.Kn3Yhn3sUBazkvRy", "555123", "master5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05"), ("admin", "Admin", "Account", "admin.labmanob@outlook.com", "$2y$10$LZVLtf4.N9E9MCK6LKBvYeja5.fZ1CwzmyG6Hcl.meVZKQ3w93M1W", "555123", "admin5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05"), ("Nonadmin", "Nonadmin", "Account", "nonadmin.labmanob@outlook.com", "$2y$10$tVogipHPeA8FIkVN2/tUvOn2HFWECY8/A7fxCwQMDqV1Omj54wGKi", "555123", "nonadmin5551235555555555555555555555555555555555555555555555555555", 1, 1, "2017-03-01 13:45:05", "2017-03-01 13:45:05"); 
