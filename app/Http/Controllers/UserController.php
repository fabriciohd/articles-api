<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function approveUser($id, Request $request) {
        return $id;
    }
}
