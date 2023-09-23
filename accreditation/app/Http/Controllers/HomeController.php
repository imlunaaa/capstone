<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {

            if(Auth()->user()->user_type =='admin')
            {
                return view('admin.adminhome');
            }
            if(Auth()->user()->user_type == 'user')
            {
                return view('area chair.areachairhome');
            }
            else
            {
                return redirect()->back();
            }
        }
    }
}
