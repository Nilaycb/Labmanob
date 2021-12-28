CREATE TABLE `image_files_records` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`file_id` int(11) UNSIGNED NOT NULL,  
`image_width` varchar(10) NOT NULL, 
`image_height` varchar(10) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
PRIMARY KEY (`id`), UNIQUE KEY `file_id` (`file_id`))
ENGINE=InnoDB DEFAULT CHARSET=utf8";


INSERT INTO `image_files_records` (`file_id`, `image_width`, `image_height`, `ctrl__status`, `created`) VALUES (1, "1255", "680", 1, "2017-03-01 13:45:05"); 
