<?php
$menuItems = $site->menuItems()->toStructure();
$menuItemsNum = $menuItems->count() + 2; // home and lang switch
$landingBubbleId = Str::slug(page("landing")->id());

$containerPages = new Pages();
foreach ($menuItems as $item) {
  $p = $item->menuPage()->toPage();
  $template = $p->template()->name();
  if ($template === "container") {
    $containerPages->add($p);
  }
}
?>

<style>
nav.menu-mobile[data-menu-context="site"].open {
  height: <?= c::get("menu-mobile-h") * $menuItemsNum ?>px;
}
<?php foreach ($containerPages as $cont): 
  $contId = Str::slug($cont->id());
  $children = $cont->children()->listed();
  ?>
  nav.menu-mobile[data-menu-context="<?= $contId ?>"].open {
    height: <?= c::get("menu-mobile-h") * $children->count() ?>px;
  }
<?php endforeach ?>
</style>

<!----------------------------------------------------------------------->
<!-- Desktop -->
<!----------------------------------------------------------------------->

<!-- Level 1 -->

<nav id="menu-desktop" data-menu-context="site">
  <div class="wrapper">
    <p style="text-align: left; flex-grow: 1;"><a href="#" data-bubble-id="<?= $landingBubbleId ?>" class="menu-item no-u active">Backbone Berlin</a></p>
    <?php foreach ($menuItems as $item): 
      $text = $item->menuText()->value();
      $p = $item->menuPage()->toPage();
      $template = $p->template()->name();
      $pageId = Str::slug($p->id());
      $bubbleId = ($template === "container")
        ? Str::slug($p->children()->listed()->first()->id())
        : $pageId;
      // if ($template === "container") { $pageId = Str::slug($p->children()->listed()->first()->id()); }
      ?>
      <p style="text-align: right; flex-grow: 1;"><a class="menu-item" href="#" data-bubble-id="<?= $bubbleId ?>" data-page-id="<?= $pageId ?>"><?= $text ?></a></p>
    <?php endforeach ?>
    <?php foreach($kirby->languages() as $language): 
      if ($kirby->language() == $language) continue;
      ?>
      <p style="text-align: right; flex-grow: 1;">
        <a href="<?= $language->url() ?>" hreflang="<?= $language->code() ?>" class="menu-item no-u">
          <?= html($language->name()) ?>
        </a>
      </p>
    <?php endforeach ?>
  </div>
</nav>

<!-- Level 2 -->

<?php foreach ($containerPages as $cont): 
  $contId = Str::slug($cont->id());
  $children = $cont->children()->listed();
  ?>
  <nav class="desktop-arrows" data-menu-context="<?= $contId ?>" data-level="2">
    <a class="arrow arrow-left" data-direction="left" data-menu-context="<?= $contId ?>" data-level="2"></a>
    <a class="arrow arrow-right" data-direction="right" data-menu-context="<?= $contId ?>" data-level="2"></a>
  </nav>
<?php endforeach ?>


<!----------------------------------------------------------------------->
<!-- Mobile -->
<!----------------------------------------------------------------------->

<!-- Level 1 -->

<nav class="menu-mobile" data-menu-context="site" data-level="1">
  <div class="items">
    <a href="#" data-bubble-id="<?= $landingBubbleId ?>" class="menu-item no-u active">Backbone Berlin</a>
    <?php foreach ($menuItems as $item): 
      $text = $item->menuText()->value();
      $p = $item->menuPage()->toPage();
      $template = $p->template()->name();
      $pageId = Str::slug($p->id());
      $bubbleId = ($template === "container")
        ? Str::slug($p->children()->listed()->first()->id())
        : $pageId;
      // if ($template === "container") { $pageId = Str::slug($p->children()->listed()->first()->id()); }
      ?>
      <a class="menu-item" href="#" data-bubble-id="<?= $bubbleId ?>" data-page-id="<?= $pageId ?>"><?= $text ?></a>
    <?php endforeach ?>
    <?php foreach($kirby->languages() as $language): 
      if ($kirby->language() == $language) continue;
      ?>
      <a href="<?= $language->url() ?>" hreflang="<?= $language->code() ?>" class="menu-item no-u"><?= html($language->name()) ?></a>
    <?php endforeach ?>
  </div>
  <a class="arrow arrow-left" data-direction="left" data-menu-context="site" data-level="1"></a>
  <a class="arrow arrow-right" data-direction="right" data-menu-context="site" data-level="1"></a>
</nav>

<!-- Level 2 -->

<?php foreach ($containerPages as $cont): 
  $contId = Str::slug($cont->id());
  $children = $cont->children()->listed();
  ?>
  <nav class="menu-mobile" data-menu-context="<?= $contId ?>" data-level="2">
    <div class="items">
      <?php foreach ($children as $p): 
        $text = $p->title()->value();
        $pageId = Str::slug($p->id());
        $bubbleId = $pageId;
        ?>
        <a class="menu-item" href="#" data-bubble-id="<?= $bubbleId ?>" data-page-id="<?= $pageId ?>"><?= $text ?></a>
      <?php endforeach ?>
    </div>
    <a class="arrow arrow-left" data-direction="left" data-menu-context="<?= $contId ?>" data-level="2"></a>
    <a class="arrow arrow-right" data-direction="right" data-menu-context="<?= $contId ?>" data-level="2"></a>
  </nav>
<?php endforeach ?>

<script>
$("button.hamburger").click( function (e) {
  toggleMenu();
});

function toggleMenu (newState) {
  var isOpen = $("body").hasClass("menu-mobile-open");
  if (newState === true || newState === false) {
    isOpen = !newState;
  }
  $("body").toggleClass("menu-mobile-open", !isOpen);
  $("button.hamburger").toggleClass("is-active", !isOpen);
}
</script>












