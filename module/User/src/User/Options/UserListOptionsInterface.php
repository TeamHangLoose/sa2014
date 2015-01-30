<?php

namespace User\Options;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

/**
 * Description of ModuleOptionsInterface
 * Interface for specific List Options for Users
 */
interface UserListOptionsInterface {

    /**
     * set List Form Elements
     * for foreach Form Element 
     * @return Array
     */
    public function getUserListElements();

    /**
     * set List Form Elements
     * for foreach Form Element 
     * @Param Array
     */
    public function setUserListElements(array $elements);
}
