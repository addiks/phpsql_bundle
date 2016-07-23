<?php
/**
 * Copyright (C) 2015  Gerrit Addiks.
 * This package (including this file) was released under the terms of the GPL-3.0.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/> or send me a mail so i can send you a copy.
 * @license GPL-3.0
 * @author Gerrit Addiks <gerrit@addiks.de>
 */

namespace Addiks\PHPSQLBundle\Doctrine;

use Doctrine\DBAL\Driver\Connection as DoctrineConnection;
use Doctrine\DBAL\Driver\Statement as DoctrineStatement;
use Addiks\PHPSQL\PDO\PDO;
use Addiks\PHPSQL\PDO\Statement as PHPSQLInnerStatement;
use Addiks\PHPSQLBundle\Doctrine\PHPSQLDoctrineStatement;

class Connection implements DoctrineConnection
{

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Prepares a statement for execution and returns a Statement object.
     *
     * @param string $prepareString
     *
     * @return DoctrineStatement
     */
    function prepare($prepareString)
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        var_dump($prepareString);

        /* @var $statement PHPSQLInnerStatement */
        $statement = $pdo->prepare($prepareString);

        return new PHPSQLStatement($statement);
    }

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     *
     * @return DoctrineStatement
     */
    function query()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        $parameters = func_get_args();

        /* @var $statementString string */
        $statementString = array_shift($parameters);

        var_dump($statementString);

        /* @var $statement PHPSQLInnerStatement */
        $statement = $pdo->query($statementString, $parameters);

        return new PHPSQLStatement($statement);
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param string  $input
     * @param integer $type
     *
     * @return string
     */
    function quote($input, $type=\PDO::PARAM_STR)
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        /* @var $output string */
        $output = $pdo->quote($input, $type);

        return $output;
    }

    /**
     * Executes an SQL statement and return the number of affected rows.
     *
     * @param string $statement
     *
     * @return integer
     */
    function exec($statement)
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        var_dump($statement);

        return $pdo->exec($statement);
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param string|null $name
     *
     * @return string
     */
    function lastInsertId($name = null)
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->lastInsertId($name);
    }

    /**
     * Initiates a transaction.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function beginTransaction()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->beginTransaction();
    }

    /**
     * Commits a transaction.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function commit()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function rollBack()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->rollBack();
    }

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    function errorCode()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->errorCode();
    }

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return array
     */
    function errorInfo()
    {
        /* @var $pdo PDO */
        $pdo = $this->pdo;

        return $pdo->errorInfo();
    }
}
