<?php
$ass = $kirby->url("assets") ."/images";
$menuItems = $site->menuItems()->toStructure();

$bgggs = $site->bgImages()->toFiles()->filter(function ($file) {
  return $file->active()->toBool();
});
$bgggUrl = $bgggs->shuffle()->first()->url();
?>

<?php snippet("header") ?>

<div class="bbbg-wrap"><img class="bbbg" src="<?= $bgggUrl ?>" /></div>

<div class="line"></div>

<div class="screen">
  <div class="bubbles">
    
    <!-- empty first bubble -->
    <div class="bubble-wrapper hide-in-place" data-level="1"><?= page("landing")->render() ?></div>

    <?php foreach ($menuItems as $item): 
      $p = $item->menuPage()->toPage();
      $template = $p->template()->name();
      if ($template === "container"):
        echo $p->render();
      elseif ($template === "bubble"):
        ?>
        <div class="bubble-wrapper" data-level="1"><?= $p->render() ?></div>
        <?php
      endif;
    endforeach ?>

  </div>
</div>

<?php snippet("footer") ?>
