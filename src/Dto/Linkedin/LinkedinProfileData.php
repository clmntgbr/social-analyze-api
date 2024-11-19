<?php

namespace App\Dto\Linkedin;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class LinkedinProfileData
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[SerializedName('id')]
    public int $linkedinId;

    public string $username;
    public string $firstName;
    public string $lastName;
    public ?string $headline = null;
    public ?string $summary = null;
    public ?string $backgroundImage = null;
    public ?string $profilePicture = null;
    public bool $isHiring = false;
    public bool $isOpenToWork = false;

    #[SerializedName("languages")]
    #[Assert\Valid]
    public array $languages = [];

    #[SerializedName("skills")]
    #[Assert\Valid]
    public array $skills = [];

    #[SerializedName("educations")]
    #[Assert\Valid]
    public array $educations = [];

    #[SerializedName("fullPositions")]
    #[Assert\Valid]
    public array $positions = [];

    public function toArray(): array
    {
        return [
            'linkedinId' => $this->linkedinId,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'headline' => $this->headline,
            'summary' => $this->summary,
            'backgroundImage' => $this->backgroundImage,
            'profilePicture' => $this->profilePicture,
            'isHiring' => $this->isHiring,
            'isOpenToWork' => $this->isOpenToWork,
            'languages' => $this->languagesToArray(),
            'skills' => $this->skillsToArray(),
            'educations' => $this->educationsToArray(),
            'positions' => $this->positionsToArray(),
        ];
    }

    public function languagesToArray(): array
    {
        return array_map(fn($position) => $position->toArray(), $this->languages);
    }

    public function skillsToArray(): array
    {
        return array_map(fn($position) => $position->toArray(), $this->skills);
    }

    public function educationsToArray(): array
    {
        return array_map(fn($position) => $position->toArray(), $this->educations);
    }

    public function positionsToArray(): array
    {
        return array_map(fn($position) => $position->toArray(), $this->positions);
    }

    public function setLanguages(array $languages): self
    {
        $this->languages = array_map(function($data) {
            $language = new LinkedinProfileLanguage();
            $language->setName($data['name']);
            return $language;
        }, $languages);
        return $this;
    }

    public function setSkills(array $skills): self
    {
        $this->skills = array_map(function($data) {
            $skill = new LinkedinProfileSkill();
            $skill->setName($data['name']);
            return $skill;
        }, $skills);
        return $this;
    }

    public function setEducations(array $languages): self
    {
        $this->educations = array_map(function($data) {
            $education = new LinkedinProfileEducation();
            $education->setEnd($data['end']);
            $education->setDegree($data['degree']);
            $education->setDescription($data['description']);
            $education->setUrl($data['url']);
            $education->setStart($data['start']);
            $education->setSchoolName($data['schoolName']);
            return $education;
        }, $languages);
        return $this;
    }

    public function setPositions(array $positions): self
    {
        $this->positions = array_map(function($data) {
            $position = new LinkedinProfilePosition();
            $position->setStart($data['start']);
            $position->setEnd($data['end']);
            $position->setTitle($data['title']);
            $position->setDescription($data['description']);
            $position->setCompanyIndustry($data['companyIndustry']);
            $position->setCompanyLogo($data['companyLogo']);
            $position->setCompanyName($data['companyName']);
            $position->setCompanyStaffCountRange($data['companyStaffCountRange']);
            $position->setCompanyURL($data['companyURL']);
            $position->setCompanyUsername($data['companyUsername']);
            $position->setLocation($data['location']);
            $position->setEmploymentType($data['employmentType']);
            return $position;
        }, $positions);
        return $this;
    }
}