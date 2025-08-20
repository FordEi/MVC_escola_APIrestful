Drop schema if exists escola;
Create schema escola;
use escola;

Create Table tipo_usuario
(
	cd_tipo_usuario int, 
    nm_tipo_usuario varchar(100),
    constraint pk_tipo_usuario primary key (cd_tipo_usuario)
);

Create Table usuario
(
	nm_email varchar(200),
	nm_usuario varchar(200),
	nm_senha varchar(64),
    cd_tipo_usuario int,
    constraint pk_usuario primary key(nm_email),
    constraint fk_usuario_tipo_usuario foreign key (cd_tipo_usuario) 
		references tipo_usuario(cd_tipo_usuario)
);

Insert into tipo_usuario values (1, 'Administrador');
Insert into tipo_usuario values (2, 'Professor');
Insert into tipo_usuario values (3, 'Aluno');

Insert into usuario values ('marquinhos@etec.com', 'Marcos Augusto', md5('123'), 1);
Insert into usuario values ('freddy@etec.com', 'Freddy Justo', md5('123'),2);
Insert into usuario values ('chris@etec.com', 'Christiano Flexa', md5('123'), 2);
Insert into usuario values ('aluno1@etec.com', 'Aluno 1', md5('123'), 3);
Insert into usuario values ('aluno2@etec.com', 'Aluno 2', md5('123'), 3);
Insert into usuario values ('aluno3@etec.com', 'Aluno 3', md5('123'), 3);
Insert into usuario values ('aluno4@etec.com', 'Aluno 4', md5('123'), 3);