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

use IteratorAggregate;
use Doctrine\DBAL\Driver\Statement as DoctrineStatement;
use Addiks\PHPSQL\PDO\Statement as InnerStatement;

class Statement implements IteratorAggregate, DoctrineStatement
{

    public function __construct(InnerStatement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @var InnerStatement
     */
    protected $statement;

    public function getIterator()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->getResult();
    }

    /**
     * Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional
     * placeholder in the SQL statement that was used to prepare the statement.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * @param mixed   $param Parameter identifier. For a prepared statement using named placeholders,
     *                       this will be a parameter name of the form :name. For a prepared statement
     *                       using question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed   $value The value to bind to the parameter.
     * @param integer $type  Explicit data type for the parameter using the PDO::PARAM_* constants.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function bindValue($param, $value, $type = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->bindValue($param, $value, $type);
    }

    /**
     * Binds a PHP variable to a corresponding named (not supported by mysqli driver, see comment below) or question
     * mark placeholder in the SQL statement that was use to prepare the statement. Unlike PDOStatement->bindValue(),
     * the variable is bound as a reference and will only be evaluated at the time
     * that PDOStatement->execute() is called.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * Most parameters are input parameters, that is, parameters that are
     * used in a read-only fashion to build up the query. Some drivers support the invocation
     * of stored procedures that return data as output parameters, and some also as input/output
     * parameters that both send in data and are updated to receive it.
     *
     * @param mixed        $column   Parameter identifier. For a prepared statement using named placeholders,
     *                               this will be a parameter name of the form :name. For a prepared statement using
     *                               question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed        $variable Name of the PHP variable to bind to the SQL statement parameter.
     * @param integer|null $type     Explicit data type for the parameter using the PDO::PARAM_* constants. To return
     *                               an INOUT parameter from a stored procedure, use the bitwise OR operator to set the
     *                               PDO::PARAM_INPUT_OUTPUT bits for the data_type parameter.
     * @param integer|null $length   You must specify maxlength when using an OUT bind
     *                               so that PHP allocates enough memory to hold the returned value.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function bindParam($column, &$variable, $type = null, $length = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->bindParam($column, $variable, $type, $length);
    }

    /**
     * Fetches the SQLSTATE associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorCode()
     *
     * @return string The error code string.
     */
    function errorCode()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->errorCode();
    }

    /**
     * Fetches extended error information associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorInfo()
     *
     * @return array The error info array.
     */
    function errorInfo()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->errorInfo();
    }

    /**
     * Executes a prepared statement
     *
     * If the prepared statement included parameter markers, you must either:
     * call PDOStatement->bindParam() to bind PHP variables to the parameter markers:
     * bound variables pass their value as input and receive the output value,
     * if any, of their associated parameter markers or pass an array of input-only
     * parameter values.
     *
     *
     * @param array|null $params An array of values with as many elements as there are
     *                           bound parameters in the SQL statement being executed.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function execute($parameters = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->execute($parameters);
    }

    /**
     * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
     * executed by the corresponding object.
     *
     * If the last SQL statement executed by the associated Statement object was a SELECT statement,
     * some databases may return the number of rows returned by that statement. However,
     * this behaviour is not guaranteed for all databases and should not be
     * relied on for portable applications.
     *
     * @return integer The number of rows.
     */
    function rowCount()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->rowCount();
    }

    /**
     * Closes the cursor, enabling the statement to be executed again.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function closeCursor()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        $statement->closeCursor();
    }

    /**
     * Returns the number of columns in the result set
     *
     * @return integer The number of columns in the result set represented
     *                 by the PDOStatement object. If there is no result set,
     *                 this method should return 0.
     */
    public function columnCount()
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->columnCount();
    }

    /**
     * Sets the fetch mode to use while iterating this statement.
     *
     * @param integer $fetchMode The fetch mode must be one of the PDO::FETCH_* constants.
     * @param mixed   $arg2
     * @param mixed   $arg3
     *
     * @return boolean
     *
     * @see PDO::FETCH_* constants.
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        $statement->setFetchMode($fetchMode, $arg2, $arg3);
    }

    /**
     * Returns the next row of a result set.
     *
     * @param integer|null $fetchMode Controls how the next row will be returned to the caller.
     *                                The value must be one of the PDO::FETCH_* constants,
     *                                defaulting to PDO::FETCH_BOTH.
     *
     * @return mixed The return value of this method on success depends on the fetch mode. In all cases, FALSE is
     *               returned on failure.
     *
     * @see PDO::FETCH_* constants.
     */
    public function fetch($fetchMode = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->fetch($fetchMode);
    }

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param integer|null $fetchMode Controls how the next row will be returned to the caller.
     *                                The value must be one of the PDO::FETCH_* constants,
     *                                defaulting to PDO::FETCH_BOTH.
     *
     * @return array
     *
     * @see PDO::FETCH_* constants.
     */
    public function fetchAll($fetchMode = null)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->fetchAll($fetchMode);
    }

    /**
     * Returns a single column from the next row of a result set or FALSE if there are no more rows.
     *
     * @param integer $columnIndex 0-indexed number of the column you wish to retrieve from the row.
     *                             If no value is supplied, PDOStatement->fetchColumn()
     *                             fetches the first column.
     *
     * @return string|boolean A single column in the next row of a result set, or FALSE if there are no more rows.
     */
    public function fetchColumn($columnIndex = 0)
    {
        /* @var $statement InnerStatement */
        $statement = $this->statement;

        return $statement->fetchColumn($columnIndex);
    }
}
