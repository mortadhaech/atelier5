<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClassroomRepository;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/ListEtudiant', name: 'ListEtudiant')]
    public function search(StudentRepository $studentRepository, Request $request, ClassroomRepository $classroomRepository): Response
    {
        $search = $request->query->get('nsc');
        $classe = $request->query->get('classe');
    
        if ($search) {
            $students = $studentRepository->findBy(['NSC' => $search]);
    
        } elseif ($classe) {
            $classroom = $classroomRepository->findOneBy(['name' => $classe]);
            $students = $classroom->getStudentsClass()->toArray();
        } else {
            $students = $studentRepository->findAllOrderedByEmail();
        }
        
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }
    #[Route('/Last3Days', name: 'Last3Days')]
public function lastInscription(StudentRepository $studentRepository, Request $request, ClassroomRepository $classroomRepository): Response
{

        $students = $studentRepository->findLatestStudents();
    

    return $this->render('student/Days.html.twig', [
        'students' => $students,
    ]);
}

#[Route('/students_enabled', name: 'students_enabled')]
public function enabledStudents(StudentRepository $studentRepository): Response
{
    $students = $this->getDoctrine()
        ->getRepository(Student::class)
        ->findBy(['enabled' => true]);

    return $this->render('student/enabled.html.twig', [
        'students' => $students,
    ]);
}
    
#[Route('/students_between_dates', name: 'students_between_dates')]
public function studentsBetweenDates(EntityManagerInterface $entityManager): Response
{
    $query = $entityManager->createQuery(
        'SELECT s
        FROM App\Entity\Student s
        WHERE s.birthdate BETWEEN :start_date AND :end_date'
    )
    ->setParameter('start_date', '2000-11-02')
    ->setParameter('end_date', '2002-11-02');

    $students = $query->getResult();

    return $this->render('students/between_dates.html.twig', [
        'students' => $students,
    ]);
}
#[Route('/searchMoyenne', name: 'searchMoyenne')]
public function searchMoyenne(Request $request, StudentRepository $studentRepository): Response
{
    $minMoyenne = $request->query->get('minMoyenne');
    $maxMoyenne = $request->query->get('maxMoyenne');

    $students = $studentRepository->findByMoyenne($minMoyenne, $maxMoyenne);

    return $this->render('student/searchMoyenne.html.twig', [
        'students' => $students,
    ]);
}

    
}
