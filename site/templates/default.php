<?php
$ass = $kirby->url("assets") ."/images";
$menuItems = $site->menuItems()->toStructure();

// v1
$bgggUrl = $site->bgImages()->toFiles()->shuffle()->first()->url();

// v2
// $asciiItem = $site->asciiBgs()->toStructure()->shuffle()->first();
// $bgggAscii = $asciiItem->ascii()->value();
// $lines = substr_count($bgggAscii, "\n") + 1;
// // $lines = $asciiItem->lines()->value();
// // kill($lines);
// $cols = $asciiItem->columns()->value();
// $formattedAscii = Str::replace($bgggAscii, [" ", "\n"], ["&nbsp;", "<br />"]);
// $fs = 100 / ($lines + 4) * 0.999;
// $w = ($cols * 2.5);
?>

<?php snippet("header") ?>

<!-- v1 -->
<div class="bbbg-wrap"><img class="bbbg" src="<?= $bgggUrl ?>" /></div>

<!-- v2 -->
<?php /*
<div class="bbbg-wrap">
  <pre class="bbbg ascii" style="margin-top: <?= ($fs*2)."vh" ?>; font-size: <?= $fs."vh" ?>; line-height: <?= $fs."vh" ?>; width: <?= $w."vh" ?>;"><?= $formattedAscii ?></pre>
</div>
*/ ?>

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
