<?php

namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use User\Entity\UserInterface as User;

class AccountDisplay extends AbstractHelper {

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * __invoke
     *
     * @access public
     * @param \User\Entity\UserInterface $user
     * @throws \User\Exception\DomainException
     * @return String
     */
    public function __invoke(User $user = null) {

        if (null === $user) {
            if ($this->getAuthService()->hasIdentity()) {
                $user = $this->getAuthService()->getIdentity();
                /*
                  if (!$user instanceof User) {
                  throw new \ZfcUser\Exception\DomainException(
                  '$user is not an instance of User',
                  500
                  );
                  }
                 * 
                 */
            } else {
                return false;
            }
        }

        $displayName = $user->getDisplayName();
        $userName = $user->getUsername();
        $email = $user->getEmail();
        $street = $user->getStreet();
        $plz = $user->getPlz();
        $village = $user->getVillage();
        $phone = $user->getPhone();
        $role = $user->getRoles();

        $data = array('displayname' => $displayName,
            'username' => $userName,
            'email' => $email,
            'street' => $street,
            'plz' => $plz,
            'village' => $village,
            'phone' => $phone);

        if (null === $displayName) {
            $displayName = $user->getUsername();
        }
        // User will always have an email, so we do not have to throw error
        if (null === $displayName) {
            $displayName = $user->getEmail();
            $displayName = substr($displayName, 0, strpos($displayName, '@'));
        }
        return $data;
    }

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService() {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     * @return \ZfcUser\View\Helper\ZfcUserDisplayName
     */
    public function setAuthService(AuthenticationService $authService) {
        $this->authService = $authService;
        return $this;
    }

}
