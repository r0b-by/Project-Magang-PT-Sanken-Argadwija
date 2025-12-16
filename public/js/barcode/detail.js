// Proteksi klik kanan
document.addEventListener( 'contextmenu', function ( e ) {
    e.preventDefault();
    return false;
} );

// Disable keyboard shortcuts
document.addEventListener( 'keydown', function ( e ) {
    // F12 - Developer Tools
    if ( e.keyCode === 123 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+Shift+I - Inspect
    if ( e.ctrlKey && e.shiftKey && e.keyCode === 73 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+Shift+J - Console
    if ( e.ctrlKey && e.shiftKey && e.keyCode === 74 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+U - View Source
    if ( e.ctrlKey && e.keyCode === 85 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+S - Save
    if ( e.ctrlKey && e.keyCode === 83 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+P - Print
    if ( e.ctrlKey && e.keyCode === 80 ) {
        e.preventDefault();
        return false;
    }
    // Ctrl+C - Copy
    if ( e.ctrlKey && e.keyCode === 67 ) {
        e.preventDefault();
        return false;
    }
} );

// Disable text selection
document.onselectstart = function () {
    return false;
};

// Disable drag
document.ondragstart = function () {
    return false;
};

// Disable copy event
document.addEventListener( 'copy', function ( e ) {
    e.preventDefault();
    return false;
} );

// Disable cut event
document.addEventListener( 'cut', function ( e ) {
    e.preventDefault();
    return false;
} );

// Proteksi mobile - Long press
let touchStartTime = 0;
document.addEventListener( 'touchstart', function ( e ) {
    touchStartTime = Date.now();
} );

document.addEventListener( 'touchend', function ( e ) {
    let touchDuration = Date.now() - touchStartTime;
    if ( touchDuration > 500 ) {
        e.preventDefault();
        return false;
    }
} );

// Disable iOS callout
document.body.style.webkitTouchCallout = 'none';