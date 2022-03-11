<?php snippet("header") ?>

<div class="line"></div>

<div class="screen">
  <div class="bubbles">
    <div class="bubble-wrapper" data-level="1">
      <div class="bubble">
        
        <section class="text bubble-title">
          <h1><?= $page->title()->kti() ?></h1>
        </section>

        <section class="text">
          <?= $page->text()->kt() ?>
        </section>

      </div>
    </div>
  </div>
</div>

<?php snippet("footer") ?>
