<?php

namespace App\Http\Controllers;

use App\Events\RequestVideoCall;
use App\Events\RequestVideoCallStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoCallController extends Controller
{
    public function requestVideoCall(Request $request, User $user)
    {
        $user->peerId = $request->peerId;
        $user->fromUser = Auth::user();

        broadcast(new RequestVideoCall($user));

        return response()->json($user);
    }

    public function requestVideoCallStatus(Request $request, User $user) {
        $user->peerId = $request->peerId;
        $user->fromUser = Auth::user();

        broadcast(new RequestVideoCallStatus($user));
        return response()->json($user);
    }
}
