@if (config('app.env') === 'production')
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=G-Y7TQD4J5Z7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        dataLayer.push(['js', new Date()]);
        dataLayer.push(['config', 'G-Y7TQD4J5Z7']);
    </script>
@endif
