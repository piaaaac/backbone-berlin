<?php
$menuItems = $site->menuItems()->toStructure();

// kill($menuItems->toArray());
$menuMeta = [
  ["bubbleId" => "landing"],
];
foreach ($menuItems as $item) {
  $menuMeta[] = ["bubbleId" => $item->menuPage()->toPage()->id()];
}

$siteIndex = [];
$siteIndex[] = [
  "id" => "landing",
  "template" => "bubble",
  "menuContext" => "site",
  "index" => 0,
  "children" => null,
];
$l1Index = 1;
foreach ($menuItems as $item) {
  $p = $item->menuPage()->toPage();
  $template = $p->template()->name();
  $indexItem = [
    "id" => Str::slug($p->id()),
    "template" => $template,
    "menuContext" => "site",
    "index" => $l1Index,
    "children" => null,
  ];
  if ($template === "container") {
    $l2Index = 0;
    $children = [];
    foreach ($p->children()->listed() as $child) {
      $children[] = [
        "id" => Str::slug($child->id()),
        "template" => $child->template()->name(),
        "menuContext" => Str::slug($p->id()),
        "index" => $l2Index,
        "children" => null,
      ];
      $l2Index++;
    }
    $indexItem["children"] = $children;
  }
  $siteIndex[] = $indexItem;
  $l1Index++;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="content-language" content="en">

  <?php echo $page->metaTags() ?>
  <?php snippet("favicon") ?>
  <?php snippet("load-scripts") ?>

  <script>
    window.currentPage = '<?= $page->uid() ?>';
    window.currentTemplate = '<?= $page->template() ?>';
    window.menuMobileH = <?= c::get("menu-mobile-h") ?>; // must match css $menu-mobile-h
    window.menuMeta = <?= json_encode($menuMeta) ?>;
    window.siteIndex = <?= json_encode($siteIndex) ?>;
  </script>

</head>

<body>

  <?php snippet("menu") ?>
  
  <main>
