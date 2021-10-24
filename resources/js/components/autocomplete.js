import autocomplete from 'autocompleter'

const RESULTS_GAP = 10 // px
const MIN_CLEARANCE_UNDER_INPUT = 100 // px

document.addEventListener('alpine:init', () => {
  window.Alpine.data(
    'autocomplete',
    ({
      input,
      emptyMessage,
      items,
      comparator,
      renderItem,
      renderItemLabel,
      getItemValue,
      defaultItems = [],
      wireModel = null,
      multiSelect = true,
      minLength = 1,
      resultsClass = '',
    }) => ({
      autocomplete: null,
      isDisplayingResults: false,
      selectedItems: [],
      getItemValue,
      renderItemLabel,

      init() {
        input.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' && this.isDisplayingResults) {
            e.preventDefault()
          }
        })

        input.addEventListener('blur', (e) => {
          this.isDisplayingResults = false
        })

        this.$watch('selectedItems', (selectedItems) =>
          this.onChange(selectedItems),
        )

        this.selectedItems = defaultItems

        this.autocomplete = autocomplete({
          input,
          emptyMsg: emptyMessage,
          minLength,

          fetch: (text, update) => {
            this.isDisplayingResults = true

            update(this.getMatchingItems(text))
          },

          onSelect: (item) => {
            this.select(item)
          },

          render: (item) => {
            const resultEl = document.createElement('div')

            resultEl.textContent = renderItem(item)

            return resultEl
          },

          customize: function (input, inputRect, container, maxHeight) {
            container.classList.add(resultsClass)

            if (
              window.innerHeight - MIN_CLEARANCE_UNDER_INPUT <
              inputRect.bottom
            ) {
              const bottom = window.innerHeight - window.scrollY - inputRect.top

              container.style.top = ''
              container.style.bottom = `${bottom + RESULTS_GAP * 2}px`
              container.style.maxHeight = `${inputRect.top - RESULTS_GAP * 4}px`
            } else {
              container.style.top = `${
                inputRect.bottom + window.scrollY + RESULTS_GAP
              }px`
              container.style.maxHeight = `${maxHeight - RESULTS_GAP * 2}px`
            }
          },
        })
      },

      select(item) {
        if (multiSelect) {
          this.selectedItems.push(item)
        } else {
          this.selectedItems = [item]
        }

        this.isDisplayingResults = false
      },

      unselect(item) {
        this.selectedItems = this.selectedItems.filter(
          (i) => this.getItemValue(i) !== this.getItemValue(item),
        )
      },

      attemptToSelectItem() {
        if (!input.value) return

        const item = this.getMatchingItems(input.value).find(
          (item) => input.value === renderItem(item),
        )

        if (item) {
          this.select(item)
        } else {
          this.selectedItems = this.selectedItems.slice()
        }
      },

      getMatchingItems(text) {
        text = text.toLocaleLowerCase()

        return items.filter(
          (item) =>
            !this.selectedItems.find(
              (i) => getItemValue(i) === getItemValue(item),
            ) && comparator(text, item),
        )
      },

      onChange(selectedItems) {
        if (multiSelect) {
          input.value = ''

          if (wireModel) {
            this.$wire.set(wireModel, selectedItems.map(getItemValue))
          }
        } else {
          input.value = this.selectedItems.length
            ? renderItem(this.selectedItems[0])
            : ''

          if (wireModel) {
            this.$wire.set(
              wireModel,
              selectedItems.length ? getItemValue(selectedItems[0]) : null,
            )
          }
        }
      },
    }),
  )
})
