<?php

use Symfony\Component\Yaml\Yaml;

use Services\Db\PDO as myPDO;

class ModelTest extends \PHPUnit_Framework_TestCase
{

    protected $pdo;

    public function setUp()
    {
        $this->pdo = new myPDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS users
          (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR( 225 ),
            created_at DATETIME
          )
      ");

        $this->setData();

        require_once __DIR__ . '/_data/User.php';
    }

    protected function setData()
    {

        $data = Yaml::parse(__DIR__ . '/_data/seed.yml');

        $v = [];
        foreach ($data['users'] as $value) {
            $v[] = sprintf(" ('%s', '%s') ", $value['username'], $value['created_at']);
        }

        $v = implode(',', $v);

        $this->pdo->query(sprintf('INSERT INTO users (username, created_at) VALUES %s', $v));
    }

    /**
     * @test seeds create
     */
    public function testSeedsCreate()
    {
        $User = $this->pdo->setObject('User');
        $this->assertEquals(2, count($User->all()));
    }

    /**
     * @test save method insert
     */
    public function testInsertSave()
    {

        $User = $this->pdo->setObject('User');
        $User->username = 'Taylor';
        $User->save();

        $this->assertEquals(1, count($User->query(['username' => 'Taylor'])));
    }

    /**
     * @test save method update
     */
    public function testUpdateSave()
    {

        $User = $this->pdo->setObject('User');
        $User->id = 1;
        $User->username = 'Galois';
        $User->save();

        $this->assertEquals(1, count($User->query(['username' => 'Galois'])));
    }

    /**
     * @test delete resource by id
     */
    public function testDelete()
    {

        $User = $this->pdo->setObject('User');
        $User->delete(1);

        $this->assertTrue(!$User->find(1));

    }

}