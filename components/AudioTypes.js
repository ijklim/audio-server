Vue.component('audio-types', {
  template: `
    <div class='col-12'>
      <audio-type
        class='card border-dark my-2'
        v-for='(audioType, index) in audioTypes'
        :key='index'
        :audioType='audioType'
      />
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
