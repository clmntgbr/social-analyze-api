<?php

namespace App\Service\SocialAccount;

use App\Dto\Linkedin\LinkedinProfile;
use App\Dto\ProfileInterface;
use App\Entity\Analysis;
use App\Entity\LinkedinSocialAccount;
use App\Enum\AnalysisStatus;
use App\Repository\AnalysisRepository;
use App\Repository\SocialAccountRepository;
use App\Service\LinkedinRapidApi;
use Symfony\Component\Serializer\SerializerInterface;

readonly class LinkedinSocialAccountService implements SocialAccountInterface
{
    public function __construct(
        private LinkedinRapidApi     $linkedinRapidApi,
        private SerializerInterface  $serializer,
        private AnalysisRepository $analysisRepository,
        private SocialAccountRepository $socialAccountRepository
    ){}

    public function isProfileExist(string $username): bool
    {
        $response = $this->linkedinRapidApi->isProfileExist($username);

        if ($response['success'] === true) {
            return true;
        }

        return false;
    }

    public function getProfile(string $username): LinkedinProfile
    {
        $response = $this->linkedinRapidApi->mockGetProfile($username);
        return $this->serializer->deserialize(json_encode($response), LinkedinProfile::class, 'json');
    }

    /** @param LinkedinProfile $profile */
    public function hydrate(ProfileInterface $profile): void
    {
        /** @var Analysis $analysis */
        $analysis = $this->analysisRepository->findOneByCriteria([
            'platform' => 'linkedin',
            'username' => $profile->data->username,
        ]);

        if (!$analysis->getSocialAccount()) {
            $analysis->setSocialAccount(new LinkedinSocialAccount());
        }

        /** @var LinkedinSocialAccount $socialAccount */
        $socialAccount = $analysis->getSocialAccount();
        $this->socialAccountRepository->update($socialAccount, [
            'socialAccountId' => $profile->data->linkedinId,
            'followerCount' => $profile->follower,
            'followingCount' => $profile->following,
            'isVerified' => false,
            'username' => $profile->data->username,
            'firstName' => $profile->data->firstName,
            'lastName' => $profile->data->lastName,
            'profilePicture' => $profile->data->profilePicture,
            'backgroundImage' => $profile->data->backgroundImage,
            'isOpenToWork' => $profile->data->isOpenToWork,
            'isHiring' => $profile->data->isHiring,
            'summary' => $profile->data->summary,
            'headline' => $profile->data->headline,
            'skills' => $profile->data->skillsToArray(),
            'languages' => $profile->data->languagesToArray(),
            'educations' => $profile->data->educationsToArray(),
            'positions' => $profile->data->positionsToArray(),
            'payload' => $profile->toArray(),
        ]);

        $this->analysisRepository->update($analysis, [
            'status' => AnalysisStatus::DONE->toString(),
        ]);
    }
}