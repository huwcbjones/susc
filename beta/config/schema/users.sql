#
# Users Table
#
CREATE TABLE users(
  users_id int(11) NOT NULL auto_increment,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  firstName varchar(255) NOT NULL,
  lastName varchar(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created DATETIME,
  modified DATETIME,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;