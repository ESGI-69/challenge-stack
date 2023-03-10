<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPublicEventByDate($date): array
    {
        $qb = $this->createQueryBuilder('e')
        ->where("e.start_date >= :start AND e.start_date <= :end")
        ->andWhere('e.private = false')
        ->setParameter('start', $date->format('Y-m-d 00:00:00'))
        ->setParameter('end', $date->format('Y-m-d 23:59:59'))
        ->orderBy('e.start_date', 'ASC');    
        return $qb->getQuery()->getResult();
    }

    public function getPublicEventByDateRange($start, $end): array
    {
        $qb = $this->createQueryBuilder('e')
        ->where("e.start_date > :start AND e.start_date <= :end")
        ->andWhere('e.private = false')
        ->setParameter('start', $start->format('Y-m-d 23:59:59'))
        ->setParameter('end', $end->format('Y-m-d 23:59:59'))
        ->orderBy('e.start_date', 'ASC');    
        return $qb->getQuery()->getResult();
    }

    public function getPublicEventsBeforeDate($date): array
    {
        $qb = $this->createQueryBuilder('e')
        ->where("e.start_date < :date")
        ->andWhere('e.private = false')
        ->setParameter('date', $date->format('Y-m-d 00:00:00'))
        ->orderBy('e.start_date', 'ASC');    
        return $qb->getQuery()->getResult();
    }

    // function to get club (concertHall) of the event
    public function getClub($id): array
    {
        $qb = $this->createQueryBuilder('e')
        ->select('c.name')
        ->join('e.concertHall', 'c')
        ->where("e.id = :id")
        ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }
    
    public function findByLikeTitle($title): array
    {
        $qb = $this->createQueryBuilder('e')
        ->where("LOWER(e.title) LIKE LOWER(:title)")
        ->setParameter('title', '%'.$title.'%')
        ->orderBy('e.title', 'ASC');    
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
