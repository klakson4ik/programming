<?php

namespace App\Web\User\Widgets\Social\Share;

class Share
{
    public static function getShare(){
      $share = new ShareModel();
      $share = $share->getShare();
      return $share;
    }
}
