<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conexaoBancoDados.php';
require_once 'tcc.php'; 

session_start();

// 1. Verifica se o professor está logado
if (!isset($_SESSION['cod_prof'])) {
    header("Location: entrada_professor.php");
    exit();
}

// Pega o código e nome do professor logado da sessão
$idProfessorLogado = $_SESSION['cod_prof'];
$nomeProfessorLogado = $_SESSION['nome_professor'] ?? 'Professor(a)';

// ... (o código de mensagens de status e erro continua igual)
$status_message = '';
$error_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'agendamento_sucesso') {
        $status_message = 'Agendamento salvo com sucesso!';
    } elseif ($_GET['status'] == 'tcc_removido_sucesso') {
        $status_message = 'TCC removido com sucesso!';
    } elseif ($_GET['status'] == 'tcc_atualizado_sucesso') {
        $status_message = 'TCC atualizado com sucesso!';
    }
}
if (isset($_GET['erro'])) {
    $error_message = 'Ocorreu um erro: ' . htmlspecialchars($_GET['msg'] ?? 'Detalhes não disponíveis.');
}


// 2. Busca os TCCs
try {
    $sql_tccs_sem_agendamento = "
        SELECT
            t.id_tcc, t.titulo, t.resumo,
            tt.nome_Tipo AS tipo_tcc_descricao,
            a1.Nome AS aluno1_nome, a2.Nome AS aluno2_nome, a3.Nome AS aluno3_nome
        FROM TCC AS t
        LEFT JOIN Agenda AS ag ON t.id_tcc = ag.id_tcc
        LEFT JOIN tipotcc AS tt ON t.id_tipoTCC = tt.id_tipoTCC
        LEFT JOIN Aluno AS a1 ON t.RA_aluno = a1.RA
        LEFT JOIN Aluno AS a2 ON t.RA_aluno2 = a2.RA
        LEFT JOIN Aluno AS a3 ON t.RA_aluno3 = a3.RA
        WHERE t.id_professor_orientador = :id_prof_logado AND ag.id_tcc IS NULL
        ORDER BY t.titulo ASC;
    ";

    $stmt_tccs_sem_agendamento = $gestor->prepare($sql_tccs_sem_agendamento);
    $stmt_tccs_sem_agendamento->execute([':id_prof_logado' => $idProfessorLogado]);

} catch (PDOException $e) {
    error_log("Erro ao buscar TCCs sem agendamento: " . $e->getMessage());
    $error_message .= " Erro ao buscar TCCs.";
    $stmt_tccs_sem_agendamento = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda de TCCs</title>
    <link rel="stylesheet" href="estilo/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1>Minha Agenda de TCCs</h1>
        <p>Olá, Professor(a) <?php echo htmlspecialchars($nomeProfessorLogado); ?>!</p>
        <nav>
            <a href="cadastrar_tcc.php">Cadastrar Novo TCC</a> |
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($status_message)): ?><p class="status-message"><?php echo $status_message; ?></p><?php endif; ?>
        <?php if (!empty($error_message)): ?><p class="error-message-display"><?php echo $error_message; ?></p><?php endif; ?>

        <h2>Meus TCCs Orientados (Ainda Não Agendados)</h2>
        
        <?php if ($stmt_tccs_sem_agendamento && $stmt_tccs_sem_agendamento->rowCount() > 0): ?>
            <table class="nao-agendados-table">
                <thead>
                    <tr>
                    <th>#</th> <th>Título do TCC</th>
                    <th>Alunos</th>
                    <th>Tipo TCC</th>
                    <th>Ações</th> 
                    </tr>
                </thead>
            <tbody>
                <?php 
                    $contador = 1; // 2. INICIA O CONTADOR ANTES DO LAÇO
                    while ($dados_tcc = $stmt_tccs_sem_agendamento->fetch(PDO::FETCH_ASSOC)): 
                    $tcc = new Tcc($dados_tcc);
                ?>
                <tr>
                    <td><?php echo $contador; ?></td> <td><?php echo htmlspecialchars($tcc->titulo); ?></td>
                    <td>
                        <?php 
                        echo htmlspecialchars($tcc->getAlunosNomes()); 
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($tcc->tipo_tcc_descricao); ?></td>
                    <td>
                        <a href="agendar_tcc.php?id_tcc=<?php echo $tcc->id_tcc; ?>" class="action-link">Agendar Defesa</a>
                        <a href="editar_tcc.php?id_tcc=<?php echo $tcc->id_tcc; ?>" class="action-link edit-button" title="Editar TCC">
                        <i class="fas fa-pencil-alt"></i> 
                            </a>
                        <a href="remover_tcc.php?id_tcc=<?php echo $tcc->id_tcc; ?>" class="action-link remove-button" onclick="return confirm('Tem certeza que deseja remover este TCC? Esta ação é irreversível.');" title="Remover TCC">
                            <i class="fas fa-times"></i> 
                        </a>
                    </td>
                </tr>
             <?php 
             $contador++; // 4. INCREMENTA O CONTADOR PARA A PRÓXIMA VOLTA
            endwhile; 
            ?>
        </tbody>
    </table>
        <?php else: ?>
            <p class="no-data">Todos os TCCs que você orienta já estão agendados, ou você não é orientador de nenhum TCC.</p>
        <?php endif; ?>
    </main>
</body>
</html> <table class="nao-agendados-table">
