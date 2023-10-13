<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\Query\GetInactiveUsersEmails\GetUsersByIsActiveQuery;
use App\Core\User\Domain\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:get-inactive-users',
    description: 'Getting inactive users emails'
)]
class GetInactiveUsers extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->bus->dispatch(new GetUsersByIsActiveQuery());

        /** @var User $user */
        foreach ($users as $user) {
            $output->writeln($user->getEmail());
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
    }
}
