<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProfiles(Request $request) {
        $query = $request->input('query'); //ia valoarea query din url
        if(empty($query)) {
            return response()->json(['message' => 'Empty query!']);
        }
        $results = User::where('name', 'like', "%{$query}%")->orWhere('username','like',"%{$query}%")->distinct()->limit(4)->get();
        foreach($results as $result) {
            $result['profileImage'] = $result->profile->profileImage();
            $result['followers'] = $result->profile->followers->count();
        }

        return response()->json($results);
    }
}
