// menu dropdown link clickable
jQuery( document ).ready( function ( $ ) {
    $( '.navbar .dropdown > a, .dropdown-menu > li > a, .navbar .dropdown-submenu > a, .widget-menu .dropdown > a, .widget-menu .dropdown-submenu > a' ).click( function () {
        location.href = this.href;
    } );
} );

// scroll to top button
jQuery( document ).ready( function ( $ ) {
    $( "#back-top" ).hide();
    $( function () {
        $( window ).scroll( function () {
            if ( $( this ).scrollTop() > 100 ) {
                $( '#back-top' ).fadeIn();
            } else {
                $( '#back-top' ).fadeOut();
            }
        } );

        // scroll body to 0px on click
        $( '#back-top a' ).click( function () {
            $( 'body,html' ).animate( {
                scrollTop: 0
            }, 800 );
            return false;
        } );
    } );
} );
// Tooltip
jQuery( document ).ready( function ( $ ) {
    $( function () {
        $( '[data-toggle="tooltip"]' ).tooltip()
    } )
} );
// Popover
jQuery( document ).ready( function ( $ ) {
    $( function () {
        $( '[data-toggle="popover"]' ).popover( { html: true } )
    } )
} );
// Wishlist count ajax update
jQuery( document ).ready( function ( $ ) {
    $( 'body' ).on( 'added_to_wishlist', function () {
        $( '.top-wishlist .count' ).load( yith_wcwl_plugin_ajax_web_url + ' .top-wishlist span', { action: 'yith_wcwl_update_single_product_list' } );
    } );
} );

// FlexSlider Carousel
jQuery( document ).ready( function ( $ ) {
    $( '.carousel-row' ).each( function () {
        var $aSelected = $( this ).find( 'ul' );
        if ( $aSelected.hasClass( 'products' ) ) {
            var id = $( this ).attr( 'data-container' ),
                columns = $( '#carousel-' + id ).data( 'columns' ),
                $window = $( window ),
                flexslider = { vars: { } };
            // tiny helper function to add breakpoints
            function getGridSize() {
                return ( window.innerWidth < 520 ) ? 1 :
                    ( window.innerWidth < 768 ) ? 2 : columns;
            }
            $( window ).load( function () {
                $( '#carousel-' + id ).flexslider( {
                    animation: "slide",
                    controlNav: false,
                    selector: ".products > li",
                    animationLoop: false,
                    slideshow: true,
                    itemWidth: 124,
                    itemMargin: 20,
                    prevText: "",
                    nextText: "",
                    minItems: getGridSize(),
                    maxItems: getGridSize(),
                    start: function ( slider ) {
                        flexslider = slider;
                        slider.removeClass( 'loading-hide' );
                        slider.resize();
                    }
                } );
            } );
            $( window ).resize( function () {
                var gridSize = getGridSize();

                flexslider.vars.minItems = gridSize;
                flexslider.vars.maxItems = gridSize;

            } );
        }
    } );
} );

// FlexSlider
jQuery( document ).ready( function ( $ ) {
    $( '.product-slider' ).each( function () {
        var id = $( this ).attr( 'data-container' );
        $( window ).load( function () {
            $( '#single-slider-' + id ).flexslider( {
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: true,
                start: function ( slider ) {
                    flexslider = slider;
                    slider.removeClass( 'loading-hide' );
                }
            } );
        } );
    } );
} );
// Home Carousel
jQuery( document ).ready( function ( $ ) {
    $( '#home-carousel' ).carousel();

    $( '#home-carousel.carousel .item' ).each( function () {
        var next = $( this ).next();
        if ( !next.length ) {
            next = $( this ).siblings( ':first' );
        }
        next.children( ':first-child' ).clone().appendTo( $( this ) );
        if ( next.next().length > 0 ) {
            next.next().children( ':first-child' ).clone().appendTo( $( this ) ).addClass( 'rightest' );
        } else {
            $( this ).siblings( ':first' ).children( ':first-child' ).clone().appendTo( $( this ) );
        }
    } );
} );
// Home slider
jQuery( document ).ready( function ( $ ) {
    $( '#maxstore-slider' ).carousel();
} );

