<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function delete(self $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function findOneByCriteria(array $criteria): ?object
    {
        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($criteria as $key => $value) {
            $queryBuilder->andWhere("p.$key = :$key")
                ->setParameter($key, $value);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function update(object $entity, array $data): object
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }

            $method = 'add' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }
}