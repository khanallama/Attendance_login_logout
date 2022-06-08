<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{

    #[Route(path: '/demo', name: 'demo')]
    public function UserData()
    {
        $user = $this->getUser();
        dd($user);

        return $this->render('demo.html.twig', ['users' => $user]);
    }

    // #[Route(path: '/demo1', name: 'demo1')]
    // public function User(UserRepository $userRepository, EntityManagerInterface $entityManagerInterface)
    // {

    //     $user = $userRepository->findOneBy(['id' => '5']);

    //     $attendance = new Attendance();
    //     $attendance->setUser($user);
    //     $attendance->setDate(new DateTimeImmutable());
    //     $attendance->setLoginAt(new DateTimeImmutable());
    //     $attendance->setLogoutAt(new DateTimeImmutable());

    //     $entityManagerInterface->persist($attendance);
    //     $entityManagerInterface->flush();

    //     // $encrypt = convert_uuencode($user);
    //     dd($attendance->getUser());

    //     return $this->render('demo.html.twig', ['users' => $user]);
    // }
}
