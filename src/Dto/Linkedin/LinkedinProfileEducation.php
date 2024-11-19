<?php

namespace App\Dto\Linkedin;

use Symfony\Component\Serializer\Attribute\SerializedName;

class LinkedinProfileEducation
{
    #[SerializedName("schoolName")]
    public ?string $schoolName = null;

    #[SerializedName("fieldOfStudy")]
    public ?string $fieldOfStudy = null;

    #[SerializedName("description")]
    public ?string $description = null;

    #[SerializedName("url")]
    public ?string $url = null;

    #[SerializedName("degree")]
    public ?string $degree = null;

    #[SerializedName("start")]
    public array $start = [];

    #[SerializedName("end")]
    public array $end = [];

    public function toArray(): array
    {
        return [
            'schoolName' => $this->schoolName,
            'fieldOfStudy' => $this->fieldOfStudy,
            'description' => $this->description,
            'url' => $this->url,
            'degree' => $this->degree,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }

    public function setSchoolName(?string $schoolName): LinkedinProfileEducation
    {
        $this->schoolName = $schoolName;
        return $this;
    }

    public function setFieldOfStudy(?string $fieldOfStudy): LinkedinProfileEducation
    {
        $this->fieldOfStudy = $fieldOfStudy;
        return $this;
    }

    public function setDescription(?string $description): LinkedinProfileEducation
    {
        $this->description = $description;
        return $this;
    }

    public function setUrl(?string $url): LinkedinProfileEducation
    {
        $this->url = $url;
        return $this;
    }

    public function setDegree(?string $degree): LinkedinProfileEducation
    {
        $this->degree = $degree;
        return $this;
    }

    public function setStart(array $start): LinkedinProfileEducation
    {
        $this->start = $start;
        return $this;
    }

    public function setEnd(array $end): LinkedinProfileEducation
    {
        $this->end = $end;
        return $this;
    }
}