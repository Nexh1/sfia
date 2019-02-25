<?php

namespace App\Repository;

use App\Entity\Entreprises;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entreprises|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprises|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprises[]    findAll()
 * @method Entreprises[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntreprisesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entreprises::class);
    }

    public function findSearch($value) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
                ->from($this->_entityName, 'a')
                ->where('a.* LIKE :value')
                ->orderBy('a.raisonSociale', 'DESC')
                ->setParameter(':value', '%"' . $value . '"%');               
        return $qb->getQuery()->getResult();
    }

    public function findBySecteur($value)  {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
           ->from($this->_entityName, 'a')
           ->where('a.secteursActivite LIKE :val')
           ->orderBy('a.raisonSociale', 'ASC')
           ->setParameter('val' , '%'.$value.'%');             
        return $qb->getQuery()->getResult();
    }

    public function findBySavoir($value)  {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
           ->from($this->_entityName, 'a')
           ->where('a.savoirFaireSearch LIKE :val')
           ->orderBy('a.raisonSociale', 'ASC')
           ->setParameter('val' , '%'.$value.'%');              
        return $qb->getQuery()->getResult();
    }

    public function findAllSearch($search, $export = '',$qualite = '', $limit = null, $offset = 0 ): array 
    {
        // if the field match the value
        $qb = $this->createQueryBuilder('e')                         
                   ->orWhere('e.raisonSociale LIKE :val')
                   ->orWhere('e.codePostal LIKE :val')
                   ->orWhere('e.ville LIKE :val')
                   ->orWhere('e.formeJuridique LIKE :val')
                   ->orWhere('e.equipements LIKE :val')
                   ->orWhere('e.qualite LIKE :val')
                   ->orWhere('e.manutention LIKE :val')
                   ->orWhere('e.referencesClients LIKE :val')
                   ->orWhere('e.pointFort LIKE :val')
                   ->orWhere('e.siret LIKE :val')
                   ->orWhere('e.savoirFaire LIKE :val')
                   ->orWhere('e.savoirFaireSearch LIKE :val')
                   ->orWhere('e.secteursActivite LIKE :val')
                   ->orWhere('e.environnement LIKE :val')
                   ->orWhere('e.referencesClients LIKE :val');    
        //  if export and qualite are checked
        if($export == 1 && $qualite == 1) {
            $qb->andWhere('e.export = 1')
               ->andWhere('e.qualiteAgrement = 1');
        }   
        // if export is checked
        if($export == 1) {
            $qb->andWhere('e.export = 1');
        }   
        // if qualite is checked
        if($qualite == 1) {
            $qb->andWhere('e.qualiteAgrement = 1');
        }   
        // set val egal to $search, set the offset, the limit 
        // and order by entreprise name
        $qb->orderBy('e.raisonSociale', 'ASC')   
           ->setFirstResult($offset) 
           ->setMaxResults($limit)
           ->setParameters(array('val'=> '%'.$search.'%'));
        return $qb->getQuery()->getResult();                      
    }

    public function findByAlphabet() {
        $qb = $this->createQueryBuilder('a')
                   ->orderBy('a.raisonSociale', 'ASC');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findLast5()
    {
        $qb = $this->createQueryBuilder('a')
                   ->orderBy('a.id', 'DESC')
                   ->setMaxResults(5);
        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findByUpdate() {
        $qb = $this->createQueryBuilder('a')
        
            ->orderBy('a.updatedAt', 'ASC');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    // public function findBySecteur($value, $where1 = null, $where2 = null, $where3 = null)  {
    //     $qb = $this->_em->createQueryBuilder();
    //     $qb->select('a')
    //        ->from($this->_entityName, 'a')
    //        ->leftJoin('a.secteurActivite','b')
    //        ->where('b.nom = ?1')
    //        ->andwhere('a.export = ?2')
    //        ->andwhere('a.qualite = ?3')
    //        ->andwhere('a.icpe = ?4')
    //        ->orderBy('a.raisonSociale', 'ASC')
    //        ->setParameters(array(1 => $value, 2 => $where1, 3 => $where2, 4 => $where3));             
    //     return $qb->getQuery()->getResult();
    // }

//    /**
//     * @return Entreprises[] Returns an array of Entreprises objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entreprises
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
