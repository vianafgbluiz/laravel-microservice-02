<?php

namespace Tests\Feature\Api;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    /**
     * Test Empty Reponse
     *
     * @return void
     */
    public function test_get_evaluations_empty()
    {
        $response = $this->getJson('/evaluations/fake-company');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data.evaluations');
    }

    /**
     * Get All Evaluations Company
     *
     * @return void
     */
    public function test_get_evaluations_company()
    {
        $company = (string) Str::uuid();
        $evaluations = Evaluation::factory()->count(6)->create([
            'company' => $company
        ]);

        $response = $this->getJson("/evaluations/{$company}");

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data.evaluations');
    }

    /**
     * Test Validations
     *
     * @return void
     */
    public function test_error_store_evaluation()
    {
        $company = 'fake-company';

        $response = $this->postJson("/evaluations/{$company}", []);

        $response->assertStatus(422);
    }

    /**
     * Test Validations
     *
     * @return void
     */
    public function test_store_evaluation()
    {
        $company = 'fake-company';

        $response = $this->postJson("/evaluations/{$company}", [
            'company' => (string) Str::uuid(),
            'comment' => 'New Comment',
            'stars' => 5
        ]);

        $response->assertStatus(404);
    }
}
