<?php
Class Database 
{
    private $connection;

    private function openConnection()
    {
        $dbHost = "localhost";
        $dbPort = 3306;
        $dbUsername = getenv('MYSQL_DB_USERNAME');
        $dbPassword = getenv('MYSQL_DB_PASSWORD');
        $dbName = "householdtasks";

        $this->connection = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUsername, $dbPassword, 
        array(
            PDO::MYSQL_ATTR_SSL_CA => DIR_PATH.'cacert.pem',
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        ));

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function closeConnection()
    {
        $this->connection = null;
    }

    public function getResultSet($query, $parameters = array())
    {
        $this->openConnection();

        $sql = $this->connection->prepare($query);

        foreach ($parameters as $parameter)
        {
            $sql->bindParam($parameter['name'], $parameter['value']);
        }

        $sql->execute();

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $result = $sql->fetchAll();

        $this->closeConnection();

        return $result;
    }

    public function executeStatement($query, $parameters = array())
    {
        $this->openConnection();

        $sql = $this->connection->prepare($query);

        foreach ($parameters as $parameter)
        {
            $sql->bindParam($parameter['name'], $parameter['value']);
        }

        $sql->execute();

        $this->closeConnection();
    }
}
?>