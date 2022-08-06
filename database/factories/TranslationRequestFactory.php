<?php

namespace Database\Factories;

use App\Models\TranslationRequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationRequestFactory extends Factory
{
    public function definition()
    {
        return [
            'status' => TranslationRequestStatus::UNCLAIMED,
            'content' => '{"ops":[{"insert":"Hello world\\n"}]}',
            'plain_text' => 'Hello world',
            'num_approvals_required' => 0,
        ];
    }
}
