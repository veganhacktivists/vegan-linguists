window.LanguagePicker = new (class {
  addLanguage = (input, languages) => {
    if (this.doesLanguageExist(input.value)) {
      languages.push(this.getLanguageId(input.value))
      input.value = ''
    }
  }

  doesLanguageExist(name) {
    return !!document.querySelector(`option[value='${name}']`)
  }

  getLanguageId(name) {
    return document.querySelector(`option[value='${name}']`).dataset.id
  }

  getLanguageCode(id) {
    return document
      .querySelector(`option[data-id='${id}']`)
      .dataset.code.toUpperCase()
  }
})()
