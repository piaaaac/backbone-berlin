<?php
$menuItems = $site->menuItems()->toStructure();
$landingBubbleId = Str::slug(page("landing")->id());
?>

<nav id="menu-header">
  <div class="wrapper">

    <p style="text-align: left; flex-grow: 1;"><a href="#" data-bubble-id="<?= $landingBubbleId ?>" class="menu-item no-u active">Backbone Berlin</a></p>
    <?php foreach ($menuItems as $item): 
      $text = $item->menuText()->value();
      $p = $item->menuPage()->toPage();
      $id = Str::slug($p->id());
      ?>
      <p style="text-align: right; flex-grow: 1;"><a class="menu-item" href="#" data-bubble-id="<?= $id ?>"><?= $text ?></a></p>
    <?php endforeach ?>

  </div>
</nav>

<div id="menu-xs">
  <a class="item" href="page.php">Menu-item</a>
  <a class="item" href="page.php">Menu-item</a>
  <a class="item" href="page.php">Menu-item</a>
  <a class="item" href="page.php">Menu-item</a>
</div>

<script>
$("button.hamburger").click( function (e) {
  toggleMenu();
});

function toggleMenu (newState) {
  var isOpen = $("body").hasClass("menu-xs-open");
  if (newState === true || newState === false) {
    isOpen = !newState;
  }
  $("body").toggleClass("menu-xs-open", !isOpen);
  $("button.hamburger").toggleClass("is-active", !isOpen);
}
</script>












