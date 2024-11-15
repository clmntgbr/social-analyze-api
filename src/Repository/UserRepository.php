<?php

namespace App\Repository;

use App\Dto\UserRegister;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function update(User $entity, array $data): User
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
                if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    private function findByCriteria(array $criteria): ?User
    {
        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($criteria as $key => $value) {
            $queryBuilder->andWhere("p.$key = :$key")
                ->setParameter($key, $value);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function updateOrCreate(array $searchPayload, array $updatePayload): User
    {
        $account = $this->findByCriteria($searchPayload);
        if (!$account) {
            $account = new User();
        }

        $this->update($account, $updatePayload);
        return $account;
    }

    public function create(UserRegister $userRegister): User
    {
        $user = new User();
        $user
            ->setEmail($userRegister->email)
            ->setPlainPassword($userRegister->password);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }
}
