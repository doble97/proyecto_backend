drop database if exists kario;
create database kario;
use kario;

create table users(id int primary key auto_increment, name varchar(100),
email varchar(100) unique, password varchar(250), last_name varchar(50));
create table friends(fk_user_send_request int,fk_user_receive_request int, FOREIGN KEY fk_user_send_request REFERENCES users(id),
FOREIGN KEY fk_user_receive_request REFERENCES users(id), PRIMARY KEY(fk_user_send_request, fk_user_receive_request));

create table languages(id int primary key auto_increment, name varchar(30), initials varchar(2));

create table decks(id int primary key auto_increment, name varchar(100), fk_languages int, FOREIGN KEY (fk_languages) REFERENCES languages(id));

create table deck_owners(fk_user int, fk_deck int, FOREIGN KEY (fk_user) REFERENCES users(id),
FOREIGN KEY (fk_deck) REFERENCES decks(id));

create table deck_collaborators(fk_user int, fk_deck int, FOREIGN KEY (fk_user) REFERENCES users(id),
FOREIGN KEY (fk_deck) REFERENCES decks(id));

create table words(name varchar(85) primary key);

CREATE TABLE decks_words (
    id int primary key auto_increment,
    fk_word varchar(85),
    fk_translation varchar(85),
    fk_deck INT,
    FOREIGN KEY (fk_word) REFERENCES words(name),
    FOREIGN KEY (fk_translation) REFERENCES words(name),
    FOREIGN KEY (fk_deck) REFERENCES decks(id)
);

CREATE TABLE phrases (
    id INT PRIMARY KEY AUTO_INCREMENT,
    text VARCHAR(255),
    translation varchar(255)
);

CREATE TABLE phrases_decks_words(
    fk_phrases int,
    fk_decks_words int,
    FOREIGN KEY (fk_phrases) REFERENCES phrases(id),
    FOREIGN KEY (fk_decks_words) REFERENCES decks_words(id),
    PRIMARY KEY(fk_phrases,fk_decks_words)
);