create database jwt;
use jwt;

create table users(
	id int unsigned auto_increment primary key,
    firstname varchar(150),
    lastname varchar(150),
    email varchar(150) unique,
    password varchar(250),
    created_at datetime,
    modified timestamp
);

create table categorias(
	id int unsigned not null auto_increment primary key,
    id_ml varchar(10) not null unique,
    nome varchar(80) not null unique
);

create table subcategorias(
	id int unsigned not null auto_increment primary key,
    id_ml varchar(10) not null unique,
    nome varchar(80) not null,
    itens int,
    idcategoria int unsigned,
    constraint categoria_subcategoria foreign key(idcategoria) references categorias(id)
);