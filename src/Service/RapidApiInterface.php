<?php

namespace App\Service;

interface RapidApiInterface
{
    public function getProfile(string $username);
    public function getPosts(string $username);
}