<?php

namespace App\Repository;

use App\Entity\ConcertHall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConcertHall>
 *
 * @method ConcertHall|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcertHall|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcertHall[]    findAll()
 * @method ConcertHall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertHallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcertHall::class);
    }

    public function save(ConcertHall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConcertHall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTrendingConcertHalls($limit = 3): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c, COUNT(e.id) as eventCount')
            ->join('c.events', 'e')
             ->groupBy('c.id')
            ->orderBy('eventCount', 'DESC')
            ->setMaxResults($limit);

        $result = [];
        foreach ($qb->getQuery()->getResult() as $row) {
            $row[0]->eventCount = $row['eventCount'];
            $result[] = $row[0];
        }
        return $result;

    }

//    /**
//     * @return ConcertHall[] Returns an array of ConcertHall objects
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

//    public function findOneBySomeField($value): ?ConcertHall
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
