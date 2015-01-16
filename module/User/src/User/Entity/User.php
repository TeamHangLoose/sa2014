<?php
namespace User\Entity;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class User implements UserInterface, ProviderInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $street;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $plz;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $village;
    
     /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $phone;
    
       /**
     * @var boolean
     * @ORM\Column(type="boolean",nullable=true)
     */
    protected $active;

    

    /**
     * @var int
     */
    protected $state;
  
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User\Entity\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * Initialies the roles variable.
     */
    public function __construct() {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id) {
        $this->id = (int) $id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state) {
        $this->state = $state;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRolesArray() {
        return $this->roles->getValues();
    }

    /**
     * Get role.
     *
     * @return ArrayCollection

     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    
    public function addRole($role) {
        $this->roles[] = $role;
    }

    function getStreet() {
        return $this->street;
    }

    function getPlz() {
        return $this->plz;
    }

    function getVillage() {
        return $this->village;
    }

    function setStreet($street) {
        $this->street = $street;
    }

    function setPlz($plz) {
        $this->plz = $plz;
    }

    function setVillage($village) {
        $this->village = $village;
    }
    function getActive() {
        return $this->active;
    }

    function setActive($active) {
        $this->active = $active;
    }
    function getPhone() {
        return $this->phone;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    /*   
  public function __toString() {
  return __CLASS__ . '@' . spl_object_hash($this);
}
*/

}
