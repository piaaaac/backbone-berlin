<?php

return [

  
  // --- Custom

  "menu-mobile-h" => 42,

  // --- Kirby

  "debug" => true,
  "whoops" => true,
  "languages" => true,

  "routes" => require_once 'routes.php',

  // "hooks" => require_once "hooks.php", // currently []
  
  "thumbs" => [
    "presets" => [
      "default" => ["width" => 1024, "quality" => 80],
      // "speaker" => ["crop" => 300, "width" => 300, "height" => 300, "greyscale" => true] /*"blur" => true*/
    ]
  ],

  "pedroborges.meta-tags.default" => function ($page, $site) {

    // default
    $socialUrl = $site->url();
    $socialTitle = $site->title();
    $socialDesc = $site->socialDescription();
    
    $socialImgUrl = "";
    if ($site->socialImage()->isNotEmpty()) {
      $socialImgUrl = $site->socialImage()->toFile()->url();
    } 

    return [
      'title'         => $site->title() ." | ". $page->title(),
      'meta' => [
        'description' => $socialDesc,
      ],
      'link' => [
        'canonical'   => $page->url()
      ],
      'og' => [
        'type'        => 'website',
        'title'       => $socialTitle,
        'site_name'   => $socialTitle,
        'image'       => $socialImgUrl,
        'url'         => $socialUrl,
        'description' => $socialDesc,
      ],
      'twitter' => [
        'card' => 'summary_large_image', // summary - summary_large_image
        'site' => "",
        'title' => $socialTitle,
        'namespace:image' => $socialImgUrl,
      ],
    ];
  }

];