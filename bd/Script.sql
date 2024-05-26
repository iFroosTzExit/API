create schema logs;

create table logs.log_sistema (
	cod_log_sistema serial4 not null, 
	action varchar(30) not null, 
	controller varchar(30) not null, 
	module varchar(30) not null, 
	params text,
	data_cadastro timestamp not null default now(),
	constraint log_sistema_pk primary key (cod_log_sistema)
);

select * from logs.log_sistema ls;

insert into logs.log_sistema (action, controller, module, params) values ('action_teste_1', 'controller_teste_1', 'module_teste_1', 'params_teste_1');