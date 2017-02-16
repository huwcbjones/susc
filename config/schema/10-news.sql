#
# News Table
#

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS news;

CREATE TABLE `news` (
  `id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` char(36) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `start` datetime DEFAULT NULL COMMENT 'Date article is live from',
  `end` datetime DEFAULT NULL COMMENT 'Date article is live until',
  `hits` int(11) DEFAULT NULL COMMENT 'Number of times the article has been read',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'true = active, false = inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `news`
  ADD PRIMARY KEY (`id`), ADD KEY `FK_user_id` (`user_id`), ADD FULLTEXT KEY `FT_content` (`content`);

ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);