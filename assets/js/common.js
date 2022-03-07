/*

- add landing screen to w.siteIndex?
- in adjustMobileNavFromState use w.siteIndex instead of w.menuMeta


ACTUALLY


Trash all assignment of bubble-ids to arrows and use a function like (direction, context) => {} in combination with w.siteIndex to determin to which bubble to go

*/


// ---------------------------------------------------------------------------
// EXECUTION
// ---------------------------------------------------------------------------

var menuMobileH = window.menuMobileH; // initialized by php in header.php
var bubbles = initBubbles();
var state = {
  currentBubbleId: "landing",
}
var footerCount;
var footerInterval;

$(document).ready(function () {
  setFooterAnimation();
  showTime();

  // --- check and assign hash, then go

  if (window.location.hash && window.location.hash.length > 1) {
    state.currentBubbleId = window.location.hash.split("#")[1];
  }
  gotoBubble(state.currentBubbleId);
});

// ---------------------------------------------------------------------------
// EVENTS
// ---------------------------------------------------------------------------

handleResizeStartEnd (function () {
  // resize start
}, function () {
  // resize end
  bubbles = initBubbles();
  gotoBubble(state.currentBubbleId);
  setFooterAnimation();
}, {
  "horizontalOnly": true
  // resizeOptions
});

// window.addEventListener("resize", function (event) {
//   bubbles = initBubbles();
//   gotoBubble(state.currentBubbleId);
//   setFooterAnimation();
// });

$("nav .menu-item[data-bubble-id]").click(function () {
  var bubbleId = this.dataset.bubbleId;
  gotoBubble(bubbleId);
  return false;
});

$("nav .arrow").click(function () {
  var direction = this.dataset.direction;
  var menuContext = this.dataset.menuContext;
  var level = this.dataset.level;
  handleArrowClick(direction, menuContext, level);
  return false;
});

$("nav.menu-mobile:not(.open) .items").click(function () {
  $(this.parentElement).addClass("open");
});

 // --- Key bindings

document.addEventListener('keyup', function (event) {
  if (event.defaultPrevented) { return; }
  // console.log(event.key, event.keyCode)
  var key = event.key || event.keyCode;
  if (key === 'ArrowLeft' || key === 'Left' || key === 37) { 
    // $(".arrow-left[data-bubble-id!='']").last().click();
    var level = state.currentMenuContext === "site" ? 1 : 2;
    handleArrowClick("left", state.currentMenuContext, level);
  }
  if (key === 'ArrowRight' || key === 'Right' || key === 39) { 
    // $(".arrow-right[data-bubble-id!='']").last().click();
    var level = state.currentMenuContext === "site" ? 1 : 2;
    handleArrowClick("right", state.currentMenuContext, level);
  }
});

$("main").click(function () {
  $("nav.menu-mobile.open").removeClass("open");
});

$("a[data-submenu-target]").click(function () {
  scrollToSection(this.dataset.submenuTarget, this.dataset.bubbleId);
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
      menuContext: this.dataset.menuContext,
      x: x,
    };
    bubblesData.push(bubble);
  });
  console.log("initBubbles", bubblesData);
  console.log("window.menuMeta", window.menuMeta);
  console.log("window.siteIndex", window.siteIndex);
  return bubblesData;
}

function handleArrowClick (direction, arrowMenuContext, level) {
  
  // --- find bubbleId using state & siteIndex

  var bubbleId;

  if (level == 1) {

    var itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentBubbleId});
    if (!itemLevel1) {
      itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentMenuContext});
      if (!itemLevel1) { throw "error 23987511"; }
    }
    var currI = itemLevel1.index;
    var newI = currI + (direction === "left" ? -1 : 1);
    if (newI < 0 || newI >= window.siteIndex.length) { 
      // throw "Error 32895764"; 
      console.log("Alert 32895764");
      return false;
    }
    var newIndexItem = window.siteIndex[newI];
    if (newIndexItem.children === null) {
      bubbleId = newIndexItem.id;
    } else {
      var firstChild = newIndexItem.children[0];
      bubbleId = firstChild.id;
    }

  } else {

    var itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentBubbleId});
    if (!itemLevel1) {
      itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentMenuContext});
      if (!itemLevel1) { throw "error 43987542"; }
    }
    
    // state.currentMenuContext is not "site"
    var contextualIndex = itemLevel1.children;
    var itemLevel2 = contextualIndex.find((item) => item.id === state.currentBubbleId);
    var currI = itemLevel2.index;
    var newI = currI + (direction === "left" ? -1 : 1);
    if (newI < 0 || newI >= contextualIndex.length) { 
      console.log("Alert 32509867");
      handleArrowClick(direction, "site", 1);
      return false;
    }
    var newIndexItem = contextualIndex[newI];
    bubbleId = newIndexItem.id;

  }

  gotoBubble(bubbleId);

}

function gotoBubble (bubbleId) {
  var bubble = bubbles.find(function (e) {
    return e.bubbleId === bubbleId;
  });
  if (!bubble) { throw "Error 23498756"; }
  var menuDesktopId = bubble.menuContext === "site" ? bubbleId : bubble.menuContext;
  var linkDesktop = $("nav#menu-desktop .menu-item[data-page-id='"+ menuDesktopId +"']");

  // --- handle hash & state

  window.location.hash = bubbleId;
  state.currentBubbleId = bubbleId;
  state.currentMenuContext = bubble.menuContext;

  // --- transform x bubbles

  var bubblex = bubble.x + 1; // 1 accounts for border (i think)
  var transformBubbles = "translateX("+ -bubblex +"px)";
  $(".bubbles").css("transform", transformBubbles);
  $(".bubble[data-bubble-id='"+ bubbleId +"']")[0].scrollTo(0,0);
  
  // --- transform x background

  var bbbgw = $(".bbbg").width();
  var bubblesw = $(".bubbles").width();
  var bbbgx = apMap(bubblex, 0,bubblesw, -10,bbbgw+10);
  var transformBbbg = "translateX("+ -bbbgx +"px)";
  $(".bbbg").css("transform", transformBbbg);

  // --- transform x line (desktop & mobile)

  var linex = 0;
  if (breakpointIs("md", "up")) {
    linex = $(linkDesktop).offset().left - 5;
  } else {
    var maxBubblex = bubbles.map(e => e.x).reduce((a, b) => { return Math.max(a, b) });
    linex = apMap(bubblex, 0,maxBubblex, 7.5,window.innerWidth-7.5);
  }
  var transformLine = "translateX("+ linex +"px)";
  $(".line").css("transform", transformLine);

  // --- handle desktop menu links

  $("nav#menu-desktop .menu-item").removeClass("active");
  $(linkDesktop).addClass("active");

  // --- handle menu (mobile)

  adjustMobileNavFromState();
}

function adjustMobileNavFromState () {

  // --- Handle level 2 menus visibility

  $("nav[data-level='2']").addClass("hide-in-place");
  $("nav[data-level='2'][data-menu-context='"+ state.currentMenuContext +"']").removeClass("hide-in-place");
  
  // --- Handle mobile menus position

  var itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentBubbleId});
  if (!itemLevel1) {
    itemLevel1 = window.siteIndex.find(function (item) { return item.id === state.currentMenuContext});
    if (!itemLevel1) { throw "error 43987542"; }
  }
  var mml1iy = itemLevel1.index * menuMobileH;
  $("nav.menu-mobile[data-menu-context='site'] .items").css("top", -mml1iy +"px");
  $("nav.menu-mobile[data-menu-context='site']").removeClass("open");

  var itemLevel2;
  if (state.currentMenuContext !== "site") {
    var contextualIndex = itemLevel1.children;
    itemLevel2 = contextualIndex.find((item) => item.id === state.currentBubbleId);
    var mml2iy = itemLevel2.index * menuMobileH;
    $("nav.menu-mobile[data-menu-context='"+ state.currentMenuContext +"'] .items").css("top", -mml2iy +"px");
    $("nav.menu-mobile[data-menu-context='"+ state.currentMenuContext +"']").removeClass("open");
  }

  // --- Show/hide arrows level 1

  $("a.arrow").removeClass("hide-in-place");

  var currI = itemLevel1.index;
  if (currI <= 0) { $("a.arrow.arrow-left[data-menu-context='site']").addClass("hide-in-place"); }
  if (currI >= window.siteIndex.length - 1) { $("a.arrow.arrow-right[data-menu-context='site']").addClass("hide-in-place"); }
  
  // --- Show/hide arrows level 2

  if (itemLevel2) {
    var contextualIndex = itemLevel1.children;
    var itemLevel2 = contextualIndex.find((item) => item.id === state.currentBubbleId);
    var currIL2 = itemLevel2.index;
    if (currIL2 <= 0) { $("a.arrow.arrow-left[data-menu-context='"+ state.currentMenuContext +"']").addClass("hide-in-place"); }
    if (currIL2 >= contextualIndex.length - 1) { $("a.arrow.arrow-right[data-menu-context='"+ state.currentMenuContext +"']").addClass("hide-in-place"); }
  }

  // --- Handle mobile links color

  var linkMobileL1 = $("nav.menu-mobile[data-level='1'] .menu-item[data-page-id='"+ itemLevel1.id +"']");
  $("nav.menu-mobile[data-level='1'] .menu-item").removeClass("active");
  $(linkMobileL1).addClass("active");

  if (itemLevel2) {
    var linkMobileL2 = $("nav.menu-mobile[data-level='2'] .menu-item[data-page-id='"+ itemLevel2.id +"']");
    $("nav.menu-mobile[data-level='2'] .menu-item").removeClass("active");
    $(linkMobileL2).addClass("active");
  }
}

function scrollToSection (submenuTarget, bubbleId) {
  console.log(submenuTarget, bubbleId);
  var bubbleEl = $(".bubble[data-bubble-id='"+ bubbleId +"']")[0];
  var sectionEl = $(bubbleEl).find("[data-section-id='"+ submenuTarget +"']:not(.anchor)")[0];
  if (!sectionEl) { throw "error 39725698"; }
  var anchorEl = $(bubbleEl).find(".anchor[data-section-id='"+ submenuTarget +"']")[0];
  if (!anchorEl) { throw "error 39725628"; }
  anchorEl.scrollIntoView(true);
  $("[data-section-id] *").removeClass("highlight-once");
  $(sectionEl).find("p, h1, h2, h3, h4, h5, h6").addClass("highlight-once");
}

function setFooterAnimation () {
  var footerWrapper = $(".footer .content-wrapper")[0];
  var footerContent = $(".footer .content")[0];
  var fcw = footerContent.offsetWidth;
  var fww = footerWrapper.offsetWidth;
  if (footerInterval) { 
    clearInterval(footerInterval); 
    footerContent.style.transition = "transform 0ms";
    footerContent.style.transform = "translateX(0px)";
  }
  if (fww < fcw) {
    var diff = fcw - fww;
    var time = diff * 17;
    var ease = "linear"; // "ease-in-out";
    footerContent.style.transition = "transform "+ Math.round(time) +"ms "+ ease;
    footerCount = 0;
    var move = function () {
      var left = (footerCount % 2 === 0) ? (-diff) : 0;
      footerContent.style.transform = "translateX("+ left + "px)";
      footerCount++;
    }
    footerInterval = setInterval(move, time + 1000);
    move();
  }
}

function showTime(){
  var date = new Date();
  var h = date.getHours(); // 0 - 23
  var m = date.getMinutes(); // 0 - 59
  var s = date.getSeconds(); // 0 - 59
  var session = "AM";
  if(h == 0){
    h = 12;
  }
  if(h > 12){
    h = h - 12;
    session = "PM";
  }
  h = (h < 10) ? "0" + h : h;
  m = (m < 10) ? "0" + m : m;
  s = (s < 10) ? "0" + s : s;
  var time = h + ":" + m + ":" + s + " " + session;
  document.getElementById("time").innerText = time;
  document.getElementById("time").textContent = time;
  setTimeout(showTime, 1000);
}

