<?php

require_once 'manipulateDB.php';
use PHPUnit\Framework\TestCase;

class WorkingWithDBTest extends TestCase {

    private $dbMock;

    protected function setUp() {
        $this->dbMock = $this->createMock(Db::class);
    }

    public function testLoginValidCredentials() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock); 

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['test@gmail.com', 'password'])
            ->willReturn(true);

        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']]);

        $workingWithDB = new WorkingWithDB($this->dbMock);
        $result = $workingWithDB->login('test@gmail.com', 'password');
        $this->assertEquals([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']], $result);
    }

    public function testLoginInvalidCredentials() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock); 
        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['test@gmail.com', 'password'])
            ->willReturn(true);

        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([]);

        $workingWithDB = new WorkingWithDB($this->dbMock);
        $result = $workingWithDB->login('test@gmail.com', 'password');
        $this->assertEquals("-1", $result);
    }
    
    public function testInsertUser() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock);

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['Test', 'test@gmail.com', 'password', $this->anything()])
            ->willReturn(true);
        $workingWithDB = new WorkingWithDB($this->dbMock);
        $workingWithDB->insertUser('Test', 'test@gmail.com', 'password');
        $this->expectNotToPerformAssertions();
    }

    public function testGetUser() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock);

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['test@gmail.com'])
            ->willReturn(true);

        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']]);
        $workingWithDB = new WorkingWithDB($this->dbMock);
        $result = $workingWithDB->getUser('test@gmail.com');
        $this->assertEquals([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']], $result);
    }

    public function testGetUsers() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock); 

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock); 
        $stmtMock->expects($this->once())
            ->method('execute')
            ->with([])
            ->willReturn(true); 

        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']]);

        $workingWithDB = new WorkingWithDB($this->dbMock);
        $result = $workingWithDB->getUsers();
        $this->assertEquals([['id' => 1, 'name' => 'test_user', 'password' => 'password', 'email' => 'test@gmail.com', 'active' => 1, 'activation_code' => 'code']], $result);
    }

    public function testUpdateUser() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock);

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['Test', 'newpassword', 'test@gmail.com'])
            ->willReturn(true);

        $workingWithDB = new WorkingWithDB($this->dbMock);
        $workingWithDB->updateUser('test@gmail.com', 'Test', 'newpassword');
        $this->expectNotToPerformAssertions();
    }

    public function testValidateUser() {
        $pdoMock = $this->createMock(PDO::class);
        $this->dbMock->expects($this->once())
            ->method('getConnection')
            ->willReturn($pdoMock);

        $stmtMock = $this->createMock(PDOStatement::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with(['test@gmail.com'])
            ->willReturn(true);
        $workingWithDB = new WorkingWithDB($this->dbMock);
        $workingWithDB->validateUser('test@gmail.com');
        $this->expectNotToPerformAssertions();
    }
}

?>
