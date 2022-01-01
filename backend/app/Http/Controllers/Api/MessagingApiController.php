<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessagingApiController extends Controller
{
    public function webhook(Request $request)
    {
        //            1. getMessageObjectServiceでメッセージを取得
        //            2. メッセージの振る舞いを実行
        return response()->json($request->input());
    }
}
