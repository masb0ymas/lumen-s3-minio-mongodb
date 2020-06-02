<?php

namespace Tests\Feature;

use App\Models\Faq;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetFaqs()
    {
        $faq = factory(Faq::class, 2)->create();
        $response = $this->get('/faq');

        $response->assertResponseOk();
        $response->seeJson([
            'message' => 'success retrieve faq',
            'data' => $faq->toArray(),
        ]);
    }

    public function testCreateNewFaq()
    {
        $response = $this->json('POST', '/faq', [
            'jawaban' => 'foo',
            'pertanyaan' => 'bar'
        ]);

        $response->assertResponseOk();
        $response->seeJson([
            'message' => 'success create new faq',
            'jawaban' => 'foo',
        ]);
    }

    public function testValidationCreateNewFaq()
    {
        $response = $this->json('POST', '/faq', [
            'jawaban' => 'foo'
        ]);

        $response->assertResponseStatus(422);
        $response->seeJson([
            'message' => 'validation error',
            'pertanyaan' => [
                'The pertanyaan field is required.'
            ]
        ]);
    }
}
