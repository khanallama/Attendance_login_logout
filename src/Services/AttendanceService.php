<?php

namespace App\Services;

use App\Entity\Attendance;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AttendanceService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }
    public function login($date ,User $user) : Attendance
    {
        $attendance = new Attendance();
        $attendance->setUser($user);
        $attendance->setDate(new \DateTime($date));
        $attendance->setLoginAt(new \DateTimeImmutable($date));

        $this->entityManager->persist($attendance);
        $this->entityManager->flush();

        return $attendance;
    }

    public function logOut(Attendance $attendance , $date): Attendance
    {
        $attendance->setLogoutAt($date);
        $this->entityManager->flush();

        return $attendance;
    }
}
