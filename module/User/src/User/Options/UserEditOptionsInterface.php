<?php
namespace User\Options;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
interface UserEditOptionsInterface
{
    public function getEditFormElements();

    public function setEditFormElements(array $elements);

    public function getAllowPasswordChange();

    public function setAdminPasswordChange($allowPasswordChange);
}
