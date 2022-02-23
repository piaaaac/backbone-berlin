<?php
$ass = $kirby->url("assets") ."/images";
$menuItems = $site->menuItems()->toStructure();
$bgggUrl = $site->bgImages()->toFiles()->shuffle()->first()->url();
?>

<?php snippet("header") ?>

<div class="bbbg-wrap"><img class="bbbg" src="<?= $bgggUrl ?>" /></div>

<div class="line"></div>

<div class="screen">
  <div class="bubbles">
    
    <!-- empty first bubble -->
    <div class="bubble-wrapper hide" data-level="1"><?= page("landing")->render() ?></div>

    <?php foreach ($menuItems as $item): 
      $p = $item->menuPage()->toPage();
      ?>
      <div class="bubble-wrapper" data-level="1"><?= $p->render() ?></div>
    <?php endforeach ?>

  </div>
</div>

<?php snippet("footer") ?>
