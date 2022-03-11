<?php

/**
 * @param $bubble - kirby page
 * */

$id = Str::slug($bubble->id());
$menuContext = Str::slug($bubble->parentId() ?? "site");

$lang = $kirby->language()->code();

$words = $site->sessions21_tags()->toStructure()->toArray(function ($item) { return $item->s21text()->value(); });
// kill($words);

// $words = [
//   "en" => ["group", "community"],
//   "de" => ["ist", "und"],
// ];

?>

<style>
  span.h { background-color: yellow; }
  span.h.selected { background-color: orange; }
</style>

<div class="bubble" data-bubble-id="<?= $id ?>" data-menu-context="<?= $menuContext ?>">

  <?php if ($bubble->bubbleTitle()->isNotEmpty()): ?>
    <section class="text bubble-title">
      <h1><?= $bubble->bubbleTitle()->kti() ?></h1>
    </section>
  <?php endif ?>

  <section class="submenu search d-flex align-items-center justify-content-between py-1 mt-3">
    
    <div class="styled-select" style="flex-grow: 1;">
      <select id="sessions-21-select">
        <option value="">Choose a topic...</option>
        <?php foreach ($words as $w): ?><option value="<?= $w ?>"><?= $w ?></option><?php endforeach ?>
      </select>
    </div>

    <div id="sessions-21-arrows" class="d-none d-md-flex flex-nowrap">
      <a class="single-arrow d-none" id="sessions-21-prev"><img src="<?= $kirby->url("assets") ?>/images/arrow-u.svg" /></a>
      <a class="single-arrow d-none" id="sessions-21-next"><img src="<?= $kirby->url("assets") ?>/images/arrow-d.svg" /></a>
    </div>
  </section>

  <section class="text session-21-text">
    <?php foreach ($bubble->sectionItems()->toStructure() as $section): ?>
      <?= $section->sectionText()->kt() ?>
    <?php endforeach ?>
  </section>
</div>



<script>

// ------------------------------------------
// ON LOAD
// ------------------------------------------

var cont21, bubble;
var searchState = {
  "value": null,
  "index": 0,
}

$(document).ready(function () {
  cont21 = $("section.session-21-text")[0];
  bubble = $(".bubble[data-bubble-id='sessions-21']")[0];
});

// ------------------------------------------
// EVENTS
// ------------------------------------------

$("#sessions-21-select").change(function (value) {
  var value = this.value;
  search(cont21, value);
});

$("#sessions-21-prev").click(function (value) { highlight("prev"); });
$("#sessions-21-next").click(function (value) { highlight("next"); });

// ------------------------------------------
// FUNCTIONS
// ------------------------------------------

function highlight (direction) {

  var elements = $(cont21).find("span.h").removeClass("selected").toArray();

  if (!elements.length) {
    console.log("alert 32598060 - no items");
    return false;
  }

  if (direction === "prev") {
    searchState.index--;
    if (searchState.index < 0) { searchState.index = elements.length - 1; }
  }
  else if (direction === "next") {
    searchState.index++;
    if (searchState.index >= elements.length) { searchState.index = 0; }
  }
  else if (typeof direction === "number") {
    searchState.index = direction;
    if (searchState.index < 0 || searchState.index >= elements.length) { throw "error 23098562"; }
  }
  else { throw "error 23509856"; }

  var el = elements[searchState.index];
  const yOffset = -190; 
  const y = el.getBoundingClientRect().top + bubble.scrollTop + yOffset;
  console.log(y)
  bubble.scrollTo({top: y, behavior: 'smooth'});
  // el.scrollIntoView();
  $(el).addClass("selected");
}

function search (container, txt) {

  searchState = {
    "value": txt,
    "index": 0,
  }

  // clean
  $(container).find("span.h").each(function (i, e) {
    var str = $(e).html();
    console.log(this)
    $(this).replaceWith(document.createTextNode(str))
  });
  $("#sessions-21-arrows .single-arrow").addClass("d-none");

  if (txt) {

    var innerHTML = $(container).html();

    // v2
    innerHTML = innerHTML.split(txt).join("<span class='h'>"+ txt +"</span>");
    
    // v1
    // via https://stackoverflow.com/a/8644513/2501713
    // innerHTML = innerHTML.replace(new RegExp(txt, "g"), "<span class='h' style='background-color: yellow;'>$1</span>");
    
    $(container).html(innerHTML);
    $("#sessions-21-arrows .single-arrow").removeClass("d-none");
    highlight(0);

  }
}


</script>






















