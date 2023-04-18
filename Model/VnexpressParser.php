<?php
namespace App\Controller;
use CheckUrlController;
use DOMDocument;

class VnexpressParser extends CheckUrlController {
    // get class  title from vnexpress
    const title_Vnexpress = 'title-detail';
    // get class content from vnexpress
    const content_Vnexpress = 'fck_detail';
    // get class date
    const date_Vnexpress = 'date';
    /**
     * @inheritDoc
     */
    public function parse(): ?array {
        $html = $this->getHtml();
        if (!empty($html)) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $title = $this->getElementsByClass(self::title_Vnexpress);
            $content = $this->getElementsByClass(self::content_Vnexpress);
            $date = $this->getElementsByClass(self::date_Vnexpress);
            return ['title' => $title, 'content' => $content, 'date' => $date];
        }
        return null;
    }
}