<?php

namespace User\Options;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

/**
 * Description of ModuleOptionsInterface
 * Interface for specific Edit Options for Users
 * But we dont realy need it at the time.
 */
interface UserEditOptionsInterface {

    /**
     * set Edit Form Elements
     * for foreach Form Element 
     * @return Array
     */
    public function getEditFormElements();

    /**
     * set Edit Form Elements
     * for foreach Form Element 
     * @Param Array
     */
    public function setEditFormElements(array $elements);

    /**
     * get Admin Password Change
     *
     * @param Boolean
     */
    public function getAllowPasswordChange();

    /**
     * set Admin Password Change
     *
     * @return Boolean
     */
    public function setAdminPasswordChange($allowPasswordChange);
}
