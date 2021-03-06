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
            'is_approved'    => '0',
            'user_id'   => Auth::user()->id,
        ]);

        if (!$todo) {
            return $this->responseError('Failed', 402);
        }

        return $this->responseOk('Success add new list', 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'          => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Failed', 402, $validator->errors());
        }

        $todo = Todo::find($request->id);
        $todo->is_approved = '1';
        $todo->save();

        return $this->responseOk('Success', 200);
    }

    public function delete($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return $this->responseOk('Success', 200);
    }

    public function search($date)
    {
        $activities = Todo::where('date', $date)->get();
        return $this->responseOk($activities, 200);
    }
}
