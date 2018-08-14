<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function searchTags(Request $request)
    {
        $keyword = $request->keyword;
//        if (!isset($keyword)) {
//            $tags = tag::take(5)->get(['id','name as text']);
//        }
        $tags = Tag::where('name', 'like', "%${keyword}%")->take(5)->get(['name as idField','name as textField']);
        return response()->json(['msg' => 'success', 'data' => $tags], 200);
    }

}
