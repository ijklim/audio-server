Vue.component('audio-type', {
  template: `
    <div>
      <h4
        @click='toggle'
        class='card-header bg-dark text-light'
        :class='{ "clickable": collapsible }'
      >
        {{ audioType.name }}
        <button
          class='btn btn-sm float-right'
          :class='{ "btn-danger": show, "btn-success": !show, "d-none": !collapsible }'
        >
          {{ buttonText }}
        </button>
      </h4>
      <div v-if='show' class='card-body row'>
        <audio-player
          v-for='(file, index) in audioType.audioFiles'
          :key='index'
          :file='file'
        />
      </div>
    </div>
  `,

  // props: ['audioType'],
  props: {
    audioType: {
      type: Object,
      default: {}
    },
    collapsible: {
      default: true
    }
  },
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
      if (this.collapsible) {
        this.show = !this.show;
      }
    }
  },

  mounted() {
    if (!this.collapsible) {
      // Expand
      this.show = true;
    }
  }
});