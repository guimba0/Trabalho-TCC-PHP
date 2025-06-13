<?php

/**
 * Classe Model Abstrata.
 * Serve como base para todas as outras classes que representam tabelas do banco.
 * Seu objetivo é centralizar a conexão com o banco de dados.
 * 'abstract' significa que esta classe não pode ser instanciada diretamente, apenas herdada.
 */
abstract class Model
{
    /**
     * @var PDO|null $gestor A conexão PDO com o banco de dados.
     * 'protected' significa que esta propriedade só pode ser acessada pela própria classe Model e por suas classes filhas (como a Tcc).
     * 'static' significa que esta propriedade pertence à classe em si, e não a um objeto individual. Teremos uma única conexão para todos.
     */
    protected static ?PDO $gestor = null;

    /**
     * Método para injetar a conexão do banco de dados na nossa classe.
     * @param PDO $pdo A instância da conexão PDO.
     */
    public static function setDatabase(PDO $pdo): void
    {
        self::$gestor = $pdo;
    }
}