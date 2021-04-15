<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class StatController extends Controller
{
    public function getAll() {
        $array = ['error' => ''];

        $usersCount = User::count();
        $categoriesCount = Category::count();
        $ArticlesCount = Article::count();

        $array['users'] = $usersCount;
        $array['categories'] = $categoriesCount;
        $array['articles'] = $ArticlesCount;

        return $array;
    }
}
