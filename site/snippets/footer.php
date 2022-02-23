<div class="footer">
  <div class="content-wrapper">
    <div class="content">
      <?= $site->footerText()->kti() ?>
    </div>
  </div>
</div>

<style>
.footer .content-wrapper .content {
  transition: left 2000ms ease-in-out;
}
</style>

<script>
// var footerCount;
// var footerInterval;
// setFooterAnimation();

// function setFooterAnimation () {
//   if (footerInterval) { clearInterval(footerInterval); }
//   var footerWrapper = $(".footer .content-wrapper")[0];
//   var footerContent = $(".footer .content")[0];
//   var fcw = footerContent.offsetWidth;
//   var fww = footerWrapper.offsetWidth;
//   // console.log(fcw, "fcw", fww, "fww")
//   if (fww < fcw) {
//     var diff = fcw - fww;
//     var time = diff * 30;
//     var ease = "linear";
//     // var ease = "ease-in-out";
//     console.log(time, "time")
//     footerContent.style.transition = "left "+ Math.round(time) +"ms "+ ease;
//     footerCount = 0;
//     var move = function () {
//       var left = (footerCount % 2 === 0) ? (-diff) : 0;
//       $(footerContent).css("left", left + "px");
//       footerCount++;
//       // console.log(footerCount, "footerCount")
//     }
//     footerInterval = setInterval(move, time + 1000);
//     move();
//   }
// }

</script>

<?= js(['assets/js/common.js']) ?>

</main>
</body>
</html>
