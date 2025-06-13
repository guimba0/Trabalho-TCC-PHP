<?php
// remover_tcc.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclui a conexão com o banco, que já inicializa a classe Model
require_once 'conexaoBancoDados.php';
session_start();

// --- 1. Verificação de Segurança ---
// Garante que apenas um professor logado possa acessar esta página.
if (!isset($_SESSION['cod_prof'])) {
    header("Location: entrada_professor.php");
    exit();
}

// --- 2. Validação do ID ---
// Verifica se um ID de TCC foi fornecido na URL e se é um número inteiro válido.
// Isso previne erros e ataques básicos.
if (!isset($_GET['id_tcc']) || !filter_var($_GET['id_tcc'], FILTER_VALIDATE_INT)) {
    header("Location: agendaProfessor.php?erro=id_invalido");
    exit();
}

$id_tcc_para_remover = (int)$_GET['id_tcc'];

try {
    // --- 3. Uso de Transação ---
    // Uma transação garante que todas as operações sejam executadas com sucesso.
    // Se uma falhar, todas são desfeitas (rollback), mantendo a consistência do banco.
    $gestor->beginTransaction();

    // --- 4. Remoção de Registros Dependentes ---
    // Antes de remover o TCC, precisamos remover os registros em outras tabelas que dependem dele.
    // No nosso caso, a tabela 'agenda' tem uma chave estrangeira para 'tcc'.
    // Se um TCC estiver agendado, removemos a agenda primeiro para evitar um erro.
    $stmt_agenda = $gestor->prepare("DELETE FROM agenda WHERE id_tcc = :id_tcc");
    $stmt_agenda->bindParam(':id_tcc', $id_tcc_para_remover, PDO::PARAM_INT);
    $stmt_agenda->execute();

    // --- 5. Remoção do Registro Principal ---
    // Agora que as dependências foram removidas, podemos deletar o TCC da tabela principal.
    $stmt_tcc = $gestor->prepare("DELETE FROM tcc WHERE id_tcc = :id_tcc");
    $stmt_tcc->bindParam(':id_tcc', $id_tcc_para_remover, PDO::PARAM_INT);
    $stmt_tcc->execute();

    // --- 6. Confirmação da Transação ---
    // Se ambos os comandos DELETE foram executados sem erros, nós efetivamos as mudanças no banco.
    $gestor->commit();

    // Redireciona de volta para a agenda com uma mensagem de sucesso.
    header("Location: agendaProfessor.php?status=tcc_removido_sucesso");
    exit();

} catch (PDOException $e) {
    // --- 7. Tratamento de Erro ---
    // Se qualquer um dos comandos dentro do 'try' falhar, o 'catch' é acionado.
    // O rollback desfaz qualquer alteração que tenha sido feita na transação.
    $gestor->rollBack();

    // Registra o erro para depuração (em um ambiente real, isso iria para um arquivo de log)
    error_log("Erro ao remover TCC: " . $e->getMessage());
    
    // Redireciona com uma mensagem de erro genérica para o usuário.
    header("Location: agendaProfessor.php?erro=remover_tcc_falha");
    exit();
}