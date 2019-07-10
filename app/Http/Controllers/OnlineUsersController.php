<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class OnlineUsersController extends Controller
{
    public function load()
    {
        $admins = app('osh')->get();
        if ($admins) {
            if ($dbData = User::find(collect($admins)->pluck('userId')->all())) {
                $dbData = $dbData->keyBy('id')->all();
                foreach ($admins as $key => $admin) {
                    $admins[$key]['email'] = $dbData[$admin['userId']]->email;
                    $admins[$key]['name'] = $dbData[$admin['userId']]->name;
                    $admins[$key]['photo'] = $dbData[$admin['userId']]->photo;
                }
            }
        }
        return response()->json($admins);
    }
}
