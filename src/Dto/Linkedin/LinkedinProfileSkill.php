<?php

namespace App\Dto\Linkedin;

use Symfony\Component\Serializer\Attribute\SerializedName;

class LinkedinProfileSkill
{
    #[SerializedName("name")]
    public string $name;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}