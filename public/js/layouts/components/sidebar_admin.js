document.addEventListener( 'DOMContentLoaded', function () {

    const collapses = document.querySelectorAll( '.sidebar .collapse' );
    const triggers = document.querySelectorAll( '.dropdown-toggle-custom' );

    // Helper: detect mobile
    const isMobile = () => window.innerWidth <= 768;

    collapses.forEach( currentCollapse => {

        // Saat dropdown dibuka
        currentCollapse.addEventListener( 'show.bs.collapse', function () {

            // Tutup dropdown lain
            collapses.forEach( otherCollapse => {
                if ( otherCollapse !== currentCollapse ) {
                    const instance = bootstrap.Collapse.getInstance( otherCollapse );
                    if ( instance ) instance.hide();
                }
            } );

            // Update aria
            const trigger = document.querySelector(
                `[data-bs-target="#${currentCollapse.id}"]`
            );
            if ( trigger ) trigger.setAttribute( 'aria-expanded', 'true' );
        } );

        // Saat dropdown ditutup
        currentCollapse.addEventListener( 'hide.bs.collapse', function () {
            const trigger = document.querySelector(
                `[data-bs-target="#${currentCollapse.id}"]`
            );
            if ( trigger ) trigger.setAttribute( 'aria-expanded', 'false' );
        } );
    } );

    // AUTO CLOSE SIDEBAR SAAT KLIK SUBMENU (MOBILE ONLY)
    document.querySelectorAll( '.sidebar .collapse .nav-link' ).forEach( link => {
        link.addEventListener( 'click', function () {
            if ( !isMobile() ) return;

            collapses.forEach( collapse => {
                const instance = bootstrap.Collapse.getInstance( collapse );
                if ( instance ) instance.hide();
            } );
        } );
    } );

} );