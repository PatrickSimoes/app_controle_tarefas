<?php

namespace App\Http\Controllers;

use App\Mail\NovatarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TarefaController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tarefas = Tarefa::all();

        return response()->json([
            'dados' => $tarefas
        ], 201);
    }

    public function create()
    {
        return view('tarefa.create');
    }

    public function store(Request $request)
    {
        $tarefa = Tarefa::create($request->all());

        $destinario = auth()->user()->email; //e-mail do usuário logado (autenticado)

        Mail::to($destinario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
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
