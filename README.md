
1) Add Repo from Guithub. 

2) Run Composer install/update.


3) Doctrine create Database)

    doctrine-module orm:validate-schema
    doctrine-module orm:schema-tool:create


4)insert to  Role TB)

    INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (1, NULL, 'guest');
    INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (2, 1, 'user');
    INSERT INTO `role` (`id`, `parent_id`, `roleId`) VALUES (3, 2, 'admin');

5) enable--> fileinfo,gd in php.ini