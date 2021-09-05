import { autocomplete } from '@algolia/autocomplete-js'

window.LanguagePicker = class {
  constructor({
    el,
    onSelect,
    noResults,
    languages,
    displayTranslatedLanguageName,
  }) {
    this.chosenLanguages = []
    this.languages = languages

    this.autocomplete = autocomplete({
      container: el,

      getSources: () => {
        return [
          {
            sourceId: 'links',
            templates: {
              item({ item, createElement, Fragment }) {
                const languageName = displayTranslatedLanguageName
                  ? `${item.name} (${item.native_name})`
                  : item.native_name
                return createElement(Fragment, {}, languageName)
              },
              noResults() {
                return noResults
              },
            },

            getItems: ({ query }) => {
              query = query.toLocaleLowerCase()

              return this.languages.filter(({ code, name, native_name }) => {
                return (
                  !this.chosenLanguages.find((l) => l.code === code) &&
                  (code.toLocaleLowerCase().includes(query) ||
                    name.toLocaleLowerCase().includes(query) ||
                    native_name.toLocaleLowerCase().includes(query))
                )
              })
            },

            onSelect: ({ item, setQuery }) => {
              setQuery('')
              onSelect(item, this.setChosenLanguages)
            },
          },
        ]
      },
    })
  }

  setChosenLanguages = (languages) => {
    this.chosenLanguages = languages
  }
}
