$( document ).ready( function () {
    // Auto-dismiss alerts after 5 seconds
    setTimeout( function () {
        $( '.alert' ).each( function () {
            $( this ).fadeOut( 400, function () {
                $( this ).alert( 'close' );
            } );
        } );
    }, 5000 );

    // Smooth scroll to top
    $( 'a[href="#top"]' ).click( function ( e ) {
        e.preventDefault();
        $( 'html, body' ).animate( { scrollTop: 0 }, 600 );
    } );

    // Add loading state to buttons on form submit
    $( 'form' ).on( 'submit', function () {
        $( this ).find( 'button[type="submit"]' ).addClass( 'loading' ).prop( 'disabled', true );
    } );

    // Confirm delete actions
    $( '.btn-delete, .delete-action' ).on( 'click', function ( e ) {
        if ( !confirm( 'Apakah Anda yakin ingin menghapus data ini?' ) ) {
            e.preventDefault();
            return false;
        }
    } );

    // Tooltip initialization
    var tooltipTriggerList = [].slice.call( document.querySelectorAll( '[data-bs-toggle="tooltip"]' ) );
    tooltipTriggerList.map( function ( tooltipTriggerEl ) {
        return new bootstrap.Tooltip( tooltipTriggerEl );
    } );
} );