CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;



INSERT INTO `product` (`id`, `name`) VALUES
(1, 'Wellness Cat Food'),
(2, 'Natural Balance Indoor Cat Food'),
(3, 'Trader Joe’s Chicken, Turkey & Rice Dinner'),
(4, 'Friskies'),
(5, 'Science Diet');


CREATE TABLE IF NOT EXISTS `product_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `score` float NOT NULL,
  `create_time` datetime NOT NULL,
  `remote_ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;
