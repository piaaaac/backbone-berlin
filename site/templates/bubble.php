<?php
$id = Str::slug($page->id());
$menuContext = Str::slug($page->parentId() ?? "site");
?>

<div class="bubble" data-bubble-id="<?= $id ?>" data-menu-context="<?= $menuContext ?>">

  <!-- <div>menu context: <?= (string)$menuContext ?></div> -->

  <?php if ($page->bubbleTitle()->isNotEmpty()): ?>
    <section class="text bubble-title">
      <h1><?= $page->bubbleTitle()->kti() ?></h1>
    </section>
  <?php endif ?>

  <?php if ($page->sectionItems()->toStructure()->count() > 1): ?>
    <section class="submenu">
      <?php foreach ($page->sectionItems()->toStructure() as $section): 
        $slug = $section->sectionName()->slug();
        ?>
        <a class="mr-2" href="#<?= $slug ?>"><?= $section->sectionName()->kti() ?></a>
      <?php endforeach ?>
    </section>
  <?php endif ?>

  <?php if (
    $page->bubbleTitle()->isNotEmpty()
    && $page->sectionItems()->toStructure()->count() <= 1
  ): ?>
    <div class="spacer py-4 my-2"></div>
  <?php endif ?>


  <?php foreach ($page->sectionItems()->toStructure() as $section): 
    $slug = $section->sectionName()->slug();
    ?>
    <section class="text">
      <div class="anchor" id="<?= $slug ?>"></div>
      <?= $section->sectionText()->kt() ?>
    </section>
  <?php endforeach ?>
</div>