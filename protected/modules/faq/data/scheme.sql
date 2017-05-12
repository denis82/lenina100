DROP TABLE IF EXISTS `bags_faq`;
CREATE TABLE IF NOT EXISTS `bags_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_q` varchar(255) DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `quest` text,
  `name_a` varchar(255) DEFAULT NULL,
  `answer` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `weight` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bags_faq_category`;
CREATE TABLE IF NOT EXISTS `bags_faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;