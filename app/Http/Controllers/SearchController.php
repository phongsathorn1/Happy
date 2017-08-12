<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function search($keyword)
    {
        $results_by_username = User::where('username', 'like', '%'.$keyword.'%');
        $results = User::where('name', 'like', '%'.$keyword.'%')->union($results_by_username)->get();
        return response()->json($results);
    }
}
