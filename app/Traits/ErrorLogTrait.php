<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ErrorLogTrait
{
    private function logError(string $message, array $context = []): void
    {
        Log::error($message, ['context' => $context]);
    }
}
