<?php
$menuItems = $site->menuItems()->toStructure();
$landingBubbleId = Str::slug(page("landing")->id());
?>

<nav id="menu-desktop">
  <div class="wrapper">
    <p style="text-align: left; flex-grow: 1;"><a href="#" data-bubble-id="<?= $landingBubbleId ?>" class="menu-item no-u active">Backbone Berlin</a></p>
    <?php foreach ($menuItems as $item): 
      $text = $item->menuText()->value();
      $p = $item->menuPage()->toPage();
      $id = Str::slug($p->id());
      ?>
      <p style="text-align: right; flex-grow: 1;"><a class="menu-item" href="#" data-bubble-id="<?= $id ?>"><?= $text ?></a></p>
    <?php endforeach ?>
    <p style="text-align: right; flex-grow: 1;"><a href="#" class="menu-item no-u">De</a></p>
  </div>
</nav>

<nav id="menu-mobile">
  <div class="items">
    <a href="#" data-bubble-id="<?= $landingBubbleId ?>" class="menu-item no-u active">Backbone Berlin</a>
    <?php foreach ($menuItems as $item): 
      $text = $item->menuText()->value();
      $p = $item->menuPage()->toPage();
      $id = Str::slug($p->id());
      ?>
      <a class="menu-item" href="#" data-bubble-id="<?= $id ?>"><?= $text ?></a>
    <?php endforeach ?>
    <a href="#" class="menu-item no-u">De</a>
  </div>
  <a class="arrow" id="arrow-left" data-bubble-id=""><</a>
  <a class="arrow" id="arrow-right" data-bubble-id="">></a>
</nav>

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












