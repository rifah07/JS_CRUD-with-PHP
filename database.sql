CREATE DATABASE misc DEFAULT CHARACTER SET utf8;
USE misc;
CREATE TABLE users (
    user_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(128),
    email VARCHAR(128),
    password VARCHAR(128),
    PRIMARY KEY(user_id),
    INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE Profile (
    profile_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    first_name TEXT,
    last_name TEXT,
    email TEXT,
    headline TEXT,
    summary TEXT,
    PRIMARY KEY(profile_id),
    CONSTRAINT profile_ibfk_2 FOREIGN KEY (user_id)
        REFERENCES users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO users (name,email,password)
VALUES ('Chuck','csev@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1'),
       ('UMSI','umsi@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');