import Quill from 'quill'

class RichTextEditor {
  constructor(el) {
    this.quill = new Quill(el, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ header: [1, 2, 3, 4, 5, 6, false] }],
          [{ font: [] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ list: 'ordered' }, { list: 'bullet' }, { align: [] }],
          [{ indent: '-1' }, { indent: '+1' }],
          ['blockquote', 'link', 'image', 'video'],
          [{ direction: 'rtl' }],
          [{ color: [] }, { background: [] }],
          ['clean'],
        ],
      },
    })
  }

  on() {
    this.quill.on.apply(this.quill, arguments)

    return this
  }

  getContent() {
    return JSON.stringify(this.quill.getContents())
  }

  getPlainText() {
    return this.quill.getText()
  }

  focus() {
    return this.quill.focus()
  }
}

window.RichTextEditor = RichTextEditor
