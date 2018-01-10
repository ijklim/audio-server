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