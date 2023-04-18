<?php
class CheckUrlController {

    public function URl($url){
        switch (true) {
            case str_contains($url, "dantri.com.vn"):
                return new DantriParser();
            case str_contains($url, "vietnamnet.vn"):
                return new VietnamnetParser();
            case str_contains($url, "vnexpress.net"):
                return new VnexpressParser();
            default:
                throw new Exception('Invalid parser type');
        }

    }

}