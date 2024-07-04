<?php
namespace Devture\Bundle\UserBundle\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Devture\Component\DBAL\Exception\NotFound;
use Devture\Bundle\UserBundle\Repository\UserRepository;

class ChangeUserPasswordCommand extends Command {

	private $container;

	public function __construct(\Pimple $container) {
		parent::__construct('devture-user:change-password');
		$this->container = $container;
	}

	protected function configure() {
		$this->addArgument('email', InputArgument::REQUIRED, 'The email of the user whose password to change.');
		$this->setDescription("Changes an existing user account's password.");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$email = $input->getArgument('email');

		$repository = $this->getRepository();

		try {
			$entity = $repository->findByEmail($email);
		} catch (NotFound $e) {
			$output->writeln(sprintf('Cannot find user: %s', $email));
			return 1;
		}

		$questionHelper = new QuestionHelper();

		$question = new Question(sprintf('<question>%s</question>: ', 'Enter a password:'));
		$question->setHidden(true);
		$password = $questionHelper->ask($input, $output, $question);

		$entity->setPassword($this->getPasswordEncoder()->encodePassword($password));

		$repository->update($entity);

		$output->writeln(sprintf('Password for user %s updated successfully.', $email));
	}

	/**
	 * @return UserRepository
	 */
	private function getRepository() {
		return $this->container['devture_user.repository'];
	}

	/**
	 * @return \Devture\Bundle\UserBundle\Helper\PasswordEncoder
	 */
	private function getPasswordEncoder() {
		return $this->container['devture_user.password_encoder'];
	}

}
