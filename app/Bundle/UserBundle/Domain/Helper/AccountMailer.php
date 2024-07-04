<?php
namespace Devture\Bundle\UserBundle\Helper;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Devture\Bundle\AppBundle\Helper\MailSender;
use Devture\Bundle\UserBundle\Model\User;
use Devture\Bundle\EmailTemplateBundle\Helper\MessageCreator;

class AccountMailer {

	private $mailSender;
	private $messageCreator;
	private $urlGenerator;
	private $emailSenderName;
	private $emailSenderAddress;

	public function __construct(MailSender $mailSender, MessageCreator $messageCreator, UrlGeneratorInterface $urlGenerator, $emailSenderName, $emailSenderAddress) {
		$this->mailSender = $mailSender;
		$this->messageCreator = $messageCreator;
		$this->urlGenerator = $urlGenerator;
		$this->emailSenderName = $emailSenderName;
		$this->emailSenderAddress = $emailSenderAddress;
	}

	public function sendRecoveryRequestEmail(User $user) {
		$subjectData = array();
		$contentData = array(
			'user' => $user,
			'recovery_link' => $this->urlGenerator->generate('devture_user.user.recover', array(
				'email' => $user->getEmail(),
				'token' => $user->getRecoveryToken(),
			), true),
		);

		$message = $this->messageCreator->createMessage('user/password-recovery-request', $user->getLocaleKey(), $subjectData, $contentData);
		$message->setFrom(array($this->emailSenderAddress => $this->emailSenderName));
		$message->setTo(array($user->getEmail() => $user->getName()));
		$this->mailSender->send($message);
	}

}
