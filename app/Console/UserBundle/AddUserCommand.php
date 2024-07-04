<?php
namespace Devture\Bundle\UserBundle\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Devture\Component\DBAL\Exception\NotFound;
use Devture\Bundle\UserBundle\Model\User;
use Devture\Bundle\UserBundle\Repository\UserRepository;

class AddUserCommand extends Command {

	private $container;

	public function __construct(\Pimple $container) {
		parent::__construct('devture-user:add');
		$this->container = $container;
	}

	protected function configure() {
		$this->addArgument('email', InputArgument::REQUIRED, 'The email address of the new account.');
		$this->setDescription('Adds a new user account (with full privileges).');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$email = $input->getArgument('email');

		$repository = new UserRepository();

		try {
			$repository->findByEmail($email);
			$output->writeln(sprintf('A user with the email %s already exists.', $email));
			return 1;
		} catch (NotFound $e) {

		}

		/* @var $entity User */
		$entity = $repository->createModel(array());
		$entity->setActive(true);
		$entity->setEmail($email);
		$entity->setFirstNameFurigana(' ');
		$entity->setLastNameFurigana(' ');
		$entity->setGender(' ');
		$entity->setLocaleKey('ja');

		$entity->setType(User::TYPE_ADMIN);

		$questionHelper = new QuestionHelper();

		$question = new Question(sprintf('<question>%s</question>: ', 'First name:'));
		$entity->setFirstName($questionHelper->ask($input, $output, $question));

		$question = new Question(sprintf('<question>%s</question>: ', 'Last name:'));
		$entity->setLastName($questionHelper->ask($input, $output, $question));

		$question = new Question(sprintf('<question>%s</question>: ', 'Enter a password:'));
		$question->setHidden(true);
		$password = $questionHelper->ask($input, $output, $question);
		$entity->setPassword($this->getPasswordEncoder()->encodePassword($password));

		$repository->add($entity);

		$output->writeln(sprintf('User %s added successfully.', $email));
	}
}
