<?php

namespace App\Http\Controllers;

use App\Repositories\Action\ActionRepository;
use App\Services\Action\ActionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ActionController extends Controller
{
    /**
     * @var ActionService
     */
    protected $actionService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->actionService = new ActionService(new ActionRepository());
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $actions = $this->actionService->all();

        return response()->json([
            'message' => 'success retrieve action',
            'data' => $actions
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'uraian' => 'required',
        ]);

        $action = $this->actionService->create($request->toArray());

        return response()->json([
            'message' => 'success create new action',
            'data' => $action,
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'uraian' => 'required',
        ]);

        $action = $this->actionService->update($id, $request->toArray());

        if ($action == null) {
            return response()->json([
                'message' => 'failed update action',
                'errors' => 'action not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success update action',
            'data' => $action,
        ]);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $status = $this->actionService->delete($id);

        if (!$status) {
            return response()->json([
                'message' => 'failed delete action',
                'errors' => 'action not found',
            ], 404);
        }

        return response()->json([
            'message' => 'success delete action',
        ]);
    }
}
