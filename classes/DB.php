<?php 

 class DB 
{
	public $pdo;

	public function connect()
	{
		try {
			$this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
		} catch (Exception $e) {
			echo "Произошла ошибка при загрузке базы данных.";
		exit;
		}	
	}

	public function createTable()
	{	$sql = "CREATE TABLE ".$_POST['table_name']."(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		reg_date TIMESTAMP
		)";
		$sth = $this->pdo->prepare ($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
	}

	public function getList()
    {
        $sth = $this->pdo->prepare('SHOW TABLES');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInfo($table)
    {
        $sth = $this->pdo->prepare('DESCRIBE '. $table);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function renameField()
    {
    	$sth = $this->pdo->prepare('ALTER TABLE '.$_SESSION['table'].' CHANGE '.$_SESSION['old_name'].' '.$_POST['new_name_field'].' '.$_SESSION['type']);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteField()
    {
    	$sth = $this->pdo->prepare('ALTER TABLE '.$_SESSION['table'].' DROP COLUMN '.$_POST['select_del']);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}

 	
 ?>