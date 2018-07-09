<?php

namespace Busman\People\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function update(Request $request){
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return [
            'message' => 'Password updated'
        ];
    }
}
