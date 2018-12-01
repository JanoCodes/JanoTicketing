<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/' . $script) }}"></script>
<script type="text/javascript">
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

    if (width < 768) {
        var slideout = new Slideout({
            'panel': document.getElementById('container'),
            'menu': document.getElementById('responsive-menu'),
            'padding': 256,
            'tolerance': 70
        });

        $('.sidebar-toggle').on('click', function() {
            slideout.toggle();
        });
        $('.sidebar-close').on('click', function() {
            slideout.close();
        });
    }
</script>
@stack('scripts')