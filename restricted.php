<?php require_once __DIR__ . '/autoload.php'; ?>
<?php require_once __DIR__ . '/views/master/header.php'; ?>
<?php
    if (!isset($folderCode)) {
        // Unauthorized access
        echo "Access denied";
        exit;
    }
?>

<body>
  <div id='app' class='container'>
    <div class='row my-3'>
      <h1 class='col-12'><?= $_ENV['APP_NAME'] ?></h1>
      <h6 class='col-12'><?= 'v.'.config('version') ?></h6>
      <restricted-audios v-bind='{folderCode}'></restricted-audios>
    </div>
  </div>

<?php require('./views/master/js.php'); ?>
<script src="./components/RestrictedAudios.js"></script>
<script>
new Vue({
  el: '#app',
  data() {
    return {
      folderCode: '<?= $folderCode ?>'
    }
  }
});
</script>
<?php require('./views/master/last.php'); ?>