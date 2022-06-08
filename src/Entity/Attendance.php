<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AttendanceController;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
#[ApiResource(
    collectionOperations:[
        'post' => [
            'method' => 'POST',
            'path' => '/attendances',
            'controller' => AttendanceController::class,
        ],
        ],
    itemOperations:[
                     "get"=>[
                         'method'=> 'GET',
                         'controller' => NotFoundAction::class,
                         'read' => false,
                         'output' => false,
                    ],
                 ],

    denormalizationContext:['groups' => ['attendance_write']]
)]
class Attendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $loginAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $logoutAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate():  ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLoginAt(): ?\DateTimeImmutable
    {
        return $this->loginAt;
    }

    public function setLoginAt(\DateTimeImmutable $loginAt): self
    {
        $this->loginAt = $loginAt;

        return $this;
    }

    public function getLogoutAt(): ?\DateTimeImmutable
    {
        return $this->logoutAt;
    }

    public function setLogoutAt(?\DateTimeImmutable $logoutAt): self
    {
        $this->logoutAt = $logoutAt;

        return $this;
    }
}
