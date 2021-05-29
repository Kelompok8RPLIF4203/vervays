<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\FlashMessages;
use Illuminate\Http\Request;

class FlashMessageController extends Controller
{
    public function getFlashMessages(Request $request)
    {
        $flashMessages = FlashMessages::where('userId', session('id'))->get();
        FlashMessages::where('userId', session('id'))->delete();
        return response()->json($flashMessages);
    }

    public function store(Request $request)
    {
        $flashMessages = new FlashMessages();
        $flashMessages->userId = session('id');
        $flashMessages->message = $request->post('message');
        $flashMessages->type = $request->post('type');
        $flashMessages->allotmentId = $request->post('allotmentId');
        $flashMessages->save();
    }
}
