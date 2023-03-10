<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function findUsersWithArtist()
    {
      return $this->createQueryBuilder('u')
          ->leftJoin('u.id_artist', 'a')
          ->addSelect('a')
          ->getQuery()
          ->getResult();
    }

    public function unlinkArtist(int $id)
    {
      $user = $this->find($id);
      $user->setIdArtist(null);
      $this->save($user, true);
    }

    public function getByListIdArtist(array $list_id)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id_artist IN(:list_id)')
            ->setParameter('list_id', $list_id)
            ->getQuery()
            ->getResult();
    }

    public function getManagers()
    {
        $users = $this->createQueryBuilder('u')
        ->getQuery()
        ->getResult();

        $tab_id = [];

        foreach ($users as $key => $user) {
            if ( !in_array('ROLE_MANAGER', $user->getRoles()) ) {
                unset($users[$key]);
            } else {
                $tab_id[] = $user->getId();
            }
        }

        return $this->createQueryBuilder('u')
            ->andWhere('u.id IN(:list_id)')
            ->setParameter('list_id', $tab_id);
    }
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
