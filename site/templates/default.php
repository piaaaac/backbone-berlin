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

<script>

/*
// ---------------------------------------------------------------------------
// EXECUTION
// ---------------------------------------------------------------------------

var bubbles = initBubbles();
var state = {
  currentBubbleId: "landing",
}
var footerCount;
var footerInterval;

setFooterAnimation();

// --- check and assign hash, then go

if (window.location.hash && window.location.hash.length > 1) {
  state.currentBubbleId = window.location.hash.split("#")[1];
}
gotoBubble(state.currentBubbleId);

// ---------------------------------------------------------------------------
// EVENTS
// ---------------------------------------------------------------------------

window.addEventListener("resize", function (event) {
  bubbles = initBubbles();
  gotoBubble(state.currentBubbleId);
  setFooterAnimation();
});


$("nav .menu-item[data-bubble-id]").click(function () {
  var bubbleId = this.dataset.bubbleId;
  gotoBubble(bubbleId);
  return false;
});

// ---------------------------------------------------------------------------
// FUNCTIONS
// ---------------------------------------------------------------------------

function initBubbles () {
  var bubblesData = [];
  $(".bubble").each(function () {
    var xl = $(this).position().left;
    var w = $(this).width();
    var x = xl + w/2 - window.innerWidth/2;
    var bubble = {
      bubbleId: this.dataset.bubbleId,
      menuId: this.dataset.bubbleId, // <<-- later handle projects
      x: x,
    };
    bubblesData.push(bubble);
  });
  console.log("initBubbles", bubblesData);
  return bubblesData;
}

function gotoBubble (bubbleId) {
  var link = $("nav .menu-item[data-bubble-id='"+ bubbleId +"']");

  // --- transform x bubbles

  var bubble = bubbles.find(function (e) {
    return e.bubbleId === bubbleId;
  });
  var bubblex = bubble.x;
  var transformBubbles = "translateX("+ -bubblex +"px)";
  $(".bubbles").css("transform", transformBubbles);
  $(".bubble[data-bubble-id='"+ bubbleId +"']")[0].scrollTo(0,0);
  
  // --- transform x background

  var bbbgw = $(".bbbg-wrap").width();
  var bubblesw = $(".bubbles").width();
  var bbbgx = apMap(bubblex, 0,bubblesw, 0,bbbgw);
  var transformBbbg = "translateX("+ -bbbgx +"px)";
  $(".bbbg").css("transform", transformBbbg);

  // --- transform x line

  var linex = $(link).offset().left - 5;
  var transformLine = "translateX("+ linex +"px)";
  $(".line").css("transform", transformLine);

  // --- handle menu links

  $("nav .menu-item").removeClass("active");
  $(link).addClass("active");

  // --- handle hash

  window.location.hash = bubbleId;

  // --- handle state

  state.currentBubbleId = bubbleId;
}

function setFooterAnimation () {
  if (footerInterval) { clearInterval(footerInterval); }
  var footerWrapper = $(".footer .content-wrapper")[0];
  var footerContent = $(".footer .content")[0];
  var fcw = footerContent.offsetWidth;
  var fww = footerWrapper.offsetWidth;
  // console.log(fcw, "fcw", fww, "fww")
  if (fww < fcw) {
    var diff = fcw - fww;
    var time = diff * 30;
    var ease = "linear";
    // var ease = "ease-in-out";
    console.log(time, "time")
    footerContent.style.transition = "left "+ Math.round(time) +"ms "+ ease;
    footerCount = 0;
    var move = function () {
      var left = (footerCount % 2 === 0) ? (-diff) : 0;
      $(footerContent).css("left", left + "px");
      footerCount++;
      // console.log(footerCount, "footerCount")
    }
    footerInterval = setInterval(move, time + 1000);
    move();
  }
}
*/
</script>

<?php snippet("footer") ?>
