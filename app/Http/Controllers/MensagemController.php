<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index()
    {
        return view('tenant.mensagens.index');
    }
}
