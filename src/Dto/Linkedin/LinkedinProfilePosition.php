<?php

namespace App\Dto\Linkedin;

use Symfony\Component\Serializer\Attribute\SerializedName;

class LinkedinProfilePosition
{
    #[SerializedName("companyName")]
    public ?string $companyName = null;

    #[SerializedName("companyUsername")]
    public ?string $companyUsername = null;

    #[SerializedName("companyURL")]
    public ?string $companyURL = null;

    #[SerializedName("companyLogo")]
    public ?string $companyLogo = null;

    #[SerializedName("companyIndustry")]
    public ?string $companyIndustry = null;

    #[SerializedName("companyStaffCountRange")]
    public ?string $companyStaffCountRange = null;

    #[SerializedName("title")]
    public ?string $title = null;

    #[SerializedName("location")]
    public ?string $location = null;

    #[SerializedName("description")]
    public ?string $description = null;

    #[SerializedName("employmentType")]
    public ?string $employmentType = null;

    #[SerializedName("start")]
    public array $start = [];

    #[SerializedName("end")]
    public array $end = [];

    public function toArray(): array
    {
        return [
            'companyName' => $this->companyName,
            'companyUsername' => $this->companyUsername,
            'companyURL' => $this->companyURL,
            'companyLogo' => $this->companyLogo,
            'companyIndustry' => $this->companyIndustry,
            'companyStaffCountRange' => $this->companyStaffCountRange,
            'title' => $this->title,
            'location' => $this->location,
            'description' => $this->description,
            'employmentType' => $this->employmentType,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }

    public function setCompanyName(?string $companyName): LinkedinProfilePosition
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function setCompanyUsername(?string $companyUsername): LinkedinProfilePosition
    {
        $this->companyUsername = $companyUsername;
        return $this;
    }

    public function setCompanyURL(?string $companyURL): LinkedinProfilePosition
    {
        $this->companyURL = $companyURL;
        return $this;
    }

    public function setCompanyLogo(?string $companyLogo): LinkedinProfilePosition
    {
        $this->companyLogo = $companyLogo;
        return $this;
    }

    public function setCompanyIndustry(?string $companyIndustry): LinkedinProfilePosition
    {
        $this->companyIndustry = $companyIndustry;
        return $this;
    }

    public function setCompanyStaffCountRange(?string $companyStaffCountRange): LinkedinProfilePosition
    {
        $this->companyStaffCountRange = $companyStaffCountRange;
        return $this;
    }

    public function setTitle(?string $title): LinkedinProfilePosition
    {
        $this->title = $title;
        return $this;
    }

    public function setLocation(?string $location): LinkedinProfilePosition
    {
        $this->location = $location;
        return $this;
    }

    public function setDescription(?string $description): LinkedinProfilePosition
    {
        $this->description = $description;
        return $this;
    }

    public function setEmploymentType(?string $employmentType): LinkedinProfilePosition
    {
        $this->employmentType = $employmentType;
        return $this;
    }

    public function setStart(array $start): LinkedinProfilePosition
    {
        $this->start = $start;
        return $this;
    }

    public function setEnd(array $end): LinkedinProfilePosition
    {
        $this->end = $end;
        return $this;
    }
}