<?php

namespace App\Repository;

use App\Entity\SavoirFaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SavoirFaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavoirFaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavoirFaire[]    findAll()
 * @method SavoirFaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavoirFaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SavoirFaire::class);
    }

    public function findByAlphabet()
    {
        $qb = $this->createQueryBuilder('a')
                   ->orderBy('a.nomFr', 'ASC');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findByNomFr($name)
    {
        $qb = $this->createQueryBuilder('a')
                      ->where('a.nomFr == :val')
                      ->setParameter('val', '%'.$name.'%');

        $query = $qb->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return SavoirFaire[] Returns an array of SavoirFaire objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SavoirFaire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
