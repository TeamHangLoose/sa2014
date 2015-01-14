<?php
namespace User\Options;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
interface UserListOptionsInterface
{
    public function getUserListElements();

    public function setUserListElements(array $elements);
}
