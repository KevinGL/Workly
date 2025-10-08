<?php

namespace App\Repository;

use App\Entity\Candidacy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidacy>
 */
class CandidacyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidacy::class);
    }

    //    /**
    //     * @return Candidacy[] Returns an array of Candidacy objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Candidacy
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRelaunchesToday(): array
    {
        $tz = new \DateTimeZone('Europe/Paris');
        $start = (new \DateTimeImmutable('today', $tz))->setTime(0, 0, 0);
        $end = $start->modify('+1 day');

        return $this->createQueryBuilder('c')
            ->andWhere('c.toRelaunchAt >= :start')
            ->andWhere('c.toRelaunchAt < :end')
            ->andWhere("c.relaunchedAt IS NULL")
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}
