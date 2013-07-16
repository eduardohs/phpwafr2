<?php
// Identificador da aplicação
define("SYS_APL_NAME", "PHPWAFR2");

// Nome do sistema
define("SYS_TITLE", "Nome do Sistema");

// Conexão com o banco de dados
define("DB_CLASS",        "../inc/mysql.php"); // DEPRECATED **************************
define("DB_DATABASE",     "phpwafr"); // DEPRECATED **************************
define("DB_HOST",         "localhost"); // DEPRECATED **************************
define("DB_USER",         "root"); // DEPRECATED **************************
define("DB_PASSWORD",     "root"); // DEPRECATED **************************
define("DB_PERSISTENT",   false); // DEPRECATED **************************

define("DB_PDO_DSN", "mysql:host=localhost;dbname=phpwafr");
define("DB_PDO_USER", "root");
define("DB_PDO_PASSWORD", "root");

// Dados sobre a autenticação
define("AUTH_PRODUCAO",     true);
define("AUTH_SOE",          false); // Se utiliza ou não a autenticação SOE
define("AUTH_TABLE",		"usuario");
define("AUTH_ID",			"usuario_id");
define("AUTH_USERNAME",		"nome_usuario");
define("AUTH_PASSWORD",		"senha"); // DEPRECATED ********************
define("AUTH_LEVEL",		"nivel_acesso");
//define("AUTH_WHERE",		"AND ativo=1"); // DEPRECATED ********************
define("AUTH_WHERE",		"nome_usuario=:user AND senha=sha1(:password) AND ativo=1");

// Autenticação SOE, dados para login
define("SOE_URL_AUTENTICACAO", "http://soeweb.procergs/soe/jsp/soe_autentica.jsp");
define("SOE_URL_TROCASENHA", "");
define("SOE_SIGLA_SISTEMA", "SDN");
define("SOE_URL_FEEDBACK", "http://172.28.4.208/phpwafr2/soe/soe-controller.php?action=login");

// Dados sobre a janela de lookup
define("LOOKUP_MAX_REC", 300);
define("LOOKUP_FIELDSIZE", 40);
define("LOOKUP_IMAGE", "../img/icons/search_magnifier.png");
define("TRASH_IMAGE", "../img/icons/trash.png");

// Dados sobre a lista de dados
define("LISTA_QTDE_REGISTROS", 15); // DEPRECATED **************************

// Dashboard
define("SIS_DASHBOARD", "../templates/objeto-dashboard.php");

// Menu
define("SIS_MENU", "../custom/menu.php");
define("SIS_MENU_VERTICAL", true);

// Tema jQueryUI
define("SIS_TEMA_JQUERY","Aristo");
define("SIS_TABLETREADY", false);

// Galeria de imagens
define("GAL_THUMB_SIZE","96");
define("GAL_PATH","../upload/");
define("GAL_IMAGE_SIZE", 2 * 1024 * 1024);

