<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    public function approveUser(Request $request, $id) {
        $array = ['error' => ''];


        if (!User::find($id)) {
            $array['error'] = 'Usuário não encontrado';
            return response()->json($array, 404);
        }
        $validator = Validator::make($request->all(), [
            'approved' => 'required|integer|between:0,1',
            'adm' => 'required|integer|between:0,1',
        ]);
        if ($validator->fails()) {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 422);
        }

        $approved = $request->input('approved');
        $adm = $request->input('adm');
        
        User::where('id', $id)->update([
            'approved' => $approved,
            'adm' => $adm
        ]);
        $array['message'] = 'Permissões modificadas com sucesso';

        return $array;
    }
}
