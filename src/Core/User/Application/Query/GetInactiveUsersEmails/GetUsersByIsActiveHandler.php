<?php

namespace App\Core\User\Application\Query\GetInactiveUsersEmails;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersByIsActiveHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUsersByIsActiveQuery $query): array
    {
        return $this->userRepository->getByIsActive(false);
    }
}
