document.addEventListener( "DOMContentLoaded", function () {
    const scanner = new Html5Qrcode( "scanner-container" );
    let scannedCode = null;

    // Start scanner
    Html5Qrcode.getCameras().then( cameras => {
        if ( cameras && cameras.length ) {
            const isMobile = /iPhone|iPad|iPod|Android/i.test( navigator.userAgent );
            const camera = cameras[0];

            document.getElementById( 'permission-message' ).classList.remove( 'd-none' );

            scanner.start(
                camera.id,
                {
                    fps: 10,
                    qrbox: 250,
                    aspectRatio: 1.0,
                },
                decodedText => {
                    scannedCode = decodedText;
                    handleSuccessfulScan( decodedText );
                    scanner.stop();
                },
                () => { } // error callback
            ).then( () => {
                document.getElementById( 'permission-message' ).classList.add( 'd-none' );
                document.getElementById( 'scan-status' ).innerHTML =
                    '<i class="fas fa-camera me-2"></i>Arahkan ke QR Code';
            } );
        } else {
            document.getElementById( 'scan-status' ).innerHTML =
                '<i class="fas fa-times-circle text-danger me-2"></i>Kamera tidak tersedia';
        }
    } );

    function handleSuccessfulScan( code ) {
        // Vibrate on mobile
        if ( navigator.vibrate ) navigator.vibrate( 100 );

        document.getElementById( 'scan-status' ).innerHTML =
            '<i class="fas fa-check-circle text-success me-2"></i>Scan berhasil';

        document.getElementById( 'scan-result-area' ).classList.remove( 'd-none' );
        document.getElementById( 'scanned-code' ).textContent = code;
    }

    document.getElementById( 'btn-process' ).addEventListener( 'click', function () {
        if ( scannedCode ) {
            window.location.href = scannedCode;
        }
    } );
} );