<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => '{"ops":[{"insert":"Hello world\\n"}]}',
            'plain_text' => 'Hello world',
        ];
    }
}
