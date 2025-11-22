<?php

namespace Modassir\View;
use Lazervel\Path\Path;

class view
{
  private $root = __DIR__.'/../../resources/view/';
  private $vars = [];
  private $blade;
  
  public function __construct(string $blade)
  {
    $this->blade = \str_replace('.', '/', $blade) . '.blade.php';
  }

  public function with($vars)
  {
    $this->vars[$this->blade] = (array)$vars;
  }

  public function __destruct()
  {
    $path = Path::resolve($this->root.$this->blade);
    $data = \file_get_contents($path);
    $data = \str_replace(['@php', '@endphp'], ['<?php', '?>'], $data);
    $data = \preg_replace('/\{\{(.*?)\}\}/', '<?=$1?>', $data);

    $data = \preg_replace('/@(if|foreach|for)(.*?)\n/', '<?php $1$2 { ?>', $data);
    $data = \preg_replace('/@(elseif|else)(.*?)\n/', '<?php } $1$2 { ?>', $data);
    $data = \preg_replace('/@end(if|foreach|for)/', '<?php } ?>', $data);
    $data = \preg_replace('/@(continue|break)/', '<?php $1 ?>', $data);
    $data = '?>'.$data;

    if (isset($this->vars[$this->blade])) {
      extract($this->vars[$this->blade]);
    }
    eval($data);
  }
}
?>