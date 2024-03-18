<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Tarefas</title>
    <style>
        body {
            background-color: #333; /* Cor de fundo escuro */
            color: #fff; /* Cor do texto */
            padding: 20px; /* Espaçamento interno */
            font-family: Arial, sans-serif; /* Fonte do texto */
        }
    </style>
</head>
<body>
    
    <h1>Bem-vindo ao Controle de Tarefas</h1>
    
    @auth
        <h2>Usuario Autenticado</h2>
        <a href="{{ route('tarefa.index')}}" class="btn btn-primary">Tarefas</a>
    @endauth

    @guest
        <p>Usuario não autenticado</p>
        <a href="{{ route('login')}}" class="btn btn-primary">Login</a>
    @endguest
</body>
</html>
