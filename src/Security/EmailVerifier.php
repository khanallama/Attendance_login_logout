<?php

namespace App\Security;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailVerifier
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(UserInterface $authenticatedUser, $todayDate, TemplatedEmail $email): void
    {
        $authenticatedUserId = base64_encode($authenticatedUser->getId());
        $encryptedDate = base64_encode($todayDate->format('Y-m-d h:i:sa'));

        $context = $email->getContext();
        $context['encryptedDate'] = $encryptedDate;
        $context['date'] = $todayDate;
        $context['user'] = $authenticatedUser;
        $context['user_id'] = $authenticatedUserId;
        $email->context($context);

        $this->mailer->send($email);
    }
}
