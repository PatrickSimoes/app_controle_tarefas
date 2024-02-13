<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Tarefa $tarefa)
    {
        //
    }

    public function edit(Tarefa $tarefa)
    {
        //
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        //
    }

    public function destroy(Tarefa $tarefa)
    {
        //
    }
}
