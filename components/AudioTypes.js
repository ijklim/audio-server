Vue.component('audio-player', {
  template: `
    <div>
      {{ file.audioName }}
      <audio controls>
        <source :src="file.audioPath" type="audio/mp3">
        Your browser does not support the audio element.
      </audio>
    </div>
    `,

  props: ['file'],

  mounted() {
    // console.log(this.file.audioName);
  }
});

Vue.component('audio-types', {
  template: `
    <div class='col-12'>
      <div
        v-for='(audioType, index) in audioTypes'
        :key='index'
      >
        <h2 class='my-2'>
          {{ audioType.name }}
        </h2>
        <audio-player
          v-for='(file, index) in audioType.files'
          :key='index'
          :file='file'
        >
        </audio-player>
      </div>
    </div>
    `,

  
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
