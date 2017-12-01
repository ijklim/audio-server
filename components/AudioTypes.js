Vue.component('audio-player', {
  template: `
    <div class='col-lg-4 col-md-6 col-12 mb-3'>
      <div class='card-title'>
        {{ file.audioName }}
      <div>
      <div class='card-text mt-2'>
        <audio controls>
          <source :src="file.audioPath" type="audio/mpeg">
          Your browser does not support the <code>audio</code> element.
        </audio>
      </div>
    </div>
    `,

  props: ['file']
});

Vue.component('audio-types', {
  template: `
    <div class='col-12'>
      <div
        class='card border-warning my-2'
        v-for='(audioType, index) in audioTypes'
        :key='index'
      >
        <h5 class="card-header bg-warning">
          {{ audioType.name }}
        </h5>
        <div class='card-body row'>
          <audio-player
            v-for='(file, index) in audioType.files'
            :key='index'
            :file='file'
          />
        </div>
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
