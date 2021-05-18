<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    public function getAll() {
        $array = ['error' => '', 'list' => ''];

        $array['list'] = Category::all();

        return $array;
    }

    public function addCategory(Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cover' => 'required|file|mimes:jpg,png',
        ]);
        if ($validator->fails()) {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 422);
        }

        $name = $request->input('name');
        $cover = $request->file('cover')->store('public');
        $coverUrl = explode('public/', $cover);
        $coverUrl = $coverUrl[1];

        $newCategory = new Category;
        $newCategory->name = $name;
        $newCategory->coverUrl = $coverUrl;
        $newCategory->save();

        $array['message'] = 'Categoria cadastrada com sucesso!';

        return $array;
    }

    public function setCategory(Request $request, $id) {
        $array = ['error' => ''];

        if (!Category::find($id)) {
            $array['error'] = 'Categoria não encontrada';
            return response()->json($array, 404);
        }
        $validator = Validator::make($request->all(), [
            'cover' => 'file|mimes:jpg,png',
        ]);
        if ($validator->fails()) {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 422);
        }

        $name = $request->input('name');
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('public');
            $coverUrl = explode('public/', $cover);
            $coverUrl = $coverUrl[1];
        }

        $updates = [];
        if ($name) {
            $updates['name'] = $name;
        }
        if ($request->hasFile('cover')) {
            $updates['coverUrl'] = $coverUrl;
        }

        if (count($updates) > 0) {
            Category::where('id', $id)->update($updates);
            $array['message'] = 'Artigo modificado com sucesso';
        } else {
            $array['message'] = 'Nenhum dado foi modificado';
        }

        return $array;
    }
}
