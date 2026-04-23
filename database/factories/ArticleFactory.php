<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idArray = User::pluck('id')->toArray();
        $randomId = $idArray[array_rand($idArray)];
        
        return [

            'title'=>fake()->text(50),
            'content'=>fake()->paragraphs(10, true),
            'published'=>true,
            'user_id'=>$randomId,
        ];
    }
}
