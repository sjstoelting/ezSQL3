<?php

require_once dirname(__FILE__) . '/../../../shared/ez_sql_core.php';
require_once dirname(__FILE__) . '/../../../pdo/ez_sql_pdo.php';

/**
 * Test class for ezSQL_pdo.
 * Generated by PHPUnit on 2012-04-02 at 00:23:22.
 */
/**
 * Test class for ezSQL_pdo.
 * Generated by PHPUnit
 *
 * Needs database tear up to run test, that creates database and a user with
 * appropriate rights.
 * Run database tear down after tests to get rid of the database and the user.
 * The PDO tests where done with a PostgreSQL database, please use the scripts
 * of PostgreSQL
 *
 * @author  Stefanie Janine Stoelting (mail@stefanie-stoelting.de)
 * @name    ezSQL_pdoTest
 * @uses    postgresql_test_db_tear_up.sql
 * @uses    postgresql_test_db_tear_down.sql
 * @package ezSQL
 * @subpackage unitTests
 * @license FREE / Donation (LGPL - You may do what you like with ezSQL - no exceptions.)
 */
class ezSQL_pdoTest extends PHPUnit_Framework_TestCase {

    /**
     * constant string user name
     */
    const TEST_DB_USER = 'ez_test';

    /**
     * constant string password
     */
    const TEST_DB_PASSWORD = 'ezTest';

    /**
     * constant database name
     */
    const TEST_DB_NAME = 'ez_test';

    /**
     * constant database host
     */
    const TEST_DB_HOST = 'localhost';

    /**
     * constant database connection charset
     */
    const TEST_DB_CHARSET = 'utf8';

    /**
     * constant database port
     */
    const TEST_DB_PORT = '5434';

    /**
     * @var ezSQL_pdo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new ezSQL_pdo;
    } // setUp

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->object = null;
    } // tearDown
    
    /**
     * @covers ezSQL_pdo::connect
     */
    public function testPosgreSQLConnect() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testPosgreSQLQuick_connect() {
        $this->assertTrue($this->object->quick_connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testPosgreSQLSelect() {
        $this->assertTrue($this->object->select('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testPosgreSQLEscape() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is''nt escaped.", $result);
    } // testEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testPosgreSQLSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testPosgreSQLCatch_error() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertNull($this->object->catch_error());
    } // testCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testPosgreSQLQuery() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testQuery

    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testPosgreSQLDisconnect() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->object->disconnect();

        $this->assertTrue(true);
    } // testDisconnect

    /**
     * Here starts the PostgreSQL PDO unit test
     */

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testMySQLConnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testMySQLQuick_connect() {
        $this->assertTrue($this->object->quick_connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testMySQLSelect() {
        $this->assertTrue($this->object->select('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testMySQLEscape() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is\'nt escaped.", $result);
    } // testEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testMySQLSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testMySQLCatch_error() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertNull($this->object->catch_error());
    } // testCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testMySQLQuery() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testQuery

    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testMySQLDisconnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->object->disconnect();

        $this->assertTrue(true);
    } // testDisconnect

} // ezSQL_pdoTest