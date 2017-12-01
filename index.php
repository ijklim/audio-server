<?php require_once __DIR__ . '/autoload.php'; ?>
<?php require_once __DIR__ . '/views/master/header.php'; ?>

<body>
  <div id='app' class='container'>
    <div class='row my-3'>
      <h1 class='col-12'><?= $_ENV['APP_NAME'].' v.'.$_ENV['APP_VERSION'] ?></h1>
      <audio-types></audio-types>
      <div
        class='col-12'
        v-for='(audioType, index) in audioTypes'
        :key='index'
      >
        <h2 class='my-2'>
          {{ audioType.name }}
        </h2>
        <ul>
          <li
            v-for='(file, index) in audioType.files'
            :key='index'
          >
            {{ file }}
          </li>
        </ul>
      </div>
    </div>
  </div>

<?php require('./views/master/js.php'); ?>
<script src="./components/AudioTypes.js"></script>
<script>
new Vue({
  el: '#app',
  data() {
    return {
      audioTypes: []
    }
  },

  mounted() {
    // Fetch audio types
    fetch('/api/get-audio-files.php')
      .then(response => response.json())
      .then(json => {
        // console.log(json)
        this.audioTypes = json;
      })
      .catch(error => {
        console.error("Encountered a problem retrieving audio types: " + error);
      });
  }
});
</script>
<?php require('./views/master/last.php'); ?>