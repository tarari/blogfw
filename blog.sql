

-- -----------------------------------------------------
-- Table     . roles 
-- -----------------------------------------------------
DROP TABLE IF EXISTS roles ;

CREATE TABLE IF NOT EXISTS roles (
  id INT NOT NULL AUTO_INCREMENT,
  role VARCHAR(45) NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX role_UNIQUE (role ASC)  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table     . users 
-- -----------------------------------------------------
DROP TABLE IF EXISTS users ;

CREATE TABLE IF NOT EXISTS users  (
  id INT NOT NULL AUTO_INCREMENT,
   role  INT NOT NULL,
   username  VARCHAR(90) NOT NULL,
   email  VARCHAR(90) NOT NULL,
   passwd  VARCHAR(120) NOT NULL,
   createdAt  DATETIME NOT NULL,
  PRIMARY KEY ( id ),
  INDEX  fk_users_roles_idx  ( role  ASC)  ,
  UNIQUE INDEX  username_UNIQUE  ( username  ASC)  ,
  UNIQUE INDEX  email_UNIQUE  ( email  ASC)  ,
  CONSTRAINT  fk_users_roles 
    FOREIGN KEY ( role )
    REFERENCES  roles  ( id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table     . tags 
-- -----------------------------------------------------
DROP TABLE IF EXISTS  tags  ;

CREATE TABLE IF NOT EXISTS  tags  (
   id  INT NOT NULL AUTO_INCREMENT,
   name  VARCHAR(45) NOT NULL,
  PRIMARY KEY ( id ),
  UNIQUE INDEX  name_UNIQUE  ( name  ASC)  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table     . posts 
-- -----------------------------------------------------
DROP TABLE IF EXISTS  posts  ;

CREATE TABLE IF NOT EXISTS  posts  (
   id  INT NOT NULL AUTO_INCREMENT,
   editor  INT NOT NULL,
   title  VARCHAR(255) NOT NULL,
   body  TEXT(2048) NULL,
   createdAt  DATETIME NOT NULL,
   modifiedAt  DATETIME NULL,
  PRIMARY KEY ( id ),
  INDEX  fk_posts_users1_idx  ( editor  ASC)  ,
  CONSTRAINT  fk_posts_users1 
    FOREIGN KEY ( editor )
    REFERENCES  users  ( id )
    ON DELETE CASCADE 
    ON UPDATE CASCADE )
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table     . posts_has_tags 
-- -----------------------------------------------------
DROP TABLE IF EXISTS  posts_has_tags  ;

CREATE TABLE IF NOT EXISTS  posts_has_tags  (
   post  INT NOT NULL,
   tag  INT NOT NULL,
  PRIMARY KEY ( post ,  tag ),
  INDEX  fk_posts_has_tags_tags1_idx  ( tag  ASC)  ,
  INDEX  fk_posts_has_tags_posts1_idx  ( post  ASC)  ,
  CONSTRAINT  fk_posts_has_tags_posts1 
    FOREIGN KEY ( post )
    REFERENCES     . posts  ( id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT  fk_posts_has_tags_tags1 
    FOREIGN KEY ( tag )
    REFERENCES     . tags  ( id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table     . comments 
-- -----------------------------------------------------
DROP TABLE IF EXISTS  comments  ;

CREATE TABLE IF NOT EXISTS  comments  (
   id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   contents  TEXT NOT NULL,
   createdAt  DATETIME NOT NULL,
   editor  INT NOT NULL,
   posts_id  INT NOT NULL,
  INDEX  fk_comments_users1_idx  ( editor  ASC)  ,
  INDEX  fk_comments_posts1_idx  ( posts_id  ASC)  ,
  CONSTRAINT  fk_comments_users1 
    FOREIGN KEY ( editor )
    REFERENCES     . users  ( id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT  fk_comments_posts1 
    FOREIGN KEY ( posts_id )
    REFERENCES     . posts  ( id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- begin attached script 'script'

INSERT INTO roles(role) VALUES ('admin');
INSERT INTO roles(role) VALUES ('user');
INSERT INTO roles(role) VALUES ('system');



-- end attached script 'script'