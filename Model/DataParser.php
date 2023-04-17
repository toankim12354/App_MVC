<?php
use App\Controller\VnexpressParser;
use App\Controller\DantriParser;
use App\Controller\VietnamnetParser;
use App\Model\Parser;
//connect dtabasea
class DatabaseConnection {

    protected $conn;

    public function __construct($host, $username, $password, $dbname) {
        $db = new DatabaseConnection('localhost', 'toanlt', 'Toanlt123', 'Parser');
        $this->conn = mysqli_connect($host, $username, $password, $dbname);
    }

    public function query($sql) {
        try {
            $data =
            $title = $db->escape($data['title']);
            $content = $db->escape($data['content']);
            $date = $db->escape($data['date']);
            $sql = "INSERT INTO wrapper (title, content, thoi_gian) VALUES ('$title', '$content', '$date')";

            $db->query($sql);
            return mysqli_query($this->conn, $sql);
        } catch (mysqli_sql_exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function escape($value) {
        return mysqli_real_escape_string($this->conn, $value);
    }
}