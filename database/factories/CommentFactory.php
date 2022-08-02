<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            'content' => '{"ops":[{"insert":"Hello world\\n"}]}',
            'plain_text' => 'Hello world',
        ];
    }
}
