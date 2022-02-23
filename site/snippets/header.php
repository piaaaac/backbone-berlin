<?php
$menuItems = $site->menuItems()->toStructure();
$menuItemsNum = $menuItems->count() + 2; // home and lang switch

// kill($menuItems->toArray());
$menuMeta = [
  ["bubbleId" => "landing"],
];
foreach ($menuItems as $item) {
  $menuMeta[] = ["bubbleId" => $item->menuPage()->toPage()->id()];
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

  <style>
  nav#menu-mobile.open {
    height: <?= c::get("menu-mobile-h") * $menuItemsNum ?>px;
  }
  </style>

  <script>
    window.currentPage = '<?= $page->uid() ?>';
    window.currentTemplate = '<?= $page->template() ?>';
    window.menuMobileH = <?= c::get("menu-mobile-h") ?>; // must match css $menu-mobile-h
    window.menuMeta = <?= json_encode($menuMeta) ?>;
  </script>

</head>

<body>
  <main>

  <?php snippet("menu") ?>
