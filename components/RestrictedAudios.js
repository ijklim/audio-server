Vue.component('restricted-audios', {
  template: `
    <div class='col-12'>
      <audio-type
        class='card border-dark my-2'
        v-for='(audioType, index) in audioTypes'
        :key='index'
        v-bind='{audioType, collapsible}'
      />
    </div>
    `,

  
  props: ['folderCode'],
  data() {
    return {
      audioTypes: [],
      collapsible: false
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
    // fetch('/api/get-restricted-files.php?folderCode=' + this.folderCode)
      .then(response => response.json())
      .then(json => {
        this.audioTypes = json;
      })
      .catch(error => {
        console.error("Encountered a problem retrieving restricted audio files: " + error);
      });
  }

});
