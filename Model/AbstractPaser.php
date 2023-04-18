<?php
abstract class Parser {
    protected $url;

    public function __construct($url) {
        $this->url = $url;
    }

    abstract protected function getTitleClass(): string;
    abstract protected function getContentClass(): string;
    abstract protected function getDateClass(): string;

    abstract public function parse(): ?array;

    protected function getHtml(): string {
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
        return strip_tags(implode(array_map([$node->ownerDocument, "saveHTML"],
            iterator_to_array($node->childNodes))));
    }
}