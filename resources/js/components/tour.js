import Shepherd from 'shepherd.js'

document.addEventListener('alpine:init', () => {
  window.Alpine.data(
    'tour',
    ({ nextText, backText, closeText, steps = [], opts = {} } = {}) => ({
      init() {
        this.tour = new Shepherd.Tour({
          ...opts,
          modalContainer: document.getElementById('tourContainer'),
        })

        this.tour.addSteps(
          steps.map((step, i) => {
            const buttons = []

            if (i !== 0) {
              buttons.push({
                text: backText,
                action: this.tour.back,
                secondary: true,
              })
            }

            if (i === steps.length - 1) {
              buttons.push({
                text: closeText,
                action: this.tour.cancel,
              })
            } else {
              buttons.push({
                text: nextText,
                action: this.tour.next,
              })
            }

            return {
              ...step,
              buttons,
            }
          }),
        )
      },

      start() {
        this.tour.start()
      },
    }),
  )
})
