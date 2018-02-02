create database if not exists phone_book;
use phone_book;
drop table if exists book ;
create table if not exists book (
id int not null AUTO_INCREMENT,
name varchar(255) not null,
phoneNumber varchar(20) not null unique,
email varchar(255) default '',
primary key(id, phoneNumber)
);


insert into book (name, phoneNumber, email) values ('John', '0521112222', 'john@gmail.com');
insert into book (name, phoneNumber, email) values ('Jack', '0521113333', 'jack@gmail.com');
insert into book (name, phoneNumber, email) values ('Smith', '0521114444', 'smith@gmail.com');
insert into book (name, phoneNumber, email) values ('David', '0521115555', 'david@gmail.com');
insert into book (name, phoneNumber, email) values ('Jimmy', '0521116666', 'jimmy@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521117777', 'emma@gmail.com');
insert into book (name, phoneNumber, email) values ('Smith', '0521118888', 'smith2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119999', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119991', 'emma3@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119992', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119993', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119994', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119995', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119996', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119997', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119998', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119911', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119912', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119913', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119914', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119915', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119922', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119923', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119924', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119925', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119926', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119987', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119977', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119967', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119957', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119947', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119937', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119927', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119297', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119197', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119397', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119497', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119597', 'emma2@gmail.com');
insert into book (name, phoneNumber, email) values ('Emma', '0521119697', 'emma2@gmail.com');
