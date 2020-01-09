-- Firebird.sql
-- Esta É uma estrutura de testes, para que as funcionalidades possa ser testadas
--
-- v1.0.0

-- Tabela de usuários
create table users(
    id int not null,
    name varchar(45) not null,
    email varchar(60),
    constraint USERS_EMAIL_UNIQUE unique(email),
    constraint PK_USERS PRIMARY KEY (id)
);

COMMIT;

-- Realiza a criação de um generator para a tabela de usuários
CREATE GENERATOR GEN_USERS;
COMMIT;

-- Tabela de produtos
-- Esta tabela não possui um generator, o campo ID deve ser incrementado com o próximo número da sequencia
CREATE table products(
    id int not null,
    product_name varchar(60),
    price decimal(10, 2),
    constraint PK_PRODUCTS PRIMARY KEY (id)
);

COMMIT;