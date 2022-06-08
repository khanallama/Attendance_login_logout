<?php

namespace App\Controller;

use App\Entity\Attendance;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AttendanceRepository;
use App\Repository\UserRepository;
use App\Services\AttendanceService;
use App\Services\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceController extends AbstractController
{
    public function __construct(private AttendanceRepository $attendanceRepository, private AttendanceService $attendanceService, private UserRepository $userRepository, private EmailService $emailService)
    {
    }

    public function __invoke()
    {

        $authenticatedUser = $this->getUser();
        $todayDate = new \DateTimeImmutable();

        $isAlreadyLogin = $this->attendanceRepository->findOneBy(['date' => $todayDate, 'user' => $authenticatedUser->getId()]);

        if ($isAlreadyLogin instanceof Attendance) {
            $attendance = $this->attendanceService->logout($isAlreadyLogin, $todayDate);
        } else {
            $attendance = $this->emailService->email($authenticatedUser, $todayDate);
        }
        return $attendance;
    }


    #[Route(path: '/hr/verify', name: 'hrverifylogin')]
    public function hrVerifyUserLogin(Request $request): Response
    {
        $encryptedUserId = $request->request->get('userid');
        $decryptedUserId = base64_decode($encryptedUserId);
        $encryptedDate =  $request->request->get('date');
        $decryptedDate = base64_decode($encryptedDate);

        $user = $this->userRepository->findOneBy(['id' => $decryptedUserId]);

        $this->attendanceService->login($decryptedDate, $user);

        return $this->render('emailVerification/login_verified_succesfully.html.twig');
    }
}
