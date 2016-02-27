<?php

namespace JaroslavLibal\Transaction\Adapters;


/**
 * @author Jaroslav Líbal <mail@jaroslavlibal.cz>
 */
class DibiTransactionAdapter implements ITransactionAdapter
{
    /** @var DibiConnection */
    public $database;

    /**
     * @param DibiConnection $database
     */
    public function __construct(DibiConnection $database)
    {
        $this->database = $database;
    }

    /**
     * Begins a transaction (if supported).
     *
     * @param  string $savepoint optional savepoint name
     */
    public function begin($savepoint = null)
    {
        $this->database->begin($savepoint);
    }

    /**
     * Commits statements in a transaction.
     *
     * @param  string $savepoint optional savepoint name
     */
    public function commit($savepoint = null)
    {
        $this->database->commit($savepoint);
    }

    /**
     * Rollback changes in a transaction.
     *
     * @param  string $savepoint optional savepoint name
     */
    public function rollback($savepoint = null)
    {
        $this->database->rollback($savepoint);
    }
}
