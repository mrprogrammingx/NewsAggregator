<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    use ErrorLogTrait;

    public function validateWithCustomFormRequest(array $data, \Illuminate\Foundation\Http\FormRequest $formRequest): array|bool
    {
        $validator = Validator::make(
            $data,
            $formRequest->rules(),
            $formRequest->messages(),
            $formRequest->attributes()
        );

        if ($validator->fails()) {
            $this->logError('Failed in validate:', ['error' => $validator->errors(), 'data' => $data]);

            return false;
        }

        return $validator->validated();
    }
}
