CREATE TABLE  roles  (
	 id  INT NOT NULL AUTO_INCREMENT,
	 name  varchar(255) DEFAULT 'user' NOT NULL,
	PRIMARY KEY ( id )
);

CREATE TABLE  users  (
	 id  INT NOT NULL AUTO_INCREMENT,
	 username  varchar(255) NOT NULL UNIQUE,
	 role  INT NOT NULL,
	 email  varchar(255) NOT NULL UNIQUE,
	 passwd  varchar(255) NOT NULL UNIQUE,
	 createdAt  DATETIME NOT NULL,
	PRIMARY KEY ( id )
);

CREATE TABLE  posts  (
	 id  INT NOT NULL AUTO_INCREMENT,
	 title  varchar(255) NOT NULL,
	 body  TEXT,
	 createdAt  DATETIME NOT NULL,
	 modifiedAt  DATETIME,
	 user  INT,
	PRIMARY KEY (id)
);



CREATE TABLE  tags  (
	 id  INT NOT NULL AUTO_INCREMENT,
	 name  varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE  posts_has_tags  (
	 post  INT NOT NULL,
	 tag  INT NOT NULL,
	PRIMARY KEY (post ,tag)
);

CREATE TABLE  comments  (
	 id  INT NOT NULL AUTO_INCREMENT,
	 comment  TEXT NOT NULL,
	 post  INT NOT NULL,
	 user  INT NOT NULL,
	PRIMARY KEY ( id )
);

ALTER TABLE  posts  ADD CONSTRAINT  posts_fk0  FOREIGN KEY (user) REFERENCES  users(id);

ALTER TABLE  users  ADD CONSTRAINT  users_fk0  FOREIGN KEY (role) REFERENCES  roles(id);

ALTER TABLE  posts_has_tags  ADD CONSTRAINT  posts_has_tags_fk0  FOREIGN KEY (post) REFERENCES  posts(id);

ALTER TABLE  posts_has_tags  ADD CONSTRAINT  posts_has_tags_fk1  FOREIGN KEY (tag) REFERENCES  tags(id);

ALTER TABLE  comments  ADD CONSTRAINT  comments_fk0  FOREIGN KEY (post) REFERENCES  posts(id);

ALTER TABLE  comments  ADD CONSTRAINT  comments_fk1  FOREIGN KEY (user) REFERENCES  users(id);
