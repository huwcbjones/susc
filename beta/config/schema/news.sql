#
# News Table
#

CREATE TABLE news (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  author int NOT NULL,
  content text NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  start datetime COMMENT 'Date article is live from',
  end datetime COMMENT 'Date article is live until',
  hits int(11) COMMENT 'Number of times the article has been read',
  status bool NOT NULL DEFAULT false COMMENT 'true = active, false = inactive',

  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;