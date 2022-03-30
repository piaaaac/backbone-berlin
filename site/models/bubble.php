<?php


class BubblePage extends Page {
  
  public function singleurl () {
    
    $piece1 = Str::replace($this->url(), $this->id(), "");
    return $piece1 ."single/". $this->id();

    // $piece1 = Str::replace($this->url(), $this->slug(), "");
    // return $piece1 ."single/". $this->slug();

  }


}