<?php

namespace App\Entity\Traits;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait UuidTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    #[Groups(['workspaces:full', 'social-accounts:full', 'create_posts', 'posts:full', 'workspace-invitation:full'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID, length: 36, unique: true)]
    #[ApiProperty(identifier: true)]
    #[Groups(['get_user', 'workspaces:full', 'social-accounts:full', 'create_posts', 'posts:full', 'workspace-invitation:full'])]
    private ?string $uuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}