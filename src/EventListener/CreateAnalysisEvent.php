<?php

namespace App\EventListener;

use App\Entity\Analysis;
use App\Entity\User;
use App\Message\CreateAnalysisMessage;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(event: Events::postPersist, priority: 0, connection: 'default')]
readonly class CreateAnalysisEvent
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {}

    #[NoReturn]
    public function postPersist(PostPersistEventArgs $event): void
    {
        $entity = $event->getObject();
        if (!$entity instanceof Analysis) {
            return;
        }

        $this->bus->dispatch(new CreateAnalysisMessage($entity->getUsername(), $entity->getPlatform()), [
            new AmqpStamp('high', AMQP_NOPARAM, []),
        ]);
    }
}