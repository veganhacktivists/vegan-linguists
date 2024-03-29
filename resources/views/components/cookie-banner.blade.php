<div
  class="fixed bottom-0 inset-x-0 md:left-1/2 md:-translate-x-1/2 md:w-1/2 flex justify-between border border-t-brand-beige-500 bg-brand-beige-100 p-3 text-sm text-brand-brown-800 shadow-lg"
  id="cookie-banner" x-cloak>
  <p class="flex items-center pr-6">
    <span>
      {!! __(
          'We use cookies to help us improve Vegan Linguists. To learn more, view our :privacyPolicyLink, or opt out by installing :browserAddonLink.',
          [
              'privacyPolicyLink' =>
                  '<a href="' .
                  route('policy.show') .
                  '" class="text-brand-clay-500 hover:text-brand-clay-600">' .
                  __('Privacy Policy') .
                  '</a>',
              'browserAddonLink' =>
                  '<a href="https://tools.google.com/dlpage/gaoptout" class="text-brand-clay-500 hover:text-brand-clay-600" target="_blank">Google Analytics Opt-out Browser Add-on</a>',
          ],
      ) !!}
    </span>
  </p>
  <button id="btn-dismiss-cookie-banner">
    <div class="sr-only">{{ __('Dismiss') }}</div>
    <x-heroicon-o-x-mark class="h-6 w-6" />
  </button>
</div>
<script>
  (function() {
    const isDismissed = localStorage.getItem('cookieBannerDismissed')
    if (!isDismissed) {
      const cookieBanner = document.getElementById('cookie-banner')
      cookieBanner.removeAttribute('x-cloak')

      document.getElementById('btn-dismiss-cookie-banner').addEventListener('click', () => {
        cookieBanner.outerHTML = ''
        localStorage.setItem('cookieBannerDismissed', 1)
      })
    }
  })()
</script>
