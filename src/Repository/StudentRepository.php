<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function save(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllOrderedByEmail()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.Email', 'ASC')
            ->getQuery()
            ->getResult();
            return $this->findBy([], ['creation_date' => 'DESC'], 3);

    }
    public function findByClasse($classe)
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.classrooms = :classe')
            ->setParameter('classe', $classe)
            ->orderBy('s.NSC', 'ASC');
    
        return $qb->getQuery()->execute();
    }
    public function findLatestStudents(int $count = 3): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.creation_date', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
    
    
    public function findByMoyenne($minMoyenne, $maxMoyenne)
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.moyenne BETWEEN :minMoyenne AND :maxMoyenne')
            ->setParameter('minMoyenne', $minMoyenne)
            ->setParameter('maxMoyenne', $maxMoyenne)
            ->orderBy('s.moyenne', 'DESC');
    
        return $qb->getQuery()->getResult();
    }
    

    

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
