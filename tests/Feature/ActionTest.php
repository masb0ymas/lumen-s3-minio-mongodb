<?php

namespace Tests\Feature;

use App\Models\Action;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAllAction()
    {
        $actions = factory(Action::class, 2)->create();
        $response = $this->get('/action');

        $response->assertResponseOk();
        $response->seeJson([
            'message' => 'success retrieve action',
            'data' => $actions->toArray(),
        ]);
    }

    public function testCreateNewAction()
    {
        $response = $this->json('POST', '/action', ['uraian' => 'foo']);

        $response->assertResponseOk();
        $response->seeJson([
            'message' => 'success create new action',
            'uraian' => 'foo',
        ]);
    }

    public function testValidationCreateNewAction()
    {
        $response = $this->json('POST', '/action', []);

        $response->assertResponseStatus(422);
        $response->seeJson([
            'message' => 'validation error',
            'uraian' => [
                'The uraian field is required.'
            ]
        ]);
    }

    public function testUpdateAction()
    {
        $action = factory(Action::class)->create();
        $response = $this->json('PUT', 'action/' . $action->id, ['uraian' => 'bar']);

        $response->seeJson([
            'message' => 'success update action',
            'uraian' => 'bar',
        ]);
    }

    public function testUpdateValidation()
    {
        $action = factory(Action::class)->create();
        $response = $this->json('PUT', 'action/' . $action->id, []);

        $response->assertResponseStatus(422);
        $response->seeJson([
            'message' => 'validation error',
            'uraian' => [
                'The uraian field is required.'
            ]
        ]);
    }

    public function testUpdateWhenActionNotFound()
    {
        $response = $this->json('PUT', 'action/123456', ['uraian' => 'foo']);

        $response->assertResponseStatus(404);
        $response->seeJson([
            'message' => 'failed update action',
            'errors' => 'action not found',
        ]);
    }

    public function testDelete()
    {
        $action = factory(Action::class)->create();
        $response = $this->json('DELETE', 'action/' . $action->id);

        $response->seeJson([
            'message' => 'success delete action',
        ]);
    }

    public function testDeleteWhenActionNotFound()
    {
        $response = $this->json('DELETE', 'action/123456');

        $response->assertResponseStatus(404);
        $response->seeJson([
            'message' => 'failed delete action',
            'errors' => 'action not found',
        ]);
    }
}
