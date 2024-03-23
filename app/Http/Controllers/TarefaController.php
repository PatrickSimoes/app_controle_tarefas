<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Mail\NovatarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = auth()->user()->id;

        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);

        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    public function create()
    {
        return view('tarefa.create');
    }

    public function store(Request $request)
    {
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        
        $dados ['user_id'] = auth()->user()->id;
        
        $tarefa = Tarefa::create($dados);

        $destinario = auth()->user()->email; //e-mail do usuário logado (autenticado)

        Mail::to($destinario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    public function show(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    public function edit(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        return view('tarefa.edit', ['tarefa' => $tarefa]);
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    public function destroy(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }
        
        $tarefa->delete();
        
        return redirect()->route('tarefa.index');
    }

    public function exportacao($extensao) {
        $nome_arquivo = 'Lista de Tarefas';

        if(in_array(!$extensao, ['xlsx', 'csv', 'pdf'])) {
            return redirect()->route('tarefa.index');
        }

        $nome_arquivo .= '.'.$extensao;
        return Excel::download(new TarefasExport, $nome_arquivo);
    }
}
