CREATE TABLE IF NOT EXISTS `ps_custom_pet` (
  `id_pet` int(10) unsigned NOT NULL auto_increment,
  `id_customer` int(10) unsigned NOT NULL,
  `name` varchar(128) NULL,
  `breed` varchar(64) NULL,
  PRIMARY KEY (`id_pet`),
  KEY `id_customer` (`id_customer`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;