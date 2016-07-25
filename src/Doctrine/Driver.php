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

use PDOException;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver as DoctrineDriver;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\DBAL\Connection;
use Addiks\PHPSQL\PDO\PDO;
use Addiks\PHPSQLBundle\Doctrine\Connection as PHPSQLBundleConnection;

class Driver implements DoctrineDriver
{
    /**
     * Attempts to create a connection with the database.
     *
     * @param array       $params        All connection parameters passed by the user.
     * @param string|null $username      The username to use when connecting.
     * @param string|null $password      The password to use when connecting.
     * @param array       $driverOptions The driver options to use when connecting.
     *
     * @return \Doctrine\DBAL\Driver\Connection The database connection.
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        try {
            /* @var $dbname string */
            $dbname = "default";

            if (isset($params['dbname'])) {
                $dbname = $params['dbname'];
            }

            var_dump("NEW CONNECTION");

            $pdo = new PDO("inmemory:{$dbname}");

            $conn = new PHPSQLBundleConnection($pdo);

        } catch (PDOException $e) {
            throw DBALException::driverException($this, $e);
        }

        return $conn;
    }

    /**
     * Gets the DatabasePlatform instance that provides all the metadata about
     * the platform this driver connects to.
     *
     * @return \Doctrine\DBAL\Platforms\AbstractPlatform The database platform.
     */
    public function getDatabasePlatform()
    {
        return new MySqlPlatform();
    }

    /**
     * Gets the SchemaManager that can be used to inspect and change the underlying
     * database schema of the platform this driver connects to.
     *
     * @param Connection $conn
     *
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    public function getSchemaManager(Connection $conn)
    {
        return new MySqlSchemaManager($conn);
    }

    /**
     * Gets the name of the driver.
     *
     * @return string The name of the driver.
     */
    public function getName()
    {
        return "phpsql";
    }

    /**
     * Gets the name of the database connected to for this driver.
     *
     * @param Connection $conn
     *
     * @return string The name of the database.
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        if (isset($params['dbname'])) {
            return $params['dbname'];
        }

        return $conn->query('SELECT DATABASE()')->fetchColumn();
    }
}
