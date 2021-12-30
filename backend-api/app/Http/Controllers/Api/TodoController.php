<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends BaseController
{
    private $today;

    public function __construct()
    {
        $this->today = Carbon::today()->format('Y-m-d');
    }
    public function index()
    {
        $todo = Todo::where([['date', $this->today], ['user_id', Auth::user()->id]])->get();

        return $this->responseOk($todo, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed', 404, $validator->errors());
        }

        $todo = Todo::create([
            'date'      => $this->today,
            'task'      => $request->task,
            'status'    => '0',
            'user_id'   => Auth::user()->id,
        ]);

        if (!$todo) {
            return $this->responseError('Failed', 402);
        }

        return $this->responseOk('Success add new list', 200);
    }
}
