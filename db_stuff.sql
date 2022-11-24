create database auth_site;

create table users (
	id integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
	email varchar(319) NOT NULL,
	pass varchar(255) NOT NULL,
	type enum("user", "admin", "prisoner") DEFAULT "prisoner"
);


-- ADMIN USER
INSERT INTO users(id, email, pass, type) VALUES (NULL,'admin@admin.fr','admin98',"admin");

-- BASIC USER
INSERT INTO users(id, email, pass, type) VALUES (NULL,'tomy@hotmail.fr','produskate89',"user");

-- PRSIONER USER
INSERT INTO users(id, email, pass) VALUES (NULL,'groscaca@merde.fr','mangemerde09');