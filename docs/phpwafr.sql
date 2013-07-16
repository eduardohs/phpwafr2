# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.32-community-log
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-01-26 13:42:57
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for phpwafr
CREATE DATABASE IF NOT EXISTS `phpwafr` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `phpwafr`;


# Dumping structure for table phpwafr.departamento
CREATE TABLE IF NOT EXISTS `departamento` (
  `departamento_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome_departamento` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`departamento_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.departamento: 9 rows
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` (`departamento_id`, `nome_departamento`) VALUES
	(1, 'Informática'),
	(2, 'Financeiro'),
	(3, 'Compras'),
	(4, 'Faturamento'),
	(5, 'Marketing'),
	(6, 'Expedição'),
	(7, 'Protocolo'),
	(8, 'Comunicação'),
	(9, 'Garagem');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;


# Dumping structure for table phpwafr.gal_categoria
CREATE TABLE IF NOT EXISTS `gal_categoria` (
  `id_categoria` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_categoria` varchar(50) NOT NULL,
  `crop_w` int(10) unsigned DEFAULT NULL,
  `crop_h` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.gal_categoria: 3 rows
/*!40000 ALTER TABLE `gal_categoria` DISABLE KEYS */;
INSERT INTO `gal_categoria` (`id_categoria`, `txt_categoria`, `crop_w`, `crop_h`) VALUES
	(1, 'Notícias', 400, 300),
	(2, 'Portifólio', 600, 400),
	(3, 'Galeria', 300, 300);
/*!40000 ALTER TABLE `gal_categoria` ENABLE KEYS */;


# Dumping structure for table phpwafr.gal_imagem
CREATE TABLE IF NOT EXISTS `gal_imagem` (
  `id_imagem` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categoria` bigint(10) unsigned NOT NULL DEFAULT '0',
  `dth_cadastro` datetime NOT NULL,
  `nome_arquivo` varchar(250) NOT NULL,
  `titulo_imagem` varchar(200) NOT NULL,
  `tags` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_imagem`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.gal_imagem: 9 rows
/*!40000 ALTER TABLE `gal_imagem` DISABLE KEYS */;
INSERT INTO `gal_imagem` (`id_imagem`, `id_categoria`, `dth_cadastro`, `nome_arquivo`, `titulo_imagem`, `tags`) VALUES
	(14, 1, '2010-09-03 15:15:23', '20100903151523_4764.png', 'Teclado numérico', 'teclado'),
	(5, 1, '2010-09-02 11:14:58', '20100902111457_1907_l.jpg', 'Netbook EeePC', 'netbook'),
	(13, 1, '2010-09-03 14:05:00', '20100903140500_MarceloRezende.jpg', 'Foto Marcelo', NULL),
	(7, 2, '2010-09-02 11:17:54', '20100902111754_aguaviva.jpg', 'Água', 'water'),
	(12, 1, '2010-09-03 10:01:36', '20100903100136_DSC01382.JPG', 'Ginástica', NULL),
	(15, 1, '2010-09-03 15:17:40', '20100903151739_dharma_hd_background.jpg', 'Dharma', 'lost, simbolo'),
	(16, 1, '2010-09-08 09:01:01', '20100908090101_Project_RX_1_0_by_Cosmindesign.jpg', 'Teste', NULL),
	(17, 3, '2010-09-08 13:17:13', '20100908131713_200903120658-15511.jpg', 'Tequila Frozen', 'bebida'),
	(18, 1, '2010-09-08 14:40:59', '20100908144059_testando_sua_aplicacao.jpg', 'Teste de Impacto', 'teste');
/*!40000 ALTER TABLE `gal_imagem` ENABLE KEYS */;


# Dumping structure for table phpwafr.historico
CREATE TABLE IF NOT EXISTS `historico` (
  `historico_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data_cadastro` date NOT NULL DEFAULT '0000-00-00',
  `descricao` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`historico_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.historico: 26 rows
/*!40000 ALTER TABLE `historico` DISABLE KEYS */;
INSERT INTO `historico` (`historico_id`, `usuario_id`, `data_cadastro`, `descricao`) VALUES
	(1, 1, '2003-09-30', 'O usuário foi cadastrado no sistema'),
	(2, 1, '2003-10-16', 'O usuário alterou a senha teste adhg fkjasdj sjdgh fkjas gkdj fkjashgd fkjh askdf kjash dkfh aksdhg fkjah sdkfh aksf'),
	(3, 15, '2011-08-30', 'Teste de histórico'),
	(4, 15, '2011-08-18', 'Outro teste de histórico'),
	(5, 3, '2011-08-23', 'Histórico do Alex'),
	(6, 3, '2011-08-19', 'Mais um histórico do Alex'),
	(8, 6, '2011-08-22', 'wegwe sdrgs etw egr wertg wer tywertwer twert wet wer twer twer twet'),
	(9, 11, '2011-08-22', 'hgqggqhghqgg hq kjfqkjhf jkha dkjfaksghd fkjagsfkjash kdfh kash dkhfa kshdg fkhag skdf kash gdkf aksjdhg fkjgah skdfkash gdkf'),
	(10, 17, '2011-08-22', 'Exemplo de histórico relacionado com o registro do Mauro Valle'),
	(11, 18, '2011-08-22', 'Exemplo de histórico para o registro do Éverton'),
	(12, 1, '2011-08-31', 'Teste de popup abrindo num iframe'),
	(13, 14, '2011-08-31', 'teste de histórico usando popup com iframe'),
	(14, 4, '2011-09-01', 'Teste de histórico em janela popup criada com iframe dentro de uma div flutuante saupdsupoasdupo fdpoa pasudpo apou dpo'),
	(15, 4, '2011-09-02', 'Mais uma informação no histórico da Cristiane'),
	(16, 19, '2011-09-02', 'Texto de histórico'),
	(17, 20, '2011-09-02', 'teste de histórico do Dexter'),
	(18, 21, '2011-09-02', 'Retirou alguns medicamentos na farmácia'),
	(19, 22, '2011-09-02', 'deu um soco no Spock'),
	(20, 25, '2011-09-05', 'Histórico de Leonard McCoy'),
	(21, 26, '2011-09-05', 'Histórico de Darth Sidious'),
	(22, 23, '2011-09-09', 'Histórico de Anakin'),
	(23, 42, '2011-09-09', 'Histórico de Jello Biafra'),
	(24, 23, '2011-09-15', 'Lições de Palpatine'),
	(25, 31, '2011-09-29', 'Teste de histórico'),
	(27, 27, '2011-12-01', 'Outro teste de histórico'),
	(28, 60, '2012-01-20', 'Exemplo de registro 1:N com texto longo na descrição e mais bla bla bla');
/*!40000 ALTER TABLE `historico` ENABLE KEYS */;


# Dumping structure for table phpwafr.sistema
CREATE TABLE IF NOT EXISTS `sistema` (
  `sistema_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome_sistema` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`sistema_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.sistema: 10 rows
/*!40000 ALTER TABLE `sistema` DISABLE KEYS */;
INSERT INTO `sistema` (`sistema_id`, `nome_sistema`) VALUES
	(1, 'Controle de Pessoal'),
	(2, 'Controle de Treinamentos'),
	(3, 'Controle de Férias'),
	(4, 'Finanças'),
	(5, 'Controle de Estoque'),
	(6, 'Gestão de Benefícios'),
	(7, 'Controle de Biblioteca'),
	(9, 'Gestão de Documentos'),
	(12, 'Controle de Ponto'),
	(10, 'Correio Eletrônico');
/*!40000 ALTER TABLE `sistema` ENABLE KEYS */;


# Dumping structure for table phpwafr.sistema_usuario
CREATE TABLE IF NOT EXISTS `sistema_usuario` (
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sistema_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ordem_exibicao` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`usuario_id`,`sistema_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.sistema_usuario: 162 rows
/*!40000 ALTER TABLE `sistema_usuario` DISABLE KEYS */;
INSERT INTO `sistema_usuario` (`usuario_id`, `sistema_id`, `ordem_exibicao`) VALUES
	(41, 3, 0),
	(1, 4, 0),
	(1, 6, 0),
	(40, 10, 0),
	(3, 3, 0),
	(3, 1, 0),
	(3, 2, 0),
	(5, 7, 0),
	(5, 1, 0),
	(5, 2, 0),
	(15, 3, 0),
	(15, 2, 0),
	(15, 5, 0),
	(15, 1, 0),
	(6, 3, 0),
	(6, 1, 0),
	(6, 4, 0),
	(11, 1, 0),
	(11, 2, 0),
	(11, 5, 0),
	(11, 6, 0),
	(16, 1, 0),
	(16, 2, 0),
	(16, 6, 0),
	(17, 2, 0),
	(17, 5, 0),
	(17, 6, 0),
	(18, 7, 0),
	(18, 3, 0),
	(18, 1, 0),
	(18, 2, 0),
	(18, 5, 0),
	(18, 4, 0),
	(18, 6, 0),
	(14, 3, 0),
	(14, 1, 0),
	(14, 5, 0),
	(1, 9, 0),
	(1, 7, 0),
	(40, 3, 0),
	(40, 5, 0),
	(1, 10, 0),
	(1, 3, 0),
	(4, 2, 0),
	(4, 5, 0),
	(4, 10, 0),
	(19, 7, 0),
	(19, 5, 0),
	(19, 3, 0),
	(19, 1, 0),
	(19, 2, 0),
	(19, 10, 0),
	(19, 4, 0),
	(19, 6, 0),
	(19, 9, 0),
	(20, 5, 0),
	(20, 2, 0),
	(20, 10, 0),
	(21, 1, 0),
	(22, 3, 0),
	(25, 3, 0),
	(25, 2, 0),
	(25, 10, 0),
	(26, 3, 0),
	(26, 1, 0),
	(27, 3, 0),
	(27, 2, 0),
	(60, 7, 0),
	(28, 2, 0),
	(28, 6, 0),
	(29, 4, 0),
	(29, 9, 0),
	(30, 3, 0),
	(30, 1, 0),
	(30, 4, 0),
	(30, 6, 0),
	(30, 9, 0),
	(31, 3, 0),
	(31, 4, 0),
	(60, 2, 0),
	(32, 3, 0),
	(32, 1, 0),
	(32, 2, 0),
	(33, 3, 0),
	(33, 2, 0),
	(33, 10, 0),
	(33, 9, 0),
	(34, 7, 0),
	(34, 3, 0),
	(34, 1, 0),
	(34, 10, 0),
	(35, 7, 0),
	(35, 5, 0),
	(35, 1, 0),
	(35, 2, 0),
	(35, 4, 0),
	(35, 6, 0),
	(35, 9, 0),
	(36, 5, 0),
	(36, 1, 0),
	(36, 10, 0),
	(36, 4, 0),
	(37, 3, 0),
	(37, 2, 0),
	(37, 10, 0),
	(37, 4, 0),
	(37, 6, 0),
	(23, 7, 0),
	(23, 3, 0),
	(23, 1, 0),
	(23, 2, 0),
	(23, 10, 0),
	(26, 2, 0),
	(26, 10, 0),
	(26, 4, 0),
	(38, 5, 0),
	(38, 3, 0),
	(38, 4, 0),
	(41, 1, 0),
	(42, 2, 0),
	(42, 10, 0),
	(43, 7, 0),
	(43, 5, 0),
	(43, 3, 0),
	(43, 1, 0),
	(43, 2, 0),
	(43, 10, 0),
	(43, 4, 0),
	(43, 6, 0),
	(43, 9, 0),
	(45, 3, 0),
	(45, 2, 0),
	(45, 4, 0),
	(45, 6, 0),
	(46, 5, 0),
	(46, 1, 0),
	(46, 10, 0),
	(46, 9, 0),
	(47, 7, 0),
	(47, 1, 0),
	(47, 2, 0),
	(48, 1, 0),
	(48, 2, 0),
	(48, 10, 0),
	(6, 5, 0),
	(26, 7, 0),
	(26, 5, 0),
	(26, 9, 0),
	(31, 10, 0),
	(4, 4, 0),
	(4, 6, 0),
	(31, 9, 0),
	(27, 9, 0),
	(4, 3, 0),
	(31, 5, 0),
	(60, 12, 0),
	(27, 4, 0),
	(27, 7, 0),
	(60, 9, 0),
	(60, 3, 0),
	(60, 5, 0),
	(60, 10, 0);
/*!40000 ALTER TABLE `sistema_usuario` ENABLE KEYS */;


# Dumping structure for table phpwafr.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_cadastro` date NOT NULL DEFAULT '0000-00-00',
  `nome_usuario` varchar(50) NOT NULL DEFAULT '',
  `nome_real` varchar(100) NOT NULL DEFAULT '',
  `senha` varchar(64) NOT NULL DEFAULT '',
  `nivel_acesso` int(10) unsigned NOT NULL DEFAULT '1',
  `departamento_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `descricao` longtext,
  `ativo` int(10) unsigned NOT NULL DEFAULT '0',
  `tema` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

# Dumping data for table phpwafr.usuario: 47 rows
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`usuario_id`, `data_cadastro`, `nome_usuario`, `nome_real`, `senha`, `nivel_acesso`, `departamento_id`, `email`, `descricao`, `ativo`, `tema`) VALUES
	(1, '2011-08-17', 'admin', 'Administrador do Sistema', 'd033e22ae348aeb5660fc2140aec35850c4da997', 3, 1, 'admin@empresa.com.br', 'Usuário administrador do sistema. Teste de gravação de dados pelo dispositivo móvel', 1, 'yellow'),
	(2, '2003-10-01', 'joao', 'João da Silva', 'c510cd8607f92e1e09fd0b0d0d035c16d2428fa4', 1, 4, 'joao@silva.com', NULL, 1, NULL),
	(3, '2004-02-15', 'alex', 'Alex Kruger Miller', '60c6d277a8bd81de7fdde19201bf9c58a3df08f4', 2, 4, 'alexkruger@wafr.com.br', 'Usuário teste', 1, NULL),
	(4, '2003-10-01', 'cristiane', 'Cristiane da Silva', 'c569aa2aacef210b370751beee6ba1ea2e21dcce', 1, 1, 'cristiane@empresa.com.br', 'Usuário teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste', 1, NULL),
	(5, '2003-10-01', 'rasmus', 'Rasmus Lerdof', '7b49817170bc2f7a6c9e75f301615acb2a8ce671', 3, 1, 'rasmus@php.net', 'Usuário que ajudou na criação do phpFramework', 1, NULL),
	(6, '2003-10-01', 'augusto', 'Augusto Silveira Costa', 'e744497d655eb42e1a2842e8f6b57030bc310bec', 1, 5, 'augustobill@wafr.com', 'Teste de descrição bla bla bla', 1, NULL),
	(7, '2003-10-01', 'marcelo', 'Marcelo Rezende', '46ed215d4162eb1145147b7e6ffd66ea7891f172', 3, 1, 'zen@wafr.rs.gov.br', 'Carinha que fez o phpFramework', 1, NULL),
	(8, '2003-10-01', 'morpheus', 'Morpheus', 'aa26d7c557296a4e8d49b42c8615233a3443036d', 3, 7, 'morpheus@zion.net', NULL, 1, NULL),
	(11, '2004-03-16', 'mickey', 'Mickey Mouse', '1aa25ead3880825480b6c0197552d90eb5d48d23', 1, 3, 'mickey@waltdisney.com', 'Amigo do Pateta', 1, NULL),
	(12, '2004-03-16', 'tarantino', 'Quentin Tarantino', '4a02bac08ff1f7fd13d71789f0bf491c0c142812', 1, 2, 'qt@holywood.com', 'Louco que pensa que é cineasta', 0, NULL),
	(13, '2004-03-16', 'pjackson', 'Peter Jackson', '975ba50c73aa5cb30b995811d07ae0c824d80012', 2, 5, 'peter@middleearth.nz', NULL, 0, NULL),
	(14, '2004-03-17', 'cesar', 'Cesar Silveira', '8eee89c994b90ad49540aa5dcd839138c25e0c96', 1, 8, 'cesar@wafr.rs.gov.br', NULL, 1, NULL),
	(15, '2011-08-19', 'volnei', 'Volnei Locksmith', '52630007cfe1883018802d810ac6b7b47017b0e4', 1, 3, 'locksmith@email.com.br', 'Líder da equipe', 1, NULL),
	(16, '2011-08-22', 'obama', 'Barak Obama', 'b21e8f02ba90b5876780bcf1bf968440902c31b1', 1, 5, 'obama@whitehouse.gov', 'Descrição do registro do presidente Obama', 1, NULL),
	(17, '2011-08-22', 'mauro', 'Mauro Vale Verde', '68dfdb93cf897626ca2f1c35c9f9ceec7afe1066', 2, 7, 'maurovale@email.com.br', 'Descrição do Mauro Valle', 1, NULL),
	(18, '2011-08-22', 'everton', 'Everton Evernote', '72c5bde9f2a7248f53b0e9f9f237244a6aa8c131', 2, 6, 'everton@email.com.br', 'Exemplo de descrição para o registro do Everton', 1, NULL),
	(19, '2011-09-02', 'jobs', 'Steve Jobs', '3276a0b74a2c814358852c691ea8ea41bdb63170', 3, 5, 'jobs@apple.com', 'Esse é o cara', 1, NULL),
	(20, '2011-09-02', 'dexter', 'Dexter Morgan', 'fafd2a3379c1e45c45e50d1ed317411b446c4d55', 2, 6, 'dexter@sliceoflife.com', 'psicopata do ano', 1, NULL),
	(21, '2011-09-02', 'house', 'Gregory House', '3208d615eddc0e94dfb915e5b1cc36fe400b8970', 3, 7, 'house@hospital.com', 'Na dúvida, verifique se não tem lupus e aplique um antibiótico de amplo espectro', 1, NULL),
	(22, '2011-09-02', 'kirk', 'James Tiberius Kirk', '2992a1cead2c2ad6ca3af1a2079e5259c5b3ab34', 1, 8, 'kirk@enterprise.space', 'Capitão da nave enterprise', 1, NULL),
	(23, '2011-09-02', 'anakin', 'Anakin Skywalker', '7951276d108732f685ad39766351430a193de32d', 1, 6, 'anakin@deathstar.space', 'o cara é meio esquentado', 1, NULL),
	(24, '2011-09-02', 'kenobi', 'Obi-Wan Kenobi', 'd2520f7edeb61a711c6bddc512de878187b462a3', 1, 1, 'kenobi@jedi.com', 'Esse cara programa em JAVA', 1, NULL),
	(25, '2011-09-05', 'mccoy', 'Leonard McCoy', 'ee533cfd6b49f4537b826863546764d5c7531f01', 1, 3, 'leonard@enterprise.space', NULL, 0, NULL),
	(26, '2011-09-05', 'darthsidious', 'Darth Sidious', '796ae130a785fb8a3f5489fe36c26d7410f2e1c2', 2, 6, 'sidious@deathstar.space', NULL, 0, NULL),
	(27, '2011-09-05', 'amidala', 'Padme Amidala', '8b4ae8d6d01118bdf236bdfd6e14c33c9976d91d', 1, 4, 'amidala@tatooine.com', 'lkjas fjkas hdlfkj alskdj flkjas dlfj alksj dlfkj alskdj hflkja hsdlfkj halksjdh flkja hsldjkf lajs dljf lajsd lfjk alsjkd fljka lsdjk flajk hsdlfj lakjs dlfjk alsdj flja sldjf lajs dlfj alsjd flkja l', 1, NULL),
	(28, '2011-09-05', 'gandalf', 'Gandalf The White', 'c3f63ee769c8f251565e45cf724f6e4efaee0387', 3, 1, 'gandalf@istari.com', NULL, 1, NULL),
	(29, '2011-09-05', 'legolas', 'Legolas Greenleaf', '6782c83d789fb4920f2310f96071fcbed76d11f2', 2, 3, 'legolas@darkforest.com', NULL, 0, NULL),
	(30, '2011-09-05', 'frodo', 'Frodo Baggins', 'e6c8afe5cd121f1ebcd7153a1a24b1f5942bcaab', 2, 8, 'frodo@middleearth.com', NULL, 1, NULL),
	(31, '2011-09-05', 'aragorn', 'Aragorn Telcontar', 'c33cca9a845fe9862a64a12839ae6a480d78d79f', 2, 6, 'aragorn@isildur.com', NULL, 1, NULL),
	(32, '2011-09-05', 'will', 'Will Robinson', '0074e1211973b11d9cddef4eded252bebf48d549', 1, 4, 'will@jupiter.com', NULL, 0, NULL),
	(33, '2011-09-05', 'lotney', 'Lotney Fratelli', 'bbaa10ea232c80f45c3f62c1c2f2dd80a3b0684f', 1, 4, 'sloth@goonies.com', NULL, 1, NULL),
	(34, '2011-09-05', 'marty', 'Marty McFly', '2ba1a2233a4d2d9f1c3cf0c478d4d66ff15cddf2', 1, 4, 'marty@future.com', NULL, 0, NULL),
	(35, '2011-09-05', 'docbrown', 'Emmett Lathrop Brow', '05d477015330e0e543f7d9d9227b14d7bd7e3f5a', 3, 1, 'docbrow@delorean.com', NULL, 1, NULL),
	(36, '2011-09-05', 'neo', 'Thomas Anderson', '52db9057163f2b831a5452d895239a249597d1cc', 1, 3, 'neo@zion.com', NULL, 0, NULL),
	(37, '2011-09-05', 'mozart', 'Wolfgang Amadeus Mozart', '286b9b7b50ab89e3397b4df540021b531f457f7f', 2, 5, 'mozart@salzburg.com', NULL, 1, NULL),
	(38, '2011-09-06', 'marcus', 'Marcus Fenix', '247731c75f3b277594afe05f8b1d0ee049da0b08', 1, 6, 'fenix@deltasquad.com', NULL, 1, NULL),
	(39, '2011-09-08', 'sheldon', 'Sheldon Cooper', '0df5b32fdda8d9292b2816c3a2104c21861536ec', 1, 1, 'sheldon@calltech.com', NULL, 0, NULL),
	(40, '2011-09-08', 'leonard', 'Leonard Hofstadter', '1828f72b2bad7e3ece38a8c55b121b66ea999efd', 1, 1, 'leonard@calltech.com', NULL, 1, NULL),
	(41, '2011-09-08', 'rajesh', 'Rajesh Koothrappali', '308059d2078ba123c435ebf7d0f20d8f137330cf', 2, 8, 'rajesh@bbt.com', NULL, 1, NULL),
	(42, '2011-09-09', 'jello', 'Jello Biafra', '4016d58ad8fe89a8342b9436bea2cd4bb80bfc6f', 1, 2, 'jbiafra@alternativetentacles.com', NULL, 1, NULL),
	(43, '2011-09-12', 'tonystark', 'Anthony Edward Stark', '8f0479a7eb604eab6ffa35175fcf5ca21523f17d', 3, 6, 'tony@starkindustries.com', NULL, 1, NULL),
	(44, '2011-09-12', 'howard', 'Howard Robard Hughes', '3e23c5554d3d1d89c8a31b0d5221fde33c66040d', 1, 3, 'howard@billionaires.com', 'Descrição do Howard Robard Hughes', 1, NULL),
	(45, '2011-09-13', 'jason', 'Jason Voorhees', '143c4226ea0732d0479d83e5eb6e126e4597cd5f', 1, 6, 'jason@horrormovies.com', 'Jogador de hockey', 1, NULL),
	(46, '2011-09-13', 'freddy', 'Freddy Krueger', '5c8a7a129de8b649e9a0cbfbb7e9cec37a6efcb6', 2, 2, 'freddy@baddreams.com', 'Esse carinha usa um blusão legal', 1, NULL),
	(47, '2011-09-13', 'bruce', 'Bruce Wayne', 'cb4c0373f9c9cf764499edd8f875cae6f8948338', 1, 3, 'bruce@waynecorp.com', NULL, 0, NULL),
	(48, '2011-09-13', 'logan', 'James Logan Howlett', '42f2403dba1645a2f5ad6c702f40a996964dd4e6', 3, 2, 'logan@xweapon.com', NULL, 1, NULL),
	(60, '2011-12-22', 'AATeste', 'AATeste de Silva', '6552ec9555b409aa9bb17d8987b5c03cc573672e', 1, 4, 'teste@gmail.com', 'teste de seleção múltipla de sistemas com bastante texto na descrição para ver como fica na página de detalhe.', 1, NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
