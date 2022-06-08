<?php

namespace App\Services;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(private EmailVerifier $emailVerifier,)
    {
    }

    public function email(User $authenticatedUserInfo, $todayDate): EmailVerifier
    {
        $this->emailVerifier->sendEmail(
            $authenticatedUserInfo,
            $todayDate,
            (new TemplatedEmail())
                ->from(new Address('khanallama@gmail.com', 'iqbal'))
                ->to('khanallama@gmail.com')
                ->subject('Click below button to note the login Time of Candidate')
                ->htmlTemplate('emailVerification/confirmation_email.html.twig')
        );

        return $this->emailVerifier;
    }
}
