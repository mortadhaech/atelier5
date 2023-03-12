<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/{id}/Moyenne', name: 'classroom_Moyenne')]
    public function classroomAverage(Classroom $classroom, StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findBy(['classroom' => $classroom]);

        $average = array_reduce($students, function ($sum, $student) {
            return $sum + $student->getMoyenne();
        }, 0) / count($students);

        return $this->render('classrooms/Moyenne.html.twig', [
            'classroom' => $classroom,
            'average' => $average,
        ]);
    }
    #[Route('/redoublants_by_classroom', name: 'redoublants_by_classroom')]
    public function redoublantsByClassroom(): Response
    {
        $classroomRepository = $this->getDoctrine()->getRepository(Classroom::class);
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);
    
        $classrooms = $classroomRepository->findAll();
    
        $redoublantsByClassroom = [];
    
        foreach ($classrooms as $classroom) {
            $redoublants = $studentRepository->countRedoublantsByClassroom($classroom);
            $redoublantsByClassroom[$classroom->getId()] = $redoublants;
        }
    
        return $this->render('redoublants_by_classroom.html.twig', [
            'redoublantsByClassroom' => $redoublantsByClassroom,
        ]);
    }
    
}
