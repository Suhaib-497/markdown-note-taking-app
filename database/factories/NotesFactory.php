<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notes>
 */
class NotesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notes::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $heading = '# ' . fake()->sentence(6);
        $subheading = '## ' . fake()->sentence(4);

        $paragraphs = collect(range(1, fake()->numberBetween(1, 3)))
            ->map(fn() => fake()->paragraph())
            ->implode("\n\n");

        $list = collect(range(1, fake()->numberBetween(2, 6)))
            ->map(fn() => '- ' . fake()->sentence())
            ->implode("\n");

        $code = "```php\n" . 'echo "' . fake()->word() . '";' . "\n```";
        
        $markdown = implode("\n\n", array_filter([$heading, $subheading, $paragraphs, $list, $code]));

        // Truncate markdown to 240 characters to fit current DB column (varchar(255)).
        // This is a temporary measure; consider migrating the column to TEXT for full content.
        return [
            'markdown_text' => mb_substr($markdown, 0, 240),
        ];
    }

    /**
     * Convenience state to create associated files with the note.
     * Example: Notes::factory()->count(5)->withFiles(2)->create();
     *
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withFiles(int $count = 1)
    {
        return $this->has(\App\Models\Files::factory()->count($count), 'files');
    }
}
