<?php

namespace App\Enum;

enum AnalysisStatus: string
{
    case LOADING = "loading";

    public function toString(): string
    {
        return $this->value;
    }
}
