CREATE TABLE `login_attempts` (`id` int(11) NOT NULL AUTO_INCREMENT, 
`uid` int(11) NOT NULL, 
`ip` varchar(50) NOT NULL, 
`agent` varchar(255) NOT NULL,  
`time_value` varchar(30) NOT NULL, 
`ctrl__status` int(3) NOT NULL default 1, `date_time` datetime NOT NULL, 
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

