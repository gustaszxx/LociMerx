CREATE DATABASE Teste_sistema;
USE Teste_sistema;


CREATE TABLE empresa(
	id_empresa INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nm_empresa TEXT,
   cnpj_empresa VARCHAR(45),
   endereco_empresa TEXT,
   email_empresa TEXT,
   senha_empresa VARCHAR(64),
   telefone_empresa VARCHAR(11),
	descricao_empresa VARCHAR(45),
   contatovirtual_empresa VARCHAR(45),
   segmento_empresa VARCHAR(45)
	
);


CREATE TABLE produto(
	id_produto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nm_produto TEXT,
   descricao_produto VARCHAR(45),
   categoria_produto VARCHAR(45),
   preco_produto FLOAT,
   valor_produto FLOAT,
   codigo_produto INT,
   quantidade_produto INT,
   peso_medida_produto FLOAT,
   imagem_produto LONGBLOB NOT NULL,
   fabricante_produto VARCHAR(45),
   validade_produto DATE,
   composicao_produto VARCHAR(45),
   instrucao_produto VARCHAR(45),
   garantia_produto VARCHAR(45),
   tag_produto VARCHAR(45),
   id_empresa INT,
   FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa)
);


CREATE TABLE cliente(
	id_cliente INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nm_cliente VARCHAR(45),
   email_cliente VARCHAR(254),
   senha_cliente VARCHAR(64),
   cpf_cliente VARCHAR(14),
   endereco_cliente VARCHAR(45),
   telefone_cliente VARCHAR(45),
   data_cliente DATE
);

CREATE TABLE pedido(
	id_pedido INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   data_pedido DATE,
   id_empresa INT,
   id_cliente INT,
   id_produto INT,
   quantidade_pedido INT,
   endereco_pedido TEXT,
   data_envio_produto DATE,
   data_entrega_produto DATE,
   item_pedido TEXT,
   preco_pedido FLOAT,
   nmr_pedido INT,
   obs_pedido TEXT,
   total INT,
   preco_produto FLOAT,
   valor_produto FLOAT,
   FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
   FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa),
   FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

CREATE TABLE avaliacao(
	id_avalicao INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   comentario_avaliacao VARCHAR(256),
   id_produto INT,
   id_empresa INT,
   id_cliente INT,
   FOREIGN KEY (id_produto) REFERENCES produto(id_produto),
   FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa),
   FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

CREATE TABLE segmentos(
   id_segmento INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
   nome VARCHAR(100) NOT NULL,
   segmento_empresa VARCHAR(45),
   id_produto INT,
   id_empresa INT,
   identificador VARCHAR(50) NOT NULL
   FOREIGN KEY (id_empresa) REFERENCES empresa(id_empresa),
   FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

/*

CREATE TABLE pagamento(
   id_pagamento INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
   data_pagamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   valor_pagamento FLOAT NOT NULL,
   forma_pagamento ENUM('crédito', 'débito', 'pré-pago', 'pix', 'boleto'),
   status ENUM('pendente', 'concluído', 'cancelado', 'reembolsado') NOT NULL,
   id_pedido INT,
   id_cartao INT,
   id_pagamento_boleto INT,
   CONSTRAINT id_cartao FOREIGN KEY (id_cartao) REFERENCES cartao(id_cartao),
   CONSTRAINT id_pagamento_boleto FOREIGN KEY (id_pagamento_boleto) REFERENCES pagamentos_boleto(id_pagamento_boleto),
   CONSTRAINT id_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido)
);

CREATE TABLE pagamento_boleto (
   id_pagamento_boleto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   valor_pagamento_boleto FLOAT NOT NULL,
   data_pagamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   codigo_boleto VARCHAR(50) NOT NULL,
   data_vencimento DATE NOT NULL,
   status ENUM('pendente', 'pago', 'cancelado', 'vencido') NOT NULL,
   descricao TEXT,
   id_pedido INT NOT NULL,
   CONSTRAINT id_pedido FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido)
);

CREATE TABLE cartao (
   id_cartao INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   numero_cartao VARCHAR(20) NOT NULL,
   nome_titular VARCHAR(100) NOT NULL,
   data_validade DATE NOT NULL,
   codigo_seguranca INT(4) NOT NULL,
   tipo_cartao ENUM('crédito', 'débito', 'pré-pago') NOT NULL,
   data_emissao DATE,
   status ENUM('ativo', 'expirado', 'cancelado') NOT NULL,
   usuario_id INT NOT NULL,
   id_cliente INT,
   FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
   CONSTRAINT id_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

*/

SELECT * FROM cliente;

SELECT * FROM empresa;
