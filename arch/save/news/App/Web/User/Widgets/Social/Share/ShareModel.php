<?php
namespace App\Web\User\Widgets\Social\Share;


class ShareModel
{
  private $id;
  private $url;
  private $share = [];
  private $news = [];
  private $title;
  private $description;
  private $tags;
  private $login;


  public function __construct(){
    $this->id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $this->url = 'https://gonomax.com/news/index?id=' . $this->id;
    $this->share['url'] = $this->url;
    $this->news = $_SESSION['news']['article'];
    $this->description = $this->news['description'];
    $this->title = $this->news['title'];
    $this->tags = $this->hashtagsCreate();
    $this->login = 'gonomax';
    $this->share['description'] = $this->description;
    $this->share['title'] = $this->title;
    $this->share['tags'] = $this->tags;
    $this->share['login'] = $this->login;
    $this->facebook();
    $this->twitter();
  }

  private function facebook(){
    $st = '<meta property=';
    $meta = $st . '"og:locale" content="en_US"/>' . PHP_EOL; 
    $meta .= $st . '"og:type" content="article"/>' . PHP_EOL; 
    $meta .= $st . '"og:title" content="'. $this->title .'"/>' . PHP_EOL; 
    $meta .= $st . '"og:description" content="'. $this->description .'"/>' . PHP_EOL; 
    $meta .= $st . '"og:image" content="'. $this->news['image_full'] .'"/>' . PHP_EOL; 
    $meta .= $st . '"og:url" content="'. $this->url .'"/>' . PHP_EOL; 
    $meta .= $st . '"og:site_name" content="gonomax"/>' . PHP_EOL; 
    $_SESSION['facebook'] = $meta;
  }

  private function twitter(){
    $st = '<meta name=';
    $meta = $st . '"twitter:card" content="summary_large_image"/>' . PHP_EOL; 
    $meta .= $st . '"twitter:site" content="gonomaxnews"/>' . PHP_EOL; 
    $meta .= $st . '"twitter:creator" content="gonomax"/>' . PHP_EOL; 
    $meta .= $st . '"twitter:title" content="'. $this->title .'"/>' . PHP_EOL; 
    $meta .= $st . '"twitter:description" content="'. $this->description .'"/>' . PHP_EOL; 
    $meta .= $st . '"twitter:image" content="'. $this->news['image_full'] .'"/>' . PHP_EOL; 
    $_SESSION['twitter'] = $meta;
  }

  private function hashtagsCreate(){
    $array = explode(',', $this->news['keywords'], 6);
    $result = [];
    $count = 1;
    foreach($array as $key=>$each){
      if($count > 5)
        break;
      $result[] = str_replace(' ', '', ucwords($each));
      ++$count;
    }
    $result = implode(',', $result);
    return $result;
  }

  public function getShare(){
    return $this->share;
  }

}
