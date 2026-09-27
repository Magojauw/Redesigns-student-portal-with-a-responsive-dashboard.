<?php
session_start();

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [
        ['materia' => 'Matemática', 'titulo' => 'Lista de exercícios', 'data' => '2026-09-28', 'status' => 'Pendente'],
        ['materia' => 'História', 'titulo' => 'Trabalho sobre Brasil Colonial', 'data' => '2026-09-30', 'status' => 'Pendente'],
        ['materia' => 'Geografia', 'titulo' => 'Pesquisa sobre a Amazônia', 'data' => '2026-10-02', 'status' => 'Concluída'],
    ];
}

$paginas = [
    'inicio' => ['titulo' => 'Olá, João!', 'subtitulo' => 'Confira suas atividades e seu desempenho escolar.'],
    'tarefas' => ['titulo' => 'Tarefas', 'subtitulo' => 'Organize suas atividades e acompanhe seus prazos.'],
    'notas' => ['titulo' => 'Notas', 'subtitulo' => 'Acompanhe seu desempenho em cada disciplina.'],
    'disciplinas' => ['titulo' => 'Disciplinas', 'subtitulo' => 'Veja informações sobre suas matérias e professores.'],
    'calendario' => ['titulo' => 'Calendário', 'subtitulo' => 'Fique por dentro dos próximos compromissos escolares.'],
    'perfil' => ['titulo' => 'Meu perfil', 'subtitulo' => 'Suas informações acadêmicas e de contato.'],
];

$pagina = $_GET['pagina'] ?? 'inicio';
if (!array_key_exists($pagina, $paginas)) {
    $pagina = 'inicio';
}

$tarefas = $_SESSION['tarefas'];
$pendentes = count(array_filter($tarefas, static fn($tarefa) => $tarefa['status'] === 'Pendente'));
$notas = [
    ['nome' => 'Matemática', 'nota' => '8,5', 'professor' => 'Marina Costa', 'tarefas' => 4],
    ['nome' => 'Português', 'nota' => '9,2', 'professor' => 'Ricardo Alves', 'tarefas' => 3],
    ['nome' => 'História', 'nota' => '8,8', 'professor' => 'Camila Souza', 'tarefas' => 2],
    ['nome' => 'Geografia', 'nota' => '8,4', 'professor' => 'Eduardo Lima', 'tarefas' => 3],
];
$eventos = [
    ['dia' => '28', 'mes' => 'SET', 'titulo' => 'Lista de Matemática', 'tipo' => 'Entrega', 'disciplina' => 'Matemática'],
    ['dia' => '30', 'mes' => 'SET', 'titulo' => 'Trabalho de História', 'tipo' => 'Entrega', 'disciplina' => 'História'],
    ['dia' => '02', 'mes' => 'OUT', 'titulo' => 'Avaliação de Geografia', 'tipo' => 'Prova', 'disciplina' => 'Geografia'],
    ['dia' => '10', 'mes' => 'OUT', 'titulo' => 'Feira de Ciências', 'tipo' => 'Evento escolar', 'disciplina' => 'Escola'],
];

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

function dataFormatada(string $data): string
{
    $date = DateTime::createFromFormat('Y-m-d', $data);
    return $date ? $date->format('d/m/Y') : $data;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($paginas[$pagina]['titulo']) ?> | Área do Aluno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar" aria-label="Navegação principal">
        <a class="brand" href="index.php" aria-label="Área do Aluno - Início">
            <span class="brand-mark">A</span>
            <span>Área do Aluno</span>
        </a>

        <nav class="sidebar-nav">
            <a href="index.php" class="<?= $pagina === 'inicio' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1Z"/></svg>Início
            </a>
            <a href="index.php?pagina=tarefas" class="<?= $pagina === 'tarefas' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/></svg>Tarefas
            </a>
            <a href="index.php?pagina=notas" class="<?= $pagina === 'notas' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/></svg>Notas
            </a>
            <a href="index.php?pagina=disciplinas" class="<?= $pagina === 'disciplinas' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5Zm0 0V5.5m0 0A2.5 2.5 0 0 1 6.5 8H20"/></svg>Disciplinas
            </a>
            <a href="index.php?pagina=calendario" class="<?= $pagina === 'calendario' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18"/></svg>Calendário
            </a>
        </nav>

        <nav class="sidebar-footer">
            <a href="index.php?pagina=perfil" class="<?= $pagina === 'perfil' ? 'is-active' : '' ?>">
                <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>Configurações
            </a>
            <a href="index.php" data-logout>
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M10 17l5-5-5-5m5 5H3m9-8h7a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-7"/></svg>Sair
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="sidebar" data-menu-toggle>
                <span></span><span></span><span></span>
            </button>
            <div class="page-heading">
                <p class="eyebrow">Portal do aluno</p>
                <h1><?= e($paginas[$pagina]['titulo']) ?></h1>
                <p><?= e($paginas[$pagina]['subtitulo']) ?></p>
            </div>
            <a class="profile-summary" href="index.php?pagina=perfil">
                <span class="avatar">J</span>
                <span><strong>João</strong><small>6º Ano A</small></span>
            </a>
        </header>

        <?php if ($pagina === 'inicio'): ?>
            <section class="stats-grid" aria-label="Resumo escolar">
                <article class="stat-card"><span class="stat-label">Tarefas pendentes</span><strong><?= $pendentes ?></strong><small>para os próximos dias</small></article>
                <article class="stat-card"><span class="stat-label">Média geral</span><strong>8,7</strong><small>bom desempenho</small></article>
                <article class="stat-card"><span class="stat-label">Próxima avaliação</span><strong>02/10</strong><small>Geografia</small></article>
                <article class="stat-card"><span class="stat-label">Frequência</span><strong>94%</strong><small>no ano letivo</small></article>
            </section>

            <section class="dashboard-grid">
                <article class="surface tasks-surface">
                    <div class="section-header">
                        <div><h2>Próximas tarefas</h2><p>Atividades que precisam da sua atenção.</p></div>
                        <button type="button" class="button button-primary" data-open-modal>+ Nova tarefa</button>
                    </div>
                    <div class="task-list">
                        <?php foreach (array_slice($tarefas, 0, 3) as $tarefa): ?>
                            <article class="task-row">
                                <span class="task-indicator <?= $tarefa['status'] === 'Concluída' ? 'is-complete' : '' ?>" aria-label="<?= e($tarefa['status']) ?>"></span>
                                <div class="task-details"><strong><?= e($tarefa['titulo']) ?></strong><span><?= e($tarefa['materia']) ?></span></div>
                                <div class="task-due"><small>Entrega</small><strong><?= e(dataFormatada($tarefa['data'])) ?></strong></div>
                                <span class="badge <?= $tarefa['status'] === 'Concluída' ? 'badge-success' : 'badge-warning' ?>"><?= e($tarefa['status']) ?></span>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <a class="text-link" href="index.php?pagina=tarefas">Ver todas as tarefas <span aria-hidden="true">→</span></a>
                </article>

                <article class="surface performance-surface">
                    <div class="section-header"><div><h2>Desempenho</h2><p>Suas médias por disciplina.</p></div></div>
                    <div class="grade-list">
                        <?php foreach ($notas as $nota): ?>
                            <div class="grade-row"><div><strong><?= e($nota['nome']) ?></strong><div class="progress"><span style="width: <?= e(str_replace(',', '.', $nota['nota']) * 10) ?>%"></span></div></div><strong><?= e($nota['nota']) ?></strong></div>
                        <?php endforeach; ?>
                    </div>
                </article>
            </section>

            <section class="surface">
                <div class="section-header"><div><h2>Agenda escolar</h2><p>Veja os próximos compromissos.</p></div><a class="text-link" href="index.php?pagina=calendario">Ver calendário <span aria-hidden="true">→</span></a></div>
                <div class="event-grid">
                    <?php foreach (array_slice($eventos, 0, 3) as $evento): ?>
                        <article class="event-card"><time><strong><?= e($evento['dia']) ?></strong><span><?= e($evento['mes']) ?></span></time><div><strong><?= e($evento['titulo']) ?></strong><span><?= e($evento['disciplina']) ?> · <?= e($evento['tipo']) ?></span></div></article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php elseif ($pagina === 'tarefas'): ?>
            <section class="surface">
                <div class="section-header"><div><h2>Minhas tarefas</h2><p><?= $pendentes ?> pendentes de um total de <?= count($tarefas) ?> atividades.</p></div><button type="button" class="button button-primary" data-open-modal>+ Nova tarefa</button></div>
                <div class="table-wrap"><table><thead><tr><th>Tarefa</th><th>Disciplina</th><th>Data de entrega</th><th>Status</th></tr></thead><tbody>
                    <?php foreach ($tarefas as $tarefa): ?><tr><td data-label="Tarefa"><strong><?= e($tarefa['titulo']) ?></strong></td><td data-label="Disciplina"><?= e($tarefa['materia']) ?></td><td data-label="Data de entrega"><?= e(dataFormatada($tarefa['data'])) ?></td><td data-label="Status"><span class="badge <?= $tarefa['status'] === 'Concluída' ? 'badge-success' : 'badge-warning' ?>"><?= e($tarefa['status']) ?></span></td></tr><?php endforeach; ?>
                </tbody></table></div>
            </section>
        <?php elseif ($pagina === 'notas'): ?>
            <section class="grade-overview"><article class="surface grade-summary"><span>Média geral</span><strong>8,7</strong><p>Você mantém um excelente desempenho.</p></article><article class="surface"><h2>Boletim escolar</h2><p class="section-description">Notas atualizadas do período atual.</p><div class="table-wrap"><table><thead><tr><th>Disciplina</th><th>Nota</th><th>Situação</th></tr></thead><tbody><?php foreach ($notas as $nota): ?><tr><td data-label="Disciplina"><strong><?= e($nota['nome']) ?></strong></td><td data-label="Nota"><strong><?= e($nota['nota']) ?></strong></td><td data-label="Situação"><span class="badge badge-success">Aprovado</span></td></tr><?php endforeach; ?></tbody></table></div></article></section>
        <?php elseif ($pagina === 'disciplinas'): ?>
            <section class="subjects-grid"><?php foreach ($notas as $nota): ?><article class="surface subject-card"><span class="subject-initial"><?= e(substr($nota['nome'], 0, 1)) ?></span><div><h2><?= e($nota['nome']) ?></h2><p><?= e($nota['professor']) ?></p></div><dl><div><dt>Média</dt><dd><?= e($nota['nota']) ?></dd></div><div><dt>Tarefas</dt><dd><?= e((string) $nota['tarefas']) ?></dd></div></dl></article><?php endforeach; ?></section>
        <?php elseif ($pagina === 'calendario'): ?>
            <section class="surface"><div class="section-header"><div><h2>Setembro e outubro</h2><p>Compromissos e atividades do calendário escolar.</p></div></div><div class="calendar-events"><?php foreach ($eventos as $evento): ?><article class="calendar-event"><time><strong><?= e($evento['dia']) ?></strong><span><?= e($evento['mes']) ?></span></time><div><span class="event-type"><?= e($evento['tipo']) ?></span><h2><?= e($evento['titulo']) ?></h2><p><?= e($evento['disciplina']) ?></p></div></article><?php endforeach; ?></div></section>
        <?php elseif ($pagina === 'perfil'): ?>
            <section class="profile-page"><article class="surface profile-card"><span class="profile-avatar">J</span><div><h2>João</h2><p>Aluno · 6º Ano A</p></div></article><article class="surface personal-data"><h2>Informações pessoais</h2><dl><div><dt>Nome completo</dt><dd>João</dd></div><div><dt>Ano</dt><dd>6º Ano</dd></div><div><dt>Turma</dt><dd>A</dd></div><div><dt>E-mail</dt><dd>joao@aluno.com</dd></div></dl></article></section>
        <?php endif; ?>
    </main>
</div>

<div class="modal" id="task-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-dialog">
        <div class="modal-header"><div><p class="eyebrow">Nova atividade</p><h2 id="modal-title">Cadastrar tarefa</h2></div><button class="icon-button" type="button" aria-label="Fechar" data-close-modal>×</button></div>
        <form method="POST" action="criar.php" id="task-form">
            <label for="tarefa">Título da tarefa</label><input id="tarefa" type="text" name="tarefa" placeholder="Ex.: Trabalho de Ciências" required maxlength="120">
            <label for="materia">Disciplina</label><select id="materia" name="materia" required><option value="Matemática">Matemática</option><option value="Português">Português</option><option value="História">História</option><option value="Geografia">Geografia</option><option value="Ciências">Ciências</option></select>
            <div class="form-grid"><div><label for="data">Data de entrega</label><input id="data" type="date" name="data" required></div><div><label for="status">Status</label><select id="status" name="status" required><option value="Pendente">Pendente</option><option value="Concluída">Concluída</option></select></div></div>
            <div class="form-actions"><button class="button button-secondary" type="button" data-close-modal>Cancelar</button><button class="button button-primary" type="submit">Cadastrar tarefa</button></div>
        </form>
    </div>
</div>
<script src="../js/app.js"></script>
</body>
</html>
