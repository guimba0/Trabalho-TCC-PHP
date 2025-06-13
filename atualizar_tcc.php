<?php
// atualizar_tcc.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conexaoBancoDados.php';
session_start();

// Segurança: Apenas professor logado
if (!isset($_SESSION['cod_prof'])) {
    header("Location: entrada_professor.php");
    exit();
}

// Verifica se o formulário foi enviado pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta e sanitiza os dados do formulário
    $id_tcc = (int)$_POST['id_tcc'];
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $resumo = htmlspecialchars(trim($_POST['resumo']));
    $id_tipoTCC = (int)$_POST['id_tipoTCC'];
    $RA_aluno = htmlspecialchars(trim($_POST['RA_aluno']));
    $RA_aluno2 = !empty($_POST['RA_aluno2']) ? htmlspecialchars(trim($_POST['RA_aluno2'])) : null;
    $RA_aluno3 = !empty($_POST['RA_aluno3']) ? htmlspecialchars(trim($_POST['RA_aluno3'])) : null;
    $id_professor_orientador = (int)$_POST['id_professor_orientador'];

    // Validação básica para garantir que campos essenciais não estão vazios
    if (empty($id_tcc) || empty($titulo) || empty($resumo) || empty($id_tipoTCC) || empty($RA_aluno) || empty($id_professor_orientador)) {
        header("Location: editar_tcc.php?id_tcc={$id_tcc}&erro=campos_vazios");
        exit();
    }

    try {
        // --- UPDATE ---
        $sql = "UPDATE TCC SET
                    titulo = :titulo,
                    resumo = :resumo,
                    id_tipoTCC = :id_tipoTCC,
                    RA_aluno = :RA_aluno,
                    RA_aluno2 = :RA_aluno2,
                    RA_aluno3 = :RA_aluno3,
                    id_professor_orientador = :id_professor_orientador
                WHERE
                    id_tcc = :id_tcc";

        $stmt = $gestor->prepare($sql);

        // Vincula todos os parâmetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':resumo', $resumo);
        $stmt->bindParam(':id_tipoTCC', $id_tipoTCC, PDO::PARAM_INT);
        $stmt->bindParam(':RA_aluno', $RA_aluno);
        $stmt->bindParam(':RA_aluno2', $RA_aluno2);
        $stmt->bindParam(':RA_aluno3', $RA_aluno3);
        $stmt->bindParam(':id_professor_orientador', $id_professor_orientador, PDO::PARAM_INT);
        $stmt->bindParam(':id_tcc', $id_tcc, PDO::PARAM_INT);

        $stmt->execute();

        // Redireciona para a agenda com mensagem de sucesso
        header("Location: agendaProfessor.php?status=tcc_atualizado_sucesso");
        exit();

    } catch (PDOException $e) {
        error_log("Erro ao atualizar TCC: " . $e->getMessage());
        header("Location: editar_tcc.php?id_tcc={$id_tcc}&erro=atualizar_tcc_falha");
        exit();
    }
} else {
    // Se não for um POST, redireciona de volta para a agenda
    header("Location: agendaProfessor.php");
    exit();
}
?>