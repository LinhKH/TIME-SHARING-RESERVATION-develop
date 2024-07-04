<?php
namespace Devture\Bundle\UserBundle\Helper;

use Devture\Bundle\UserBundle\Model\User;

class AccessChecker {

	private $container;

	public function __construct(\Pimple $container) {
		$this->container = $container;
	}

	public function canUserImpersonateUser(User $actor, User $target) {
		$isAlreadyImpersonating = ($this->container['user_impersonated_by_email'] !== null);

		if ($isAlreadyImpersonating) {
			return false;
		}

		return $this->canUserModifyUser($actor, $target);
	}

	public function canUserManageUsers(User $actor) {
		if ($actor->getType() === User::TYPE_ADMIN) {
			return true;
		}

		if ($actor->getType() !== User::TYPE_ORGANIZATION_MEMBER) {
			return false;
		}

		return ($actor->hasRole(User::ROLE_USER_BUNDLE) || $actor->hasRole(User::ROLE_MASTER));
	}

	public function canUserModifyUserFiles(User $actor, User $target) {
		return $this->canUserModifyUser($actor, $target);
	}

	public function canUserManageConfiguration(User $actor) {
		return ($actor->getType() === User::TYPE_ADMIN);
	}

	public function canUserManageAllUsers(User $actor) {
		return ($actor->getType() === User::TYPE_ADMIN);
	}

	public function canUserManageUserWorkingGroups(User $actor, User $target) {
		if ($actor->getType() === User::TYPE_ADMIN) {
			return true;
		}
		if ($actor->getOrganization() !== $target->getOrganization()) {
			return false;
		}
		return ($actor->hasRole(User::ROLE_USER_BUNDLE) || $actor->hasRole(User::ROLE_MASTER));
	}

	public function canUserAddUsers(User $actor) {
		return ($actor->getType() === User::TYPE_ADMIN || $actor->getType() === User::TYPE_ORGANIZATION_MEMBER);
	}

	public function canUserModifyUser(User $actor, User $target) {
		if ($actor->getType() === User::TYPE_ADMIN) {
			return true;
		}

		if ($actor === $target) {
			return true;
		}

		if ($actor->getOrganization() !== $target->getOrganization()) {
			return false;
		}

		return ($actor->getType() === User::TYPE_ORGANIZATION_MEMBER);
	}

	public function canUserDeleteUser(User $actor, User $target) {
		if ($actor === $target) {
			return false;
		}

		if ($actor->getType() === User::TYPE_ADMIN) {
			return true;
		}

		if ($actor->getOrganization() !== $target->getOrganization()) {
			return false;
		}

		return ($actor->getType() === User::TYPE_ORGANIZATION_MEMBER);
	}

}
