<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?pagina=tarefas');
    exit;
}

$titulo = trim($_POST['tarefa'] ?? '');
$materia = trim($_POST['materia'] ?? '');
$data = trim($_POST['data'] ?? '');
$status = $_POST['status'] ?? 'Pendente';
$materias = ['Matemática', 'Português', 'História', 'Geografia', 'Ciências'];
$statusPermitidos = ['Pendente', 'Concluída'];

if ($titulo === '' || !in_array($materia, $materias, true) || !DateTime::createFromFormat('Y-m-d', $data) || !in_array($status, $statusPermitidos, true)) {
    header('Location: index.php?pagina=tarefas');
    exit;
}

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

$_SESSION['tarefas'][] = [
    'titulo' => $titulo,
    'materia' => $materia,
    'data' => $data,
    'status' => $status,
];

header('Location: index.php?pagina=tarefas');
exit;
