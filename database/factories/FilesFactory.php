<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Files;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Files>
 */
class FilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Files::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ext = fake()->randomElement(['jpg', 'png', 'pdf', 'txt', 'md']);
        $filename = fake()->slug() . '_' . fake()->randomNumber(5) . '.' . $ext;

        return [
            // file_path is stored relative to storage/public as in existing seeders
            'file_path' => 'uploads/' . $filename,
        ];
    }
}
