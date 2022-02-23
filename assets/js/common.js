
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

setFooterAnimation();
showTime();


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

$("nav .menu-item[data-bubble-id], nav#menu-mobile .arrow").click(function () {
  var bubbleId = this.dataset.bubbleId;
  gotoBubble(bubbleId);
  return false;
});

$("nav#menu-mobile:not(.open) .items").click(function () {
  $("nav#menu-mobile").addClass("open");
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
  var links = $("nav .menu-item[data-bubble-id='"+ bubbleId +"']");
  var linkDesktop = $("nav#menu-desktop .menu-item[data-bubble-id='"+ bubbleId +"']");
  var linkMobile = $("nav#menu-mobile .menu-item[data-bubble-id='"+ bubbleId +"']");

  // --- handle hash & state

  window.location.hash = bubbleId;
  state.currentBubbleId = bubbleId;

  // --- transform x bubbles

  var bubble = bubbles.find(function (e) {
    return e.bubbleId === bubbleId;
  });
  var bubblex = bubble.x + 1; // 1 accounts for border (i think)
  var transformBubbles = "translateX("+ -bubblex +"px)";
  $(".bubbles").css("transform", transformBubbles);
  $(".bubble[data-bubble-id='"+ bubbleId +"']")[0].scrollTo(0,0);
  
  // --- transform x background

  var bbbgw = $(".bbbg-wrap").width();
  var bubblesw = $(".bubbles").width();
  var bbbgx = apMap(bubblex, 0,bubblesw, 0,bbbgw);
  var transformBbbg = "translateX("+ -bbbgx +"px)";
  $(".bbbg").css("transform", transformBbbg);

  // --- desktop transform x line

  var linex = $(linkDesktop).offset().left - 5;
  var transformLine = "translateX("+ linex +"px)";
  $(".line").css("transform", transformLine);

  // --- handle menu links (desktop & mobile)

  $("nav .menu-item").removeClass("active");
  $(links).addClass("active");

  // --- handle menu (mobile)

  adjustMobileNavFromState();
}

function adjustMobileNavFromState () {
  var linkIndex = 0;
  var found = false;
  $("nav#menu-mobile .menu-item[data-bubble-id]").each(function () {
    if (!found && this.dataset.bubbleId === state.currentBubbleId) {
      found = true;
    }
    linkIndex += (found ? 0 : 1);
  });
  console.log(linkIndex)
  var mmiy = linkIndex * menuMobileH;
  $("nav#menu-mobile .items").css("top", -mmiy +"px");
  $("nav#menu-mobile").removeClass("open");

  console.log(window.menuMeta)
  var prevBubbleId = null;
  var nextBubbleId = null;
  var itemIndex = window.menuMeta.findIndex(function (e) { return e.bubbleId === state.currentBubbleId; });
  if (itemIndex === -1) { throw "error 24398752"; }
  if (itemIndex > 0) { prevBubbleId = window.menuMeta[itemIndex-1].bubbleId; }
  if (itemIndex < window.menuMeta.length - 1) { nextBubbleId = window.menuMeta[itemIndex+1].bubbleId; }
  $("#arrow-left")[0].dataset.bubbleId = (prevBubbleId ? prevBubbleId : "");
  $("#arrow-right")[0].dataset.bubbleId = (nextBubbleId ? nextBubbleId : "");

}

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
