<?php
//class ParserModel {
//    protected $conn;
//    const host = 'localhost';
//    const username = 'toanlt';
//    const password = 'Toanlt123';
//    const dbname = 'Parser';
//    /**
//     * connect to database
//     * @param string $host
//     * @param string $username
//     * @param string $password
//     * @param string $dbname
//     */
//    public function __construct($host, $username, $password, $dbname) {
//
//        $this->conn = mysqli_connect($host, $username, $password, $dbname);
//    }
//
//    /**
//     * run a query
//     * @param $sql
//     * @return bool|mysqli_result|void
//     */
//    public function query($sql) {
//        try {
//            return mysqli_query($this->conn, $sql);
//        } catch (mysqli_sql_exception $e) {
//            echo 'Error: ' . $e->getMessage();
//        }
//    }
//
//    /**
//     *filter special characters
//     * @param $value
//     * @return string
//     */
//    public function escape($value): string
//    {
//        return mysqli_real_escape_string($this->conn, $value);
//    }
//    public function getParser($id){
//        $sql = "SELECT * FROM `wrapper`";
//        $stmt = $this->conn->prepare($sql);
//        $stmt->bind_param('i', $id);
//        $stmt->execute();
//        $result = $stmt->get_result();
//        if($result->num_rows > 0){
//            return $result->fetch_assoc();
//        }
//        return false;
//
//    }
//
//    /**
//     * @param $title
//     * @param $content
//     * @param $data
//     */
//    public function CrateParser($title, $content, $data)
//    {
//        global $db;
//        $title = $this->escape($data['title']);
//        $content =$this->escape($data['content']);
//        $date = $this->escape($data['date']);
//        $sql = "INSERT INTO `wrapper`(`title`,`content`,`thoi_gian`) VALUES($title,$content,$date)";
//        $db->query($sql);
//    }
//}
class Parser {
    protected $url;

    public function __construct($url) {

        $this->url = $url;


    }
    /**
     * check url
     * @return bool|string
     */
//Get the HTML content
    public function getHtml(): string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }
//Get the elements in the HTML document

    /**
     * get class check html document
     * @param  string $class
     * @return string|null
     */
    protected function getElementsByClass(string $class): ?string {
        $html = $this->getHtml();
        if (!empty($html)) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $finder = new DomXPath($dom);
            $node = $finder->query("//*[contains(@class, '$class')]")->item(0);
            if ($node) {
                return $this->innerHTML($node);
            }
        }
        return null;
    }

    /**
     * get the innerHTML of a node
     *
     * @param DOMNode $node
     * @return string
     */
    public function innerHTML(DOMNode $node) {
        return strip_tags( implode(array_map([$node->ownerDocument, "saveHTML"],
            iterator_to_array($node->childNodes))));
    }

    /**
     * Parse html to array or null  if html is null
     * @return array|null
     * @throws Exception
     */
    public function parse(): ?array {
        throw new Exception('Not implemented');
    }
}