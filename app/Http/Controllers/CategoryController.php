<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function getAll() {
        $array = ['error' => '', 'list' => ''];

        $array['list'] = Category::all();

        return $array;
    }
}
