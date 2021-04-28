<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

class ArticleController extends Controller
{
    public function getList(Request $request) {
        $array = ['error' => '', 'list' => ''];

        $category = $request->input('category');
        $title = $request->input('title');
        $list = Article::select('title', 'resume', 'coverUrl');
        if ($category) {
            $list->where('categoryId', $category);
        }
        if ($title) {
            $list->where('title', 'LIKE', '%'.$title.'%');
        }
        $array['list'] = $list->orderBy('id', 'DESC')->get();

        return $array;
    }

    public function get($id) {
        $array = ['error' => ''];

        $article = Article::find($id);
        if (!$article) {
            $array['error'] = 'Artigo não encontrado';
            return response()->json($array, 404);
        }
        $array['article'] = $article;

        return $array;
    }
}
