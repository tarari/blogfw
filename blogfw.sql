/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `blogfw` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `blogfw`;
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contents` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `editor` int(11) NOT NULL,
  `posts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_users1_idx` (`editor`),
  KEY `fk_comments_posts1_idx` (`posts_id`),
  CONSTRAINT `fk_comments_posts1` FOREIGN KEY (`posts_id`) REFERENCES ``.`posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`editor`) REFERENCES ``.`users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text,
  `createdAt` datetime NOT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users1_idx` (`editor`),
  CONSTRAINT `fk_posts_users1` FOREIGN KEY (`editor`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `posts_has_tags`;
CREATE TABLE `posts_has_tags` (
  `post` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  PRIMARY KEY (`post`,`tag`),
  KEY `fk_posts_has_tags_tags1_idx` (`tag`),
  KEY `fk_posts_has_tags_posts1_idx` (`post`),
  CONSTRAINT `fk_posts_has_tags_posts1` FOREIGN KEY (`post`) REFERENCES ``.`posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_has_tags_tags1` FOREIGN KEY (`tag`) REFERENCES ``.`tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `email` varchar(90) NOT NULL,
  `passwd` varchar(120) NOT NULL,
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_roles_idx` (`role`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
