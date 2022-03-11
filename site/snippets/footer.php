<div class="footer">
  <div class="clock"><strong><?= t("current-time") ?></strong> <span id="time"></span></div>
  <div class="content-wrapper">
    <div class="content">
      <?= $site->footerText()->kti() ?>
    </div>
  </div>
</div>

<?= js(['assets/js/common.js']) ?>

</body>
</html>
