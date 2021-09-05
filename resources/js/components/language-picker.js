import autocomplete from 'autocompleter'

const RESULTS_GAP = 10 // px
const MIN_CLEARANCE_UNDER_INPUT = 100

window.LanguagePicker = class {
  constructor({
    el,
    onSelect,
    emptyMessage,
    languages,
    displayTranslatedLanguageName,
  }) {
    this.chosenLanguages = []
    this.languages = languages

    this.autocomplete = autocomplete({
      input: el,
      emptyMsg: emptyMessage,
      minLength: 1,

      fetch: (text, update) => {
        text = text.toLocaleLowerCase()

        const results = languages.filter(({ code, name, native_name }) => {
          return (
            !this.chosenLanguages.find((l) => l.code === code) &&
            (code.toLocaleLowerCase().includes(text) ||
              name.toLocaleLowerCase().includes(text) ||
              native_name.toLocaleLowerCase().includes(text))
          )
        })

        update(results)
      },

      onSelect: (language) => {
        el.value = ''
        onSelect(language, this.setChosenLanguages)
      },

      render: (language) => {
        const resultEl = document.createElement('div')

        resultEl.textContent = displayTranslatedLanguageName
          ? `${language.name} (${language.native_name})`
          : language.native_name

        return resultEl
      },

      customize: function (input, inputRect, container, maxHeight) {
        if (window.innerHeight - MIN_CLEARANCE_UNDER_INPUT < inputRect.bottom) {
          const top = window.scrollY + RESULTS_GAP

          container.style.top = `${top}px`
          container.style.maxHeight = `${inputRect.top - RESULTS_GAP * 2}px`
        } else {
          container.style.top = `${inputRect.bottom + RESULTS_GAP}px`
          container.style.maxHeight = `${maxHeight - RESULTS_GAP * 2}px`
        }
      },
    })
  }

  setChosenLanguages = (languages) => {
    this.chosenLanguages = languages
  }
}
