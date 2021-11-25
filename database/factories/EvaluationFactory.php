<?php

namespace Database\Factories;

use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{

    protected $model = Evaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company' => $this->faker->uuid(),
            'comment' => $this->faker->sentence(8),
            'stars' => $this->faker->numberBetween(1, 5)
        ];
    }
}
