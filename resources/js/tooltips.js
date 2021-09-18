import tippy from 'tippy.js/headless'

document.addEventListener('DOMContentLoaded', () => {
  const targets = document.querySelectorAll('[data-tooltip]')

  tippy(targets, {
    content(instance) {
      return instance.dataset.tooltip
    },
    render(instance) {
      // The recommended structure is to use the popper as an outer wrapper
      // element, with an inner `box` element
      const popper = document.createElement('div')
      const box = document.createElement('div')

      popper.appendChild(box)

      box.className = 'bg-gray-800 text-white p-2 shadow rounded'
      box.textContent = instance.props.content

      function onUpdate(prevProps, nextProps) {
        // DOM diffing
        if (prevProps.content !== nextProps.content) {
          box.textContent = nextProps.content
        }
      }

      // Return an object with two properties:
      // - `popper` (the root popper element)
      // - `onUpdate` callback whenever .setProps() or .setContent() is called
      return {
        popper,
        onUpdate, // optional
      }
    },
  })
})
