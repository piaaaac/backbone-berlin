<?php

/**
 * @param $bubble - kirby page
 * */

$id = Str::slug($bubble->id());
$menuContext = Str::slug($bubble->parentId() ?? "site");
?>



<div class="bubble" data-bubble-id="<?= $id ?>" data-menu-context="<?= $menuContext ?>">

  <?php if ($bubble->bubbleTitle()->isNotEmpty()): ?>
    <section class="text bubble-title">
      <h1><?= $bubble->bubbleTitle()->kti() ?></h1>
    </section>
  <?php endif ?>

  <?php if ($bubble->sectionItems()->toStructure()->count() > 1): ?>
    <section class="submenu">
      <?php foreach ($bubble->sectionItems()->toStructure() as $section): 
        $slug = $section->sectionName()->slug();
        ?>
        <a class="mr-2" data-submenu-target="<?= $slug ?>" data-bubble-id="<?= $id ?>"><strong><?= $section->sectionName()->kti() ?></strong></a>
      <?php endforeach ?>
    </section>
  <?php endif ?>

  <?php if (
    $bubble->bubbleTitle()->isNotEmpty()
    && $bubble->sectionItems()->toStructure()->count() <= 1
  ): ?>
    <div class="spacer py-4 my-2"></div>
  <?php endif ?>


  <?php foreach ($bubble->sectionItems()->toStructure() as $section): 
    $slug = $section->sectionName()->slug();
    ?>
    <section class="text" data-section-id="<?= $slug ?>">
      <div class="anchor" data-section-id="<?= $slug ?>"></div>
      <?= $section->sectionText()->kt() ?>
    </section>
  <?php endforeach ?>
</div>