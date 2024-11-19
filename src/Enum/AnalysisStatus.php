<?php

namespace App\Enum;

enum AnalysisStatus: string
{
    case LOADING = "loading";
    case DONE = "done";
    case ERROR = "error";

    public function toString(): string
    {
        return $this->value;
    }
}
