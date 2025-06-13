<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conexaoBancoDados.php';
session_start();

// Segurança: Apenas professor logado
if (!isset($_SESSION['cod_prof'])) {
    header("Location: entrada_professor.php");
    exit();
}

// Validação: Garante que um ID numérico foi passado
if (!isset($_GET['id_tcc']) || !filter_var($_GET['id_tcc'], FILTER_VALIDATE_INT)) {
    header("Location: agendaProfessor.php?erro=id_invalido");
    exit();
}

$id_tcc = (int)$_GET['id_tcc'];

try {
    // 1. Busca os dados atuais do TCC que será editado
    $stmt_tcc = $gestor->prepare("SELECT * FROM TCC WHERE id_tcc = :id_tcc");
    $stmt_tcc->execute([':id_tcc' => $id_tcc]);
    $tcc_atual = $stmt_tcc->fetch(PDO::FETCH_ASSOC);

    // Se o TCC não for encontrado, redireciona
    if (!$tcc_atual) {
        header("Location: agendaProfessor.php?erro=tcc_nao_encontrado");
        exit();
    }

    // 2. Busca as listas de alunos, professores e tipos (para os dropdowns)
    $stmt_alunos = $gestor->query("SELECT RA, Nome FROM Aluno ORDER BY Nome ASC");
    $alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

    $stmt_professores = $gestor->query("SELECT id_professor, Nome FROM Professor ORDER BY Nome ASC");
    $professores = $stmt_professores->fetchAll(PDO::FETCH_ASSOC);

    $stmt_tipos = $gestor->query("SELECT id_tipoTCC, nome_Tipo FROM tipotcc ORDER BY nome_Tipo ASC");
    $tipos = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar dados para edição: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar TCC</title>
    <link rel="stylesheet" href="Estilo/estilo.css">
</head>
<body>
    <header>
        <h1>Editar TCC</h1>
        <nav>
            <a href="agendaProfessor.php">Voltar para a Agenda</a> |
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <form action="atualizar_tcc.php" method="POST">
            
            <input type="hidden" name="id_tcc" value="<?php echo $tcc_atual['id_tcc']; ?>">

            <label for="titulo">Título do TCC:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tcc_atual['titulo']); ?>" required>

            <label for="resumo">Resumo do TCC:</label>
            <textarea id="resumo" name="resumo" rows="5" required><?php echo htmlspecialchars($tcc_atual['resumo']); ?></textarea>

            <label for="id_tipoTCC">Tipo de TCC:</label>
            <select id="id_tipoTCC" name="id_tipoTCC" required>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo $tipo['id_tipoTCC']; ?>" <?php echo ($tipo['id_tipoTCC'] == $tcc_atual['id_tipoTCC']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tipo['nome_Tipo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="RA_aluno">Aluno 1 (Principal):</label>
            <select id="RA_aluno" name="RA_aluno" required>
                <?php foreach ($alunos as $aluno): ?>
                    <option value="<?php echo $aluno['RA']; ?>" <?php echo ($aluno['RA'] == $tcc_atual['RA_aluno']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aluno['Nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="RA_aluno2">Aluno 2 (Opcional):</label>
            <select id="RA_aluno2" name="RA_aluno2">
                <option value="">Não selecionar</option>
                <?php foreach ($alunos as $aluno): ?>
                    <option value="<?php echo $aluno['RA']; ?>" <?php echo ($aluno['RA'] == $tcc_atual['RA_aluno2']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aluno['Nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="RA_aluno3">Aluno 3 (Opcional):</label>
            <select id="RA_aluno3" name="RA_aluno3">
                <option value="">Não selecionar</option>
                <?php foreach ($alunos as $aluno): ?>
                    <option value="<?php echo $aluno['RA']; ?>" <?php echo ($aluno['RA'] == $tcc_atual['RA_aluno3']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aluno['Nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_professor_orientador">Professor Orientador:</label>
            <select id="id_professor_orientador" name="id_professor_orientador" required>
                <?php foreach ($professores as $professor): ?>
                    <option value="<?php echo $professor['id_professor']; ?>" <?php echo ($professor['id_professor'] == $tcc_atual['id_professor_orientador']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($professor['Nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Atualizar TCC</button>
        </form>
    </main>
</body>
</html>