<?php
namespace Devture\Bundle\UserBundle\Helper;

use Devture\Bundle\UserBundle\Repository\UserRepository;
use Devture\Bundle\UserBundle\Model\User;


class RecoveryRequestProcessor {

	private $repository;
	private $accountMailer;

	public function __construct(UserRepository $repository, AccountMailer $accountMailer) {
		$this->repository = $repository;
		$this->accountMailer = $accountMailer;
	}

	public function process(User $user) {

		$user->setRecoveryToken(bin2hex(openssl_random_pseudo_bytes(24)));
		$this->repository->update($user);

		$this->accountMailer->sendRecoveryRequestEmail($user);

		return true;
	}

}
