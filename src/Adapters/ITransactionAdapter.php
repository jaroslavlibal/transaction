<?php

namespace JaroslavLibal\Transaction\Adapters;

/**
 * @author Jaroslav Líbal <mail@jaroslavlibal.cz>
 */
interface ITransactionAdapter
{
    /**
     * Begins a transaction (if supported).
     *
     * @param string $savepoint optional savepoint name
     */
    public function begin($savepoint = null);

    /**
     * Commits statements in a transaction.
     *
     * @param  string $savepoint optional savepoint name
     */
    public function commit($savepoint = null);

    /**
     * Rollback changes in a transaction.
     *
     * @param  string $savepoint optional savepoint name
     */
    public function rollback($savepoint = null);
}
