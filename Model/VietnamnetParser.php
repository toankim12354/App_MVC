<?php
namespace App\Controller;
use CheckUrlController;
use DOMDocument;

class VietnamnetParser extends CheckUrlController {

    // get class title  name from vietnamnet
    const title_Vietnamnet = 'content-detail-title';
    // get class content from vietnamnet
    const content_Vietnamnet = 'maincontent main-content';
    // get class date from vietnamnet
    const date_Vietnamnet = 'bread-crumb-detail__time';
    /**
     * @inheritDoc
     */
    public function parse(): ?array
    {
        $html = $this->getHtml();
        if (!empty($html)) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $title  = $this->getElementsByClass( self::title_Vietnamnet);
            // Get the content
            $content = $this->getElementsByClass( self::content_Vietnamnet);
            // Get the publication
            $date = $this->getElementsByClass( self::date_Vietnamnet);
            return ['title' => $title,'content' => $content, 'date' => $date];
        }
        return null;
    }
}