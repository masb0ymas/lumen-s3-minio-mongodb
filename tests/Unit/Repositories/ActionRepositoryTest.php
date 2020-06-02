<?php

namespace Tests\Unit\Repositories;

use App\Models\Action;
use App\Repositories\Action\ActionRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActionRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAllAction()
    {
        $repository = new ActionRepository();

        $this->assertEquals([], $repository->all()->toArray());

        $action = factory(Action::class)->create();

        $collection = $repository->all();
        $this->assertEquals($action->toArray(), $collection[0]->toArray());
        $this->seeInDatabase('actions', ['uraian' => $collection[0]->uraian]);
    }

    public function testCreateNewAction()
    {
        $repository = new ActionRepository();

        $action = $repository->create(['uraian' => 'foo']);

        $this->seeInDatabase('actions', ['uraian' => $action->uraian]);
    }

    public function testFindActionByID()
    {
        $repository = new ActionRepository();

        $action = factory(Action::class)->create();

        $actualAction = $repository->findByID($action->id);

        $this->assertEquals($action->toArray(), $actualAction->toArray());
    }

    public function testFindByIDNotFound()
    {
        $repository = new ActionRepository();

        $actualAction = $repository->findByID('123456');

        $this->assertNull($actualAction);
    }

    public function testUpdateAction()
    {
        $repository = new ActionRepository();

        $action = factory(Action::class)->create();

        $this->seeInDatabase('actions', ['uraian' => $action->uraian]);

        $action = $repository->update($action, ['uraian' => 'foo']);

        $this->seeInDatabase('actions', ['uraian' => 'foo']);
        $this->assertEquals('foo', $action->uraian);
    }

    public function testDeleteAction()
    {
        $repository = new ActionRepository();

        $action = factory(Action::class)->create();

        $this->seeInDatabase('actions', ['uraian' => $action->uraian]);

        $repository->delete($action);

        $this->notSeeInDatabase('actions', ['uraian' => $action->uraian]);
    }
}
