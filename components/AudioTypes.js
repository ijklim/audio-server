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

Vue.component('audio-type', {
  template: `
    <div>
      <h4
        @click='toggle'
        class="card-header bg-dark text-light clickable"
      >
        {{ audioType.name }}
        <button
          class='btn btn-sm float-right'
          :class='{ "btn-danger": show, "btn-success": !show }'
        >
          {{ buttonText }}
        </button>
      </h4>
      <div v-if='show' class='card-body row'>
        <audio-player
          v-for='(file, index) in audioType.files'
          :key='index'
          :file='file'
        />
      </div>
    </div>
  `,

  props: ['audioType'],
  data() {
    return {
      show: false
    }
  },
  computed: {
    buttonText() {
      return this.show ? '-' : '+';
    }
  },

  methods: {
    toggle() {
      this.show = !this.show;
    }
  }
});

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
