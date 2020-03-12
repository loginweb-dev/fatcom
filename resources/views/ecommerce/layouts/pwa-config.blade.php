{{-- PWA --}}
    <!-- CODELAB: Add link rel manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- CODELAB: Add iOS meta tags and icons -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ setting('admin.title') ?? 'FATCOM' }}">
    <link rel="apple-touch-icon" href="img/icons/icon-152x152.png">
    <!-- CODELAB: Add description here -->
    <meta name="description" content="{{ setting('admin.descripcion') }}">
    <!-- CODELAB: Add meta theme-color -->
    <meta name="theme-color" content="#343A40" />

    <script>
        // CODELAB: Register service worker.
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((reg) => {
                    // console.log('Service worker registered.', reg);
                });
            });
        }
    </script>
{{-- END PWA --}}