CREATE TABLE `files` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
`file_name` varchar(150) NOT NULL, 
`file_type` varchar(100) NOT NULL, 
`file_path` varchar(253) NOT NULL, 
`file_size` varchar(25) NOT NULL, 
`file_ext` varchar(10) NOT NULL, 
'encode_level' int(2) NOT NULL default 0,
`ctrl__status` int(3) NOT NULL default 1,
`created` datetime NOT NULL, 
PRIMARY KEY (`id`))
ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `files` (`file_name`, `file_type`, `file_path`, `file_size`, `file_ext`, `encode_level`, `ctrl__status`, `created`) VALUES ("f018e7275c57283fcedd8b0b506db828.png.txt", "image/png", "images/", "34.81", ".png", 2, 1, "2017-03-01 13:45:05"); 
