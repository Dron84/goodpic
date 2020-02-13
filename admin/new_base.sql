
create table category (
id INT(6) auto_increment Primary key,
catname VARCHAR(255) not null,
tagid VARCHAR(255));

create table orders (
id INT(6) auto_increment Primary key,
email VARCHAR(255),
tel VARCHAR(15),
order_str VARCHAR(255));

CREATE TABLE user (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
nickname VARCHAR(30) NOT NULL,
email VARCHAR(50),
admin BOOLEAN NOT NULL DEFAULT FALSE,
reg_date TIMESTAMP,
pass VARCHAR(255) NOT NULL);

CREATE TABLE tags (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
tagname VARCHAR(30) NOT NULL
);

CREATE TABLE image (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
href VARCHAR(255) NOT NULL,
px250 BOOLEAN,
px1600 BOOLEAN,
folder VARCHAR(255) NOT NULL,
size VARCHAR(30) NOT NULL,
tag_id TEXT,
reg_date TIMESTAMP,
comment VARCHAR(255) NOT NULL,
price VARCHAR(255) '100'
);

CREATE TABLE pages(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
reg_date TIMESTAMP,
description TEXT,
keywords TEXT,
title TEXT,
content TEXT
);


insert into tags (tagname) values('Города');
insert into tags (tagname) values('Улочки');
insert into tags (tagname) values('Цветы');
insert into tags (tagname) values('Природа');
insert into tags (tagname) values('Текстуры');
insert into tags (tagname) values('Фоны');
insert into tags (tagname) values('Разное');
insert into tags (tagname) values('Животные');
insert into tags (tagname) values('Птицы');
insert into tags (tagname) values('Еда');
insert into tags (tagname) values('Напитки');
insert into tags (tagname) values('Лёд');
insert into tags (tagname) values('Вино');
insert into tags (tagname) values('Вода');
insert into tags (tagname) values('Векторные');
insert into tags (tagname) values('Кофе');
insert into tags (tagname) values('Фрукты');
insert into tags (tagname) values('Транспорт');
insert into tags (tagname) values('Космос');
insert into tags (tagname) values('Живопись');
insert into tags (tagname) values('Ретро');
insert into tags (tagname) values('Авторские');
insert into tags (tagname) values('Детские');
insert into tags (tagname) values('Море');
insert into tags (tagname) values('Подводные жители');

insert into category (catname) values('Скинали');
insert into category (catname) values('Фрески');
insert into category (catname) values('Пескоструйные рисунки');
