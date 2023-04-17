<?php
namespace App\Controller;
class VnexpressParser extends Parser {
    protected function getTitleClass(): string {
        return 'title-detail';
    }

    protected function getContentClass(): string {
        return 'fck_detail';
    }

    protected function getDateClass(): string {
        return 'date';
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