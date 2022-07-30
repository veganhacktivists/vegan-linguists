@if (config('app.env') === 'production')
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=G-Y7TQD4J5Z7" nonce="{{ csp_nonce() }}"></script>
    <script nonce="{{ csp_nonce() }}">
        (function() {
            window.dataLayer = window.dataLayer || [];

            function gtag(){ dataLayer.push(arguments) }

            gtag('js', new Date());
            gtag('config', 'G-Y7TQD4J5Z7');
        })()
    </script>
@endif
