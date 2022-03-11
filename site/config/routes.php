<?php

return [

  [
    "pattern" => "/archived/(:any)",
    "language" => "*",
    "action"  => function ($language, $bubblePageId) {

      $p = page($bubblePageId);
      
      if (!isset($p) || !$p) { 
        return "<html><body>Page not found: $bubblePageId</body></html>";
      }
      
      // return new Page([
      //   "slug" => $bubblePageId,
      //   "template" => "single-bubble",
      //   "content" => $p->content()->toArray(),
      // ]);
      
      $vp = new Page([
        "slug" => $bubblePageId,
        "template" => "single-bubble",
        "content" => $p->content()->toArray(),
      ]);

      return site()->visit($vp, $language);

    }
  ],
  [
    "pattern" => "/archived/(:any)",
    "action"  => function ($bubblePageId) {

      $lang = kirby()->session()->get("lang", "en");
      $url = "/$lang/archived/$bubblePageId";
      go($url);

      // return "<html><body>$bubblePageId</body></html>";
    }
  ],

  // [
  //   "pattern" => "/archived/(:any)",
  //   "action"  => function ($bubblePageId) {

  //     $p = page($bubblePageId);
  //     $lang = kirby()->session()->get("lang", "en");
      
  //     if (!isset($p) || !$p) { 
  //       return "<html><body>Page not found: $bubblePageId</body></html>";
  //     }
      
  //     // return new Page([
  //     //   "slug" => $bubblePageId,
  //     //   "template" => "single-bubble",
  //     //   "content" => $p->content()->toArray(),
  //     // ]);
      
  //     $vp = new Page([
  //       "slug" => $bubblePageId,
  //       "template" => "single-bubble",
  //       "content" => $p->content()->toArray(),
  //     ]);

  //     return site()->visit($vp, $lang);

  //   }
  // ],

];