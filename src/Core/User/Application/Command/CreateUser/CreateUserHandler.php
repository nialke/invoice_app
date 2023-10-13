<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Common\Mailer\MailerInterface;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $email = $command->email;
        $this->userRepository->save(new User($email));
        $this->userRepository->flush();

        $this->mailer->send(
            $email,
            'Konto zostało utworzone',
            'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
        );
    }
}
