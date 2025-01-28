CREATE DATABASE IF NOT EXISTS iaw-ae2
CHARACTER SET utf8mb4 COLLATE utf8mb4_es_0900_as_cs;

USE iaw-ae2;

CREATE TABLE IF NOT EXISTS users(
  id_user varchar(50),
  password varchar(100) NOT NULL,
  email varchar(100) UNIQUE,
  calendar_token varchar(100),
  user_created datetime,
  user_lastlogin timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id_user)
);


CREATE TABLE IF NOT EXISTS tasks(
  id_task int(11) AUTO_INCREMENT,
  id_creator varchar(50) NOT NULL,
  id_owner varchar(50),
  title varchar(100) NOT NULL,
  description mediumtext NOT NULL,
  date_created timestamp NOT NULL DEFAULT current_timestamp(),
  date_modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  date_finished timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  status varchar(15),
  PRIMARY KEY (id_task),
  CONSTRAINT task_id_creator_fk FOREIGN KEY (id_creator) REFERENCES users(id_user) ON DELETE CASCADE,
  CONSTRAINT task_id_owner_fk FOREIGN KEY (id_owner) REFERENCES users(id_user)
);
