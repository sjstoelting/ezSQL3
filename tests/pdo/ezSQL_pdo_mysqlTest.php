<?php
require_once('ez_sql_loader.php');

require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

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
 * @author  Stefanie Janine Stoelting <mail@stefanie-stoelting.de>
 * @name    ezSQL_pdo_mysqlTest
 * @package ezSQL
 * @subpackage Tests
 * @license FREE / Donation (LGPL - You may do what you like with ezSQL - no exceptions.)
 */
class ezSQL_pdo_mysqlTest extends TestCase {

    /**
     * constant string user name
     */
    const TEST_DB_USER = 'ez_test';

    /**
     * constant string password
     */
    const TEST_DB_PASSWORD = 'ezTest';

    /**
     * constant string database name
     */
    const TEST_DB_NAME = 'ez_test';

    /**
     * constant string database host
     */
    const TEST_DB_HOST = 'localhost';

    /**
     * constant string database connection charset
     */
    const TEST_DB_CHARSET = 'utf8';

    /**
     * constant string database port
     */
    const TEST_DB_PORT = '5432';
    
    /**
     * constant string path and file name of the SQLite test database
     */
    const TEST_SQLITE_DB = 'ez_test.sqlite';

    /**
     * @var ezSQL_pdo
     */
    protected $object;
    private $errors;
 
    function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
        $this->errors[] = compact("errno", "errstr", "errfile",
            "errline", "errcontext");
    }

    function assertError($errstr, $errno) {
        foreach ($this->errors as $error) {
            if ($error["errstr"] === $errstr
                && $error["errno"] === $errno) {
                return;
            }
        }
        $this->fail("Error with level " . $errno .
            " and message '" . $errstr . "' not found in ", 
            var_export($this->errors, TRUE));
    }   

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        if (!extension_loaded('pdo_mysql')) {
            $this->markTestSkipped(
              'The pdo_mysql Lib is not available.'
            );
        }
        $this->object = new ezSQL_pdo();
    } // setUp

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->object = null;
    } // tearDown
 
     
    /**
     * Here starts the MySQL PDO unit test
     */

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testMySQLConnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));   
        $this->assertFalse($this->object->connect(null));
    } // testMySQLConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testMySQLQuick_connect() {
        $this->assertTrue($this->object->quick_connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testMySQLQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testMySQLSelect() {
        $this->assertTrue($this->object->select('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testMySQLSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testMySQLEscape() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is\'nt escaped.", $result);
    } // testMySQLEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testMySQLSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testMySQLSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testMySQLCatch_error() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertNull($this->object->catch_error());
    } // testMySQLCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testMySQLQuery() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testMySQLQuery
    
    /**
     * @covers ezSQLcore::insert
     */
    public function testInsert()
    {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
        $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))');
        
        $result = $this->object->insert('unit_test', array('id'=>'1', 'test_key'=>'test 1' ));
        $this->assertEquals(0, $result);
        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    }
       
    /**
     * @covers ezSQLcore::update
     */
    public function testUpdate()
    {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
        $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))');
        $this->object->insert('unit_test', array('id'=>'1', 'test_key'=>'test 1' ));
        $this->object->insert('unit_test', array('id'=>'2', 'test_key'=>'test 2' ));
        $this->object->insert('unit_test', array('id'=>'3', 'test_key'=>'test 3' ));
        $unit_test['test_key'] = 'testing';
        $where="id  =  1";
        $this->assertEquals($this->object->update('unit_test', $unit_test, $where), 1);
        $this->assertEquals($this->object->update('unit_test', $unit_test, eq('test_key','test 3', _AND), eq('id','3')), 1);
        $this->assertEquals($this->object->update('unit_test', $unit_test, "id = 4"), 0);
        $this->assertEquals($this->object->update('unit_test', $unit_test, "test_key  =  test 2  and", "id  =  2"), 1);
        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    }
    
    /**
     * @covers ezSQLcore::delete
     */
    public function testDelete()
    {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
        $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))');
        $unit_test['id'] = '1';
        $unit_test['test_key'] = 'test 1';
        $this->object->insert('unit_test', $unit_test );
        $unit_test['id'] = '2';
        $unit_test['test_key'] = 'test 2';
        $this->object->insert('unit_test', $unit_test );
        $unit_test['id'] = '3';
        $unit_test['test_key'] = 'test 3';
        $this->object->insert('unit_test', $unit_test );
        $where='1';
        $this->assertEquals($this->object->delete('unit_test', array('id','=','1')), 1);
        $this->assertEquals($this->object->delete('unit_test', 
            array('test_key','=',$unit_test['test_key'],'and'),
            array('id','=','3')), 1);
        $this->assertEquals($this->object->delete('unit_test', array('test_key','=',$where)), 0);
        $where="id  =  2";
        $this->assertEquals($this->object->delete('unit_test', $where), 1);
        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    }  

    /**
     * @covers ezSQLcore::selecting
     */
    public function testSelecting()
    {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
        $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))');
        $this->object->insert('unit_test', array('id'=>'1', 'test_key'=>'testing 1' ));
        $this->object->insert('unit_test', array('id'=>'2', 'test_key'=>'testing 2' ));
        $this->object->insert('unit_test', array('id'=>'3', 'test_key'=>'testing 3' ));
        
        $result = $this->object->selecting('unit_test');
        $i = 1;
        foreach ($result as $row) {
            $this->assertEquals($i, $row->id);
            $this->assertEquals('testing ' . $i, $row->test_key);
            ++$i;
        }
        
        $where=array('test_key','=','testing 2');
        $result = $this->object->selecting('unit_test', 'id', $where);
        foreach ($result as $row) {
            $this->assertEquals(2, $row->id);
        }
        
        $result = $this->object->selecting('unit_test', 'test_key', array( 'id','=','3' ));
        foreach ($result as $row) {
            $this->assertEquals('testing 3', $row->test_key);
        }
        
        $result = $this->object->selecting('unit_test', array ('test_key'), "id  =  1");
        foreach ($result as $row) {
            $this->assertEquals('testing 1', $row->test_key);
        }
        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } 
    
    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testMySQLDisconnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->object->disconnect();

        $this->assertFalse($this->object->isConnected());
    } // testMySQLDisconnect

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testMySQLConnectWithOptions() {
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );         
        
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD, $options));
    } // testMySQLConnectWithOptions

    /**
     * @covers ezSQL_pdo::get_set
     */
    public function testMySQLGet_set() {
        $expected = "test_var1 = '1', test_var2 = 'ezSQL test', test_var3 = 'This is\'nt escaped.'";
        
        $params = array(
            'test_var1' => 1,
            'test_var2' => 'ezSQL test',
            'test_var3' => "This is'nt escaped."
        );
        
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertequals($expected, $this->object->get_set($params));
    } // testMySQLGet_set

    /**
     * @covers ezSQL_pdo::__construct
     */
    public function test__Construct() {         
        $this->errors = array();
        set_error_handler(array($this, 'errorHandler'));    
        
        $pdo = $this->getMockBuilder(ezSQL_pdo::class)
        ->setMethods(null)
        ->disableOriginalConstructor()
        ->getMock();
        
        $this->assertNull($pdo->__construct('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));  
    } 
     
} // ezSQL_pdoTest