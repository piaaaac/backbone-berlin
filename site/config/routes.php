<?php

return [

  [
    "pattern" => "/single/(:all)",
    // "pattern" => "/single/(:any)",
    "language" => "*",
    "action"  => function ($language, $bubblePageId) {


      /*DEBUG*/
      // return "<html><body>$bubblePageId</body></html>";
      /*DEBUG*/



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
    "pattern" => "/single/(:all)",
    // "pattern" => "/single/(:any)",
    "action"  => function ($bubblePageId) {

      /*DEBUG*/
      // return "<html><body>No lang — $bubblePageId</body></html>";
      /*DEBUG*/

      $lang = kirby()->session()->get("lang", "en");
      $url = "/$lang/single/$bubblePageId";
      go($url);

      // return "<html><body>$bubblePageId</body></html>";
    }
  ],

  // [
  //   "pattern" => "/single/(:any)",
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