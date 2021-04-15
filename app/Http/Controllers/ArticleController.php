<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

class ArticleController extends Controller
{
    public function getList(Request $request) {
        $array = ['error' => '', 'list' => ''];

        $category = $request->input('category');
        if ($category) {
            $list = Article::select('name', 'description', 'imageUrl')->where('categoryId', $category)->get();
        } else {
            $list = Article::select('name', 'description', 'imageUrl')->get();
        }
        $array['list'] = $list;

        return $array;
    }

    public function get($id) {
        $array = ['error' => ''];

        $article = Article::find($id);
        if (!$article) {
            $array['error'] = 'Artigo não encontrado';
            return response()->json($array, 400);
        }
        $array['article'] = $article;

        return $array;
    }
}
