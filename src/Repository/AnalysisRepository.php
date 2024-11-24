<?php

namespace App\Repository;

use App\Entity\Analysis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Analysis>
 */
class AnalysisRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Analysis::class);
    }

    public function updateOrCreate(array $searchPayload, array $updatePayload): Analysis
    {
        $entity = $this->findOneByCriteria($searchPayload);
        if (!$entity) {
            $entity = new Analysis();
        }

        $this->update($entity, $updatePayload);
        return $entity;
    }

    public function create(array $updatePayload): Analysis
    {
        $entity = new Analysis();
        $this->update($entity, $updatePayload);
        return $entity;
    }
}
