import Quill from 'quill'

document.addEventListener('alpine:init', () => {
  window.Alpine.data('richTextEditor', (isReadOnly = false) => ({
    init() {
      const content = JSON.parse(this.$refs.editorContent.innerText || '{}')
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

      if (!isReadOnly) {
        this.editor.focus()
      }
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
    const length = this.quill.getLength()
    return this.quill.setSelection(length, length)
  }

  setContent(content) {
    this.quill.setContents(content, 'api')

    return this
  }
}

window.RichTextEditor = RichTextEditor
