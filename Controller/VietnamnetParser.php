<?php
namespace App\Controller;
use App\Model\Parser;
class VietnamnetParser extends Parser {
    protected function getTitleClass(): string {
        return 'content-detail-title';
    }

    protected function getContentClass(): string {
        return 'maincontent main-content';
    }

    protected function getDateClass(): string {
        return 'bread-crumb-detail__time';
    }

    public function parse(): ?array {
        $html = $this->getHtml();
        if (!empty($html)) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $title = $this->getElementsByClass($this->getTitleClass());
            $content = $this->getElementsByClass($this->getContentClass());
            $date = $this->getElementsByClass($this->getDateClass());
            return ['title' => $title, 'content' => $content, 'date' => $date];
        }
        return null;
    }
}