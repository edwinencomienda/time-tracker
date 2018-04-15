<?php

namespace App\Http\Controllers;

use App\UserTimeLog;
use Illuminate\Http\Request;
use App\Http\Resources\UserTimeLogCollection;
use App\Http\Requests\UserTimeLog\StoreRequest;

class UserTimeLogController extends Controller
{
    private $userTimeLog;

    public function __construct(UserTimeLog $userTimeLog) {
        $this->userTimeLog = $userTimeLog;
    }

    public function index(Request $request)
    {
        $userTimeLogs = $this->userTimeLog;
        if ($request->has('include')) {
            $userTimeLogs = $this->userTimeLog->with(explode(',', $request->get('include')));
        }
        return new UserTimeLogCollection($userTimeLogs->get());
    }

    public function create(StoreRequest $request)
    {
        $this->userTimeLog->saveTimeLog([
            'user_id' => $request->get('user_id'),
            'type' => $request->get('type')
        ]);

        $message = $request->get('type') == 'login' ? 'successfully login.' : 'successfully logout.';

        return response()->json($message, 200);
    }
}
