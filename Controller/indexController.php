<?php
namespace App\Model;
namespace App\Controller;

 function Check($url): VietnamnetParser|DantriParser|VnexpressParser
{
    switch(str_contains($url)){
        case "dantri.com.vn":
            return new DantriParser();
        case "vietnamnet.vn":
            return new VietnamnetParser();
        case "vnexpress.net":
            return new VnexpressParser();
        default:
            throw new Exception('Invalid parser type');
    }
}