<?php require_once __DIR__ . '/views/master/header.php'; ?>

<body>
  <div id='app' class='container'>
    <div class='row my-3'>
      <h1 class='col-12'><?= $_ENV['APP_NAME'] ?></h1>
      <h6 class='col-12'><?= 'v.'.config('version') ?></h6>
      <audio-types></audio-types>
    </div>
  </div>

<?php require('./views/master/js.php'); ?>
<script src="./components/AudioPlayer.js"></script>
<script src="./components/AudioType.js"></script>
<script src="./components/AudioTypes.js"></script>
<script>
new Vue({
  el: '#app',
  data() {
    return {
    }
  }
});
</script>
<?php require('./views/master/last.php'); ?>