<?php
interface ParserFactoryInterface {
    public function create(string $type): ParserInterface;
}

class ParserFactory implements ParserFactoryInterface {
    public function create(string $type): ParserInterface {
        switch ($type) {
            case 'vnexpress':
                return new VnexpressParser();
            case 'dantri':
                return new DantriParser();
            case 'vietnamnet':
                return new VietnamnetParser();
            default:
                throw new Exception('Invalid parser type');
        }
    }
}
interface ParserInterface {
    public function parse(): ?array;
}

class Parser implements ParserInterface {
    protected $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function getHtml(): string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;

    }

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

    public function innerHTML(DOMNode $node) {
        return strip_tags( implode(array_map([$node->ownerDocument, "saveHTML"],
            iterator_to_array($node->childNodes))));

    }

    public function parse(): ?array {
        throw new Exception('Not implemented');
    }
}
