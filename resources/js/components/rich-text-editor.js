import debounce from 'lodash/debounce'
import Quill from 'quill'

document.addEventListener('alpine:init', () => {
  window.Alpine.data(
    'richTextEditor',
    ({
      readonly = false,
      autofocus = false,
      content = {},
      wireContentModel = null,
      wirePlainTextModel = null,
    }) => ({
      editor: null,

      init() {
        const toolbar = readonly
          ? false
          : [
              [{ header: [1, 2, 3, 4, 5, 6, false] }],
              [{ font: [] }],
              ['bold', 'italic', 'underline', 'strike'],
              [{ list: 'ordered' }, { list: 'bullet' }, { align: [] }],
              [{ indent: '-1' }, { indent: '+1' }],
              ['blockquote', 'link', 'video'],
              [{ direction: 'rtl' }],
              [{ color: [] }, { background: [] }],
              ['clean'],
            ]

        /*
         * Note: Gerard, why not just do `this.editor = ...` right away?
         * For some reason, Alpine puts data inside of a Proxy, and things
         * seem to break if we call `setContents()` on a Proxy. Future person,
         * change at your own risk.
         */
        const editor = new Quill(this.$refs.editorContainer, {
          theme: 'snow',
          modules: {
            toolbar,
          },
          readOnly: readonly,
          scrollingContainer: getScrollParent(this.$refs.editorContainer),
        })
        editor.setContents(content, 'api')

        this.editor = editor
        this.editor.on(
          'text-change',
          debounce(() => {
            const content = this.getContent()
            const plainText = this.getPlainText()

            if (wireContentModel) {
              this.$wire.set(wireContentModel, content)
            }

            if (wirePlainTextModel) {
              this.$wire.set(wirePlainTextModel, plainText)
            }

            this.$dispatch('change', { content, plainText })
          }, 300),
        )

        if (!readonly && autofocus) {
          this.focus()
        }
      },

      getContent() {
        return JSON.stringify(this.editor.getContents())
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
      },

      getPlainText() {
        return this.editor.getText().replace(/</g, '&lt;').replace(/>/g, '&gt;')
      },

      focus() {
        const length = this.editor.getLength()
        this.editor.setSelection(length, length)
      },

      setContent(content) {
        this.editor.setContents(content, 'api')
      },

      clear() {
        this.$refs.editorContainer.querySelector('.ql-editor').innerHTML = ''
      },
    }),
  )
})

const getScrollParent = (node) => {
  if (!node) {
    return document.documentElement
  }

  const overflowY =
    (node instanceof HTMLElement && window.getComputedStyle(node).overflowY) ||
    ''

  const isScrollable = !(
    overflowY.includes('hidden') || overflowY.includes('visible')
  )

  if (isScrollable && node.scrollHeight >= node.clientHeight) {
    return node
  }

  return getScrollParent(node.parentNode)
}
