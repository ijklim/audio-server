Vue.component('audio-player', {
  template: `
    <div class='col-lg-4 col-md-6 col-12 mb-3'>
      <div class='card-title'>
        {{ file.audioName }}
      <div>
      <div class='card-text mt-2'>
        <audio controls controlsList='nodownload'>
          <source :src="file.audioPath" type="audio/mpeg">
          Your browser does not support the <code>audio</code> element.
        </audio>
      </div>
    </div>
    `,

  props: ['file']
});

Vue.component('restricted-audios', {
  template: `
    <div class='col-12'>
      <audio-player
        v-for='(audioFile, index) in audioFiles'
        :key='index'
        :file='audioFile'
      />
    </div>
    `,

  
  props: ['folderCode'],
  data() {
    return {
      audioFiles: []
    }
  },

  mounted() {
    // Fetch audio files
    var fetchInit = {
      method: 'GET',
      headers: new Headers(),
      mode: 'cors',
      cache: 'default'
    };

    fetch('/api/get-restricted-files.php?folderCode=' + this.folderCode, fetchInit)
      .then(response => response.json())
      .then(json => {
        // console.log(json)
        this.audioFiles = json;
      })
      .catch(error => {
        console.error("Encountered a problem retrieving audio files: " + error);
      });
  }

});
