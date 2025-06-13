<?php
// classes/Tcc.php

/**
 * Classe para representar a entidade TCC.
 * Ela agrupa os dados e os comportamentos relacionados a um TCC.
 */
class Tcc extends Model
{
    // --- ATRIBUTOS (PROPRIEDADES) ---
    // Correspondem principalmente às colunas da tabela `tcc`
    public ?int $id_tcc = null;
    public ?string $titulo = null;
    public ?string $resumo = null;
    public ?int $id_tipoTCC = null;
    public ?string $RA_aluno = null;
    public ?string $RA_aluno2 = null;
    public ?string $RA_aluno3 = null;
    public ?int $id_professor_orientador = null;

    // Atributos extras que podem ser preenchidos por JOINs com outras tabelas
    public ?string $tipo_tcc_descricao = null;
    public ?string $aluno1_nome = null;
    public ?string $aluno2_nome = null;
    public ?string $aluno3_nome = null;

    /**
     * --- MÉTODO CONSTRUTOR ---
     * É chamado automaticamente quando um novo objeto Tcc é criado (com 'new Tcc()').
     * Aqui, usamos para preencher o objeto com dados de um array, se for o caso.
     */
    public function __construct(array $dados = [])
    {
        $this->id_tcc = $dados['id_tcc'] ?? null;
        $this->titulo = $dados['titulo'] ?? null;
        $this->resumo = $dados['resumo'] ?? null;
        $this->tipo_tcc_descricao = $dados['tipo_tcc_descricao'] ?? null;
        $this->aluno1_nome = $dados['aluno1_nome'] ?? null;
        $this->aluno2_nome = $dados['aluno2_nome'] ?? null;
        $this->aluno3_nome = $dados['aluno3_nome'] ?? null;
    }

    /**
     * --- MÉTODO ---
     * Um exemplo de "comportamento". Esta função pertence ao objeto Tcc
     * e formata a lista de nomes dos alunos.
     */
    public function getAlunosNomes(): string
    {
        $nomes = [];
        if (!empty($this->aluno1_nome)) {
            $nomes[] = $this->aluno1_nome;
        }
        if (!empty($this->aluno2_nome)) {
            $nomes[] = $this->aluno2_nome;
        }
        if (!empty($this->aluno3_nome)) {
            $nomes[] = $this->aluno3_nome;
        }
        return implode(', ', $nomes);
    }
}