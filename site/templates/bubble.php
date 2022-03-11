<?php
$id = Str::slug($page->id());
// $menuContext = Str::slug($page->parentId() ?? "site");

// -----------------------------------------
// SPECIAL CASES
// -----------------------------------------

$bubbleType = "b-default";

if ($id === "sessions-21") { $bubbleType = "b-sessions-21"; }

echo snippet("bubbles/$bubbleType", ["bubble" => $page]);

?>


<?php
/*
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
        <a class="mr-2" data-submenu-target="<?= $slug ?>" data-bubble-id="<?= $id ?>"><strong><?= $section->sectionName()->kti() ?></strong></a>
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
    <section class="text" data-section-id="<?= $slug ?>">
      <div class="anchor" data-section-id="<?= $slug ?>"></div>
      <?= $section->sectionText()->kt() ?>
    </section>
  <?php endforeach ?>
</div>
*/
?>