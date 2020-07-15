<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="voyager-rum-1"></i> {{ __('voyager::theme.footer_copyright2') }}
        @else
            {!! __('voyager::theme.footer_copyright') !!} <a href="http://loginweb.dev" target="_blank">LoginWeb</a>
        @endif
        V{{ env('APP_VERSION', '0.1') }}
    </div>
</footer>
