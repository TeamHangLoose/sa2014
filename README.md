CREATE TABLE `role` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`parent_id` INT(11) NULL DEFAULT NULL,
`roleId` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
PRIMARY KEY (`id`),
UNIQUE INDEX `UNIQ_57698A6AB8C2FD88` (`roleId`),
INDEX `IDX_57698A6A727ACA70` (`parent_id`),
CONSTRAINT `FK_57698A6A727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `role` (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4;


INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (1, NULL, 'guest');
INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (2, 1, 'user');
INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (3, 2, 'admin');


INSERT INTO role (id, parent_id, roleId) VALUES (1, NULL, 'guest'); INSERT INTO role (id, parent_id, roleId) VALUES (2, 1, 'user'); INSERT INTO role (id, parent_id, roleId) VALUES (3, 2, 'admin');

doctrine-module orm:schema-tool:create
doctrine-module orm:validate-schema