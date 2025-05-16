create database if not exists wacdo;

use wacdo;

drop table users if exists;

create table
    users (
        id int primary key auto_increment,
        firstname varchar(30),
        lastname varchar(30),
        email varchar(100),
        password varchar(256),
        function varchar(15) default null,
        isConnected bool default false
    );

insert into
    users (firstname, lastname, email, password, function)
values
    (
        "Bruno",
        "FITTE",
        "bruno.fitte@sfr.fr",
        "Picsou12!",
        "ADMIN"
    );

create table
    reset_password (
        id int primary key auto_increment,
        email varchar(100),
        token varchar(100),
        time timestamp not null
    );

-- create table
--     menus (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     burgers (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     boissons (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     frites (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     encas (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     desserts (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     sauces (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     salades (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );
-- create table
--     wraps (
--         id int primary key auto_increment,
--         name varchar(50),
--         price decimal(4, 2),
--         image varchar(100)
--     );