<?php
namespace App\Controller;
// Parser for parsing content from the Dan Tri website

use Parser;
use DOMDocument;

class DantriParser extends Parser {

    // get class title  name from dan tri
    const  title_Dantri = 'title-page detail';
    // get class content from dan tri
    const  content_Dantri = 'fck_detail';
    // get class date from dan tri
    const  date_Dantri = 'date';
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
            $title = $this->getElementsByClass( self::title_Dantri);
            $content = $this->getElementsByClass(self::content_Dantri);
            $date = $this->getElementsByClass(self::date_Dantri);
            return ['title' => $title, 'content' => $content, 'date' => $date];
        }
        return null;
    }




}