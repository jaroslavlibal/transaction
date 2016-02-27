<?php

namespace JaroslavLibal\Transaction;

use JaroslavLibal\Transaction\Adapters\ITransactionAdapter;

class Transaction
{

    const SAVEPOINT_PREFIX = 'TRANSACTION_SAVEPOINT_';

    /**
     * Transaction nesting level
     * @var int
     */
    private $nestingLevel = 0;

    /** @var ITransactionAdapter */
    private $adapter;

    /**
     * @param ITransactionAdapter $adapter
     */
    public function __construct(ITransactionAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return int
     */
    public function getNestingLevel()
    {
        return $this->nestingLevel;
    }

    /**
     * Generate the savepoint name
     * @return string
     */
    private function getActualSavepointName()
    {
        return self::SAVEPOINT_PREFIX . $this->nestingLevel;
    }

    /**
     * Begin the database transaction
     */
    public function begin()
    {
        ++$this->nestingLevel;

        if ($this->nestingLevel === 1) {
            $this->adapter->begin();
        } else {
            $this->adapter->begin($this->getActualSavepointName());
        }
    }

    /**
     * Commit the database transaction
     */
    public function commit()
    {
        if ($this->nestingLevel === 0) {
            throw new \Exception('There is no active transaction.');
        }

        if ($this->nestingLevel === 1) {
            $this->adapter->commit();
        } else {
            $this->adapter->commit($this->getActualSavepointName());
        }

        --$this->nestingLevel;
    }

    /**
     * Rollback the database transaction
     */
    public function rollback()
    {
        if ($this->nestingLevel === 0) {
            throw new \Exception('There is no active transaction.');
        }

        if ($this->nestingLevel === 1) {
            $this->adapter->rollback();
        } else {
            $this->adapter->rollback($this->getActualSavepointName());
        }

        --$this->nestingLevel;
    }

}
