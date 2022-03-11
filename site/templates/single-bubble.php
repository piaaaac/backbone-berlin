<?php
$bgggs = $site->bgImages()->toFiles()->filter(function ($file) {
  return $file->active()->toBool();
});
$bgggUrl = $bgggs->shuffle()->first()->url();

$virtualBubble = new Page([
  "slug" => "virtual-reality",
  "template" => "bubble",
  "content" => $page->content()->toArray(),
]);
?>

<?php snippet("header") ?>

<nav class="menu-custom">
  <a href="<?= $site->url() ?>" class="active"><?= $site->title() ?></a>
</nav>

<main>
  <div class="bbbg-wrap"><img class="bbbg" src="<?= $bgggUrl ?>" /></div>
  <div class="line walk"></div>
  <div class="screen">
    <div class="bubbles">
      <div class="bubble-wrapper single-bubble" data-level="1"><?= $virtualBubble->render() ?></div>
    </div>
  </div>
</main>

<?php snippet("footer") ?>
