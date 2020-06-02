<?php


namespace Tests\Unit\Services;


use App\Models\Action;
use App\Repositories\Action\ActionRepositoryInterface;
use App\Services\Action\ActionService;
use Mockery;
use Tests\TestCase;

class ActionServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }


    public function testAllAction()
    {
        $action = factory(Action::class, 1)->make();
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('all')->andReturn($action);

        $service = new ActionService($repository);
        $actions = $service->all();
        $this->assertEquals($action, $actions);
    }

    public function testCreateAction()
    {
        $data = ['uraian' => 'foo'];
        $action = factory(Action::class)->make($data);
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('create')->withArgs([$data])->andReturn($action);

        $service = new ActionService($repository);
        $expectedAction = $service->create($data);
        $this->assertEquals($expectedAction, $action);
    }

    public function testUpdateAction()
    {
        $data = ['uraian' => 'foo'];
        $action = factory(Action::class)->make();
        $action->id = '123456';
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('findByID')->withArgs([$action->id])->andReturn($action);
        $updatedAction = $action;
        $updatedAction->uraian = 'foo';
        $repository->expects('update')->withArgs([$action, $data])->andReturn($updatedAction);

        $service = new ActionService($repository);
        $expectedAction = $service->update($action->id, $data);
        $this->assertEquals($expectedAction, $action);
    }

    public function testUpdateIfActionNotFound()
    {
        $id = '123456';
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('findByID')->withArgs([$id])->andReturn(null);

        $service = new ActionService($repository);
        $action = $service->update($id, []);
        $this->assertNull($action);
    }

    public function testDeleteAction()
    {
        $action = factory(Action::class)->make();
        $action->id = '123456';
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('findByID')->withArgs([$action->id])->andReturn($action);
        $repository->expects('delete')->withArgs([$action]);

        $service = new ActionService($repository);
        $status = $service->delete($action->id);
        $this->assertTrue($status);
    }

    public function testDeleteWhenActionNotFound()
    {
        $id = '123456';
        $repository = Mockery::mock(ActionRepositoryInterface::class);
        $repository->expects('findByID')->withArgs([$id])->andReturn(null);

        $service = new ActionService($repository);
        $status = $service->delete($id);
        $this->assertFalse($status);
    }
}
