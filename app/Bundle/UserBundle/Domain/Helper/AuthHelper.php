<?php
namespace Devture\Bundle\UserBundle\Helper;

use Devture\Component\DBAL\Exception\NotFound;
use Devture\Component\Form\Helper\StringHelper;
use Devture\Bundle\UserBundle\Repository\UserRepository;
use Devture\Bundle\UserBundle\Model\User;
use Devture\Bundle\OrganizationBundle\Model\Organization;

class AuthHelper {

	private $repository;
	private $encoder;
	private $passwordTokenSalt;

	public function __construct(UserRepository $repository, PasswordEncoder $encoder, $passwordTokenSalt) {
		$this->repository = $repository;
		$this->encoder = $encoder;
		$this->passwordTokenSalt = $passwordTokenSalt;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @return NULL|User
	 */
	public function authenticate($email, $password) {
		try {
			$user = $this->repository->findByEmail($email);
		} catch (NotFound $e) {
			return null;
		}
		if (!$this->isUserActive($user)) {
			return null;
		}
		if (!$this->isPasswordMatching($user, $password)) {
			return null;
		}
		return $user;
	}

	/**
	 * @param string $email
	 * @param string $passwordToken
	 * @return NULL|User
	 */
	public function authenticateWithToken($email, $passwordToken) {
		try {
			$user = $this->repository->findByEmail($email);
		} catch (NotFound $e) {
			return null;
		}
		if (!$this->isUserActive($user)) {
			return null;
		}
		if (!StringHelper::equals($this->createPasswordToken($user), $passwordToken)) {
			return null;
		}
		return $user;
	}

	public function createPasswordToken(User $user) {
		return hash('sha256', $this->passwordTokenSalt . $user->getPassword());
	}

	private function isPasswordMatching(User $user, $password) {
		if (strlen($password) > 4096) {
			//Do not pass very long passwords to the encoder. Computing a hash might be slow.
			//Just reject them outright.
			return false;
		}
		return $this->encoder->isPasswordValid($password, $user->getPassword());
	}

	private function isUserActive(User $entity) {
		if (!$entity->isActive()) {
			return false;
		}

		if ($entity->getOrganization() instanceof Organization) {
			if (!$entity->getOrganization()->isActive()) {
				return false;
			}
		}

		return true;
	}

}
