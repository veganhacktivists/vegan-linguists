import Quill from 'quill'

document.addEventListener('alpine:init', () => {
  window.Alpine.data('richTextEditor', (content = '', isReadOnly = false) => ({
    init() {
      this.editor = new RichTextEditor(this.$refs.editorContainer, isReadOnly)
        .setContent(content)
        .on(
          'text-change',
          _.debounce(() => {
            this.$dispatch('change', {
              content: this.editor.getContent(),
              plainText: this.editor.getPlainText(),
            })
          }, 300),
        )
    },

    editor: null,
  }))
})

class RichTextEditor {
  constructor(el, readOnly) {
    const toolbar = readOnly
      ? false
      : [
          [{ header: [1, 2, 3, 4, 5, 6, false] }],
          [{ font: [] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ list: 'ordered' }, { list: 'bullet' }, { align: [] }],
          [{ indent: '-1' }, { indent: '+1' }],
          ['blockquote', 'link', 'image', 'video'],
          [{ direction: 'rtl' }],
          [{ color: [] }, { background: [] }],
          ['clean'],
        ]

    this.quill = new Quill(el, {
      theme: 'snow',
      modules: {
        toolbar,
      },
      readOnly,
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

  setContent(content) {
    this.quill.setContents(content, 'api')

    return this
  }
}

window.RichTextEditor = RichTextEditor
