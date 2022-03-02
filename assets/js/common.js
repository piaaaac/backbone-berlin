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
    $(".arrow-left[data-bubble-id!='']").last().click();
  }
  if (key === 'ArrowRight' || key === 'Right' || key === 39) { 
    $(".arrow-right[data-bubble-id!='']").last().click();
  }
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








function handleArrowClick (direction, menuContext, level) {
  // find bubbleId using siteIndex
  var bubbleId;

  console.log(direction +"---"+ menuContext +"---"+ level)

  if (level == 1) {

    var currI = window.siteIndex.findIndex(e => (e.id === state.currentBubbleId));
    if (currI === -1) { throw "Error 23987511"; }
    var indexItem = window.siteIndex[currI];
    console.log("indexItem", indexItem)
    var newI = currI + (direction === "left" ? -1 : 1);
    if (newI < 0 || newI >= window.siteIndex.length) { throw "Error 32895764"; }
    console.log("newI", newI);
    var newIndexItem = window.siteIndex[newI];
    console.log("newIndexItem", newIndexItem);
    if (newIndexItem.children === null) {
      bubbleId = newIndexItem.id;
    } else {
      var firstChild = newIndexItem.children[0];
      bubbleId = firstChild.id;
    }

  } else {

    var indexItemL1 = window.siteIndex.find(e => (e.menuContext === menuContext));
    if (!indexItemL1) { throw "Error 42089638"; }
    var currI = indexItemL1.children.findIndex(e => (e.id === state.currentBubbleId));



    var indexItemL2 = indexItemL1.children[currI];
    console.log("indexItemL2", indexItemL2)
    var newI = currI + (direction === "left" ? -1 : 1);
    if (newI < 0 || newI >= indexItemL1.children.length) { throw "Error 32509867"; }
    console.log("newI", newI);
    var newIndexItem = indexItemL1.children[newI];
    console.log("newIndexItem", newIndexItem);
    bubbleId = newIndexItem.id;

  }

  gotoBubble(bubbleId);

/*

state = {
  currentBubbleId: "landing"
  currentMenuContext: "site"
}


w.siteIndex
[
  {id: 'landing', template: 'bubble', menuContext: 'site', index: 0, children: null}
  {
    children: null
    id: "intro"
    index: 1
    menuContext: "site"
    template: "bubble"
  }
  {id: 'sessions-21', template: 'bubble', menuContext: 'site', index: 2, children: null}
  {id: 'projects-container', template: 'container', menuContext: 'site', index: 3, children: Array(2)}
  {
    id: "other-container"
    index: 4
    menuContext: "site"
    template: "container"
    children: [
      {id: 'other-container-test-84', template: 'bubble', menuContext: 'other-container', index: 0, children: null}
      {
        children: null
        id: "other-container-test-85"
        index: 1
        menuContext: "other-container"
        template: "bubble"
      }
    ]
  }
  {id: 'calendar', template: 'bubble', menuContext: 'site', index: 5, children: null}
  {id: 'archive', template: 'bubble', menuContext: 'site', index: 6, children: null}
  {id: 'info', template: 'bubble', menuContext: 'site', index: 7, children: null}
]
*/




  var pagesLevel1 = window.siteIndex.map(function (item) {
    return item.id;
  });
  // >>> "landing", "intro", "sessions-21", "projects-container", "other-container", "calendar", "archive", "info"

  var pagesLevel2 = [];
  if (state.currentMenuContext !== "site") {
    var contextualIndex = window.siteIndex.find(function (item) {
      return item.id === state.currentMenuContext;
    });
    pagesLevel2 = contextualIndex.map(function (item) {
      return item.id;
    });
  }






}













function gotoBubble (bubbleId) {
  var links = $("nav .menu-item[data-bubble-id='"+ bubbleId +"']");
  var linkDesktop = $("nav#menu-desktop .menu-item[data-bubble-id='"+ bubbleId +"']");
  var linkMobile = $("nav.menu-mobile .menu-item[data-bubble-id='"+ bubbleId +"']");
  var bubble = bubbles.find(function (e) {
    return e.bubbleId === bubbleId;
  });
  if (!bubble) { throw "Error 23498756"; }

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

  // v1
  // var bbbgx = apMap(bubblex, 0,bubblesw, 0,bbbgw);
  var bbbgx = apMap(bubblex, 0,bubblesw, -200,bbbgw+200);

  // v2
  // var bbbgx = apMap(bubblex, 0,bubblesw, -200,bbbgw+200);
  // console.log("------------>", bbbgw, bubblesw, bbbgx)
  // var maxBubblex = bubbles.map(e => e.x).reduce((a, b) => { return Math.max(a, b) });
  // var bbbgx = apMap(bubblex, 0,maxBubblex, 0,bbbgw*2.1);

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

  // --- handle menu links (desktop & mobile)

  $("nav .menu-item").removeClass("active");
  $(links).addClass("active");

  // --- handle menu (mobile)

  adjustMobileNavFromState();
}

// V2
function adjustMobileNavFromState () {


  // state.currentBubbleId
  // state.currentMenuContext

  // --- Handle level 2 menus visibility

  $("nav[data-level='2']").addClass("hide-in-place");
  $("nav[data-level='2'][data-menu-context='"+ state.currentMenuContext +"']").removeClass("hide-in-place");



  var bubbleElement = $(".bubble[data-bubble-id='"+ state.currentBubbleId +"']")[0];

  var pagesLevel1 = window.siteIndex.map(function (item) {
    return item.id;
  });
  var indexLevel1 = pagesLevel1.indexOf(state.currentBubbleId);
  if (indexLevel1 === -1) { throw "error 43987542"; }

  var mml1iy = indexLevel1 * menuMobileH;
  $("nav.menu-mobile .items").css("top", -mml1iy +"px");
  $("nav.menu-mobile").removeClass("open");

  var pagesLevel2 = [];
  if (state.currentMenuContext !== "site") {
    var contextualIndex = window.siteIndex.find(function (item) {
      return item.id === state.currentMenuContext;
    });
    pagesLevel2 = contextualIndex.map(function (item) {
      return item.id;
    });
  }

}

// V1
// function adjustMobileNavFromState () {
//   var linkIndex = 0;
//   var found = false;
//   $("nav.menu-mobile .menu-item[data-bubble-id]").each(function () {
//     if (!found && this.dataset.bubbleId === state.currentBubbleId) {
//       found = true;
//     }
//     linkIndex += (found ? 0 : 1);
//   });
//   console.log(linkIndex)
//   var mmiy = linkIndex * menuMobileH;
//   $("nav.menu-mobile .items").css("top", -mmiy +"px");
//   $("nav.menu-mobile").removeClass("open");
//   // console.log(window.menuMeta)
//   var prevBubbleId = null;
//   var nextBubbleId = null;
//   var itemIndex = window.menuMeta.findIndex(function (e) { return e.bubbleId === state.currentBubbleId; });
//   if (itemIndex === -1) { throw "error 24398752"; }
//   if (itemIndex > 0) { prevBubbleId = window.menuMeta[itemIndex-1].bubbleId; }
//   if (itemIndex < window.menuMeta.length - 1) { nextBubbleId = window.menuMeta[itemIndex+1].bubbleId; }
//   $(".arrow-left")[0].dataset.bubbleId = (prevBubbleId ? prevBubbleId : ""); // CHECKKK
//   $(".arrow-right")[0].dataset.bubbleId = (nextBubbleId ? nextBubbleId : ""); // CHECKKK
// }

function setFooterAnimation () {
  var footerWrapper = $(".footer .content-wrapper")[0];
  var footerContent = $(".footer .content")[0];
  var fcw = footerContent.offsetWidth;
  var fww = footerWrapper.offsetWidth;
  if (footerInterval) { 
    clearInterval(footerInterval); 
    // footerContent.style.transition = "left 0ms";
    // footerContent.style.left = "0px";
    footerContent.style.transition = "transform 0ms";
    footerContent.style.transform = "translateX(0px)";
  }
  if (fww < fcw) {
    var diff = fcw - fww;
    var time = diff * 17;
    var ease = "linear"; // "ease-in-out";
    console.log(time, "time")
    // footerContent.style.transition = "left "+ Math.round(time) +"ms "+ ease;
    footerContent.style.transition = "transform "+ Math.round(time) +"ms "+ ease;
    footerCount = 0;
    var move = function () {
      var left = (footerCount % 2 === 0) ? (-diff) : 0;
      // footerContent.style.left = left + "px";
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
