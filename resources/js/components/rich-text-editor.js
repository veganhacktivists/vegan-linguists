import debounce from 'lodash/debounce'
import Quill from 'quill'

const Delta = Quill.import('delta')

document.addEventListener('alpine:init', () => {
  window.Alpine.data(
    'richTextEditor',
    ({
      readonly = false,
      autofocus = false,
      content = {},
      wireContentModel = null,
      wirePlainTextModel = null,
      hasInlineToolbar = false,
      placeholder = '',
    }) => ({
      getEditor: null,
      selection: {
        content: null,
        plainText: null,
        index: null,
        length: null,
      },

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

        const scrollingContainer = getScrollParent(this.$refs.editorContainer)

        /*
         * Note: Gerard, why not just do `this.editor = ...`?
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
          scrollingContainer,
          placeholder,
        })
        editor.setContents(content)

        this.getEditor = () => editor
        if (!readonly) window.e = editor

        // this.getEditor = editor
        editor.on(
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

        if (hasInlineToolbar) {
          editor.on('selection-change', this.positionInlineToolbar.bind(this))

          scrollingContainer.addEventListener(
            'scroll',
            this.positionInlineToolbar.bind(this),
          )
        }

        if (!readonly && autofocus) {
          this.focus()
        }
      },

      getContent(index = 0, length = undefined) {
        return JSON.stringify(this.getEditor().getContents(index, length))
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
      },

      getPlainText(index = 0, length = undefined) {
        return this.getEditor()
          .getText(index, length)
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
      },

      focus() {
        const length = this.getEditor().getLength()
        this.getEditor().setSelection(length, length)
      },

      setContent(content, format = null, formatValue = null) {
        const editor = this.getEditor()
        const length = editor.getLength()

        editor.setContents(content)
        editor.setSelection(0, length)
        if (format && formatValue) {
          editor.format(format, formatValue)
        }
        editor.setSelection(length, 0)
      },

      insertText(text) {
        const editor = this.getEditor()

        editor.insertText(editor.getLength(), text)
      },

      clear() {
        this.$refs.editorContainer.querySelector('.ql-editor').innerHTML = ''
      },

      highlight(index, length) {
        this.getEditor().setSelection(Number(index), Number(length))
      },

      positionInlineToolbar() {
        const { index = 0, length = 0 } = this.getEditor().getSelection() || {}
        const { inlineToolbar } = this.$refs

        if (length === 0) {
          this.selection = {
            content: null,
            plainText: null,
            index: null,
            length: null,
          }
          inlineToolbar.classList.add('hidden')
          return
        }

        this.selection = {
          content: this.getContent(index, length),
          plainText: this.getPlainText(index, length),
          index,
          length,
        }

        const {
          left: selectionLeft,
          top: selectionTop,
          width: selectionWidth,
        } = this.getEditor().getBounds(index, length)

        inlineToolbar.classList.remove('hidden')

        const { x: editorX, y: editorY } =
          this.$refs.editorContainer.getBoundingClientRect()

        const { height: buttonHeight, width: buttonWidth } =
          inlineToolbar.getBoundingClientRect()

        inlineToolbar.style.top = `${editorY + selectionTop - buttonHeight}px`
        inlineToolbar.style.left = `${
          editorX +
          selectionLeft +
          selectionWidth -
          (selectionWidth + buttonWidth) / 2
        }px`
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
