<?php require_once __DIR__ . '/autoload.php'; ?>
<?php require_once __DIR__ . '/views/master/header.php'; ?>

<body>
  <div id='app' class='container'>
    <div class='row my-3'>
      <h1 class='col-12'><?= $_ENV['APP_NAME'].' v.'.$_ENV['APP_VERSION'] ?></h1>
      <audio-types></audio-types>
    </div>
  </div>

<?php require('./views/master/js.php'); ?>
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