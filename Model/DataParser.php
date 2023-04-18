<?php
global $db;

class DatabaseConnection {
    /**
     * @var false|mysqli
     */
    protected $conn;

    /**
     * connect to database
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $dbname
     */
    public function __construct($host, $username, $password, $dbname) {
        $this->conn = mysqli_connect($host, $username, $password, $dbname);
    }
//data processed with in the database

    /**
     * run a query
     * @param $sql
     * @return bool|mysqli_result|void
     */
    public function query($sql) {
        try {
            return mysqli_query($this->conn, $sql);
        } catch (mysqli_sql_exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     *filter special characters
     * @param $value
     * @return string
     */
    public function escape($value) {
        return mysqli_real_escape_string($this->conn, $value);
    }
}
$data = $this->parse();
$title = $this->escape($data['title']);
$content = $this->escape($data['content']);
$date = $this->escape($data['date']);
if(!empty($data)) {
    $sql = "INSERT INTO wrapper (title, content, thoi_gian) VALUES ('$title', '$content', '$date')";
    $db->query($sql);

} else {
    // handle the case where $date is empty
    echo "not data";
}
$db = new DatabaseConnection('localhost', 'toanlt', 'Toanlt123', 'Parser');