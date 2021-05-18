<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Article;
use App\Models\Category;

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
        $list = $list->orderBy('id', 'DESC')->get();

        foreach ($list as $item) {
            $item['coverUrl'] = asset('storage/'.$item['coverUrl']);
        }

        $array['list'] = $list;

        return $array;
    }

    public function get($id) {
        $array = ['error' => ''];

        $article = Article::find($id);
        if (!$article) {
            $array['error'] = 'Artigo não encontrado';
            return response()->json($array, 404);
        }
        $article['coverUrl'] = asset('storage/'.$article['coverUrl']);
        $array['article'] = $article;

        return $array;
    }

    public function addArticle(Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'resume' => 'required',
            'cover' => 'required|file|mimes:jpg,png',
            'content' => 'required',
            'categoryId' => 'required',
        ]);

        if (!$validator->fails()) {
            $title = $request->input('title');
            $resume = $request->input('resume');
            $content = $request->input('content');

            $categoryId = $request->input('categoryId');
            if (!Category::find($categoryId)) {
                $array['error'] = 'Categoria Inexistente';
                return response()->json($array, 422);
            }
            
            $cover = $request->file('cover')->store('public');
            $coverUrl = explode('public/', $cover);
            $coverUrl = $coverUrl[1];

            $newArticle = new Article;
            $newArticle->title = $title;
            $newArticle->resume = $resume;
            $newArticle->coverUrl = $coverUrl;
            $newArticle->content = $content;
            $newArticle->categoryId = $categoryId;
            $newArticle->userId = auth()->user()->id;
            $newArticle->save();

            $array['message'] = 'Artigo criado com sucesso';
        } else {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 422);
        }

        return $array;
    }

    public function setArticle(Request $request, $id) {
        $array = ['error' => ''];

        if (Article::find($id)) {
            $validator = Validator::make($request->all(), [
                'cover' => 'file|mimes:jpg,png',
            ]);
            if ($validator->fails()) {
                $array['error'] = $validator->errors()->first();
                return response()->json($array, 422);
            }
    
            $title = $request->input('title');
            $resume = $request->input('resume');
            $content = $request->input('content');
    
            $categoryId = $request->input('categoryId');
            if ($categoryId && !Category::find($categoryId)) {
                $array['error'] = 'Categoria Inexistente';
                return response()->json($array, 422);
            }
    
            if ($request->hasFile('cover')) {
                $cover = $request->file('cover')->store('public');
                $coverUrl = explode('public/', $cover);
                $coverUrl = $coverUrl[1];
            }
            
            $updates = [];
            if ($title) {
                $updates['title'] = $title;
            }
            if ($resume) {
                $updates['resume'] = $resume;
            }
            if ($content) {
                $updates['content'] = $content;
            }
            if ($categoryId) {
                $updates['categoryId'] = $categoryId;
            }
            if ($request->hasFile('cover')) {
                $updates['coverUrl'] = $coverUrl;
            }

            if (count($updates) > 0) {
                Article::where('id', $id)->update($updates);
                $array['message'] = 'Artigo modificado com sucesso';
            } else {
                $array['message'] = 'Nenhum dado foi modificado';
            }

        } else {
            $array['error'] = 'Artigo não encontrado';
            return response()->json($array, 404);
        }


        return $array;
    }
}
