<?php

namespace User\Options;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

/**
 * Description of ModuleOptionsInterface
 * Interface for specific Create Options for Users
 * But we dont realy need it at the time.
 */
interface UserCreateOptionsInterface {

    /**
     * get Create User AutoPassword
     *
     * @return Boolean
     */
    public function getCreateUserAutoPassword();

    /**
     * set Create User AutoPassword
     *
     * @param Boolean
     */
    public function setCreateUserAutoPassword($createUserAutoPassword);

    /**
     * Get Create Form Elements
     * for foreach Form Element 
     * @return Array
     */
    public function getCreateFormElements();

    /**
     * set Create Form Elements
     * for foreach Form Element 
     * @Param Array
     */
    public function setCreateFormElements(array $elements);
}
