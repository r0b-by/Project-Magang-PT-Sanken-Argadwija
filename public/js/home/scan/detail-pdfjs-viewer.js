// Global variables for PDF.js
let pdfDoc = null;
let currentPage = 1;
let currentScale = 1.5;
let currentRotation = 0;
let isRendering = false;
let isFullscreen = false;
// Demo PDF URL - ganti dengan URL PDF Anda


function loadPDF() {
    const loadingTask = pdfjsLib.getDocument( {
        url: pdfUrl,
        withCredentials: false
    } );

    loadingTask.onProgress = function ( progressData ) {
        const progress = Math.round( ( progressData.loaded / progressData.total ) * 100 );
        document.getElementById( 'pdfProgress' ).style.width = progress + '%';
    };

    loadingTask.promise.then( function ( pdf ) {
        pdfDoc = pdf;
        document.getElementById( 'totalPages' ).textContent = pdf.numPages;
        hideLoading();
        renderPage( 1 );
        updateNavigationButtons();
    } ).catch( function ( error ) {
        console.error( 'Error loading PDF:', error );
        document.getElementById( 'loadingOverlay' ).innerHTML = `
            <div class="text-center">
                <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 48px;"></i>
                <h5 class="text-danger mb-3">Gagal Memuat PDF</h5>
                <p class="text-muted small">${error.message || 'Terjadi kesalahan saat memuat PDF'}</p>
                <button onclick="retryLoadPDF()" class="btn btn-sm btn-primary mt-2">
                    <i class="fas fa-redo me-1"></i>Coba Lagi
                </button>
            </div>
        `;
    } );
}

function retryLoadPDF() {
    document.getElementById( 'loadingOverlay' ).innerHTML = `
        <div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted small">Memuat ulang PDF...</p>
    `;
    document.getElementById( 'pdf-container' ).innerHTML = '';
    loadPDF();
}

function renderPage( pageNum ) {
    if ( !pdfDoc || isRendering ) return;

    // Validasi nomor halaman
    if ( pageNum < 1 || pageNum > pdfDoc.numPages ) {
        showNotification( '⚠️ Nomor halaman tidak valid' );
        return;
    }

    isRendering = true;
    currentPage = pageNum;

    // Update UI
    document.getElementById( 'currentPage' ).textContent = pageNum;
    document.getElementById( 'pageInput' ).value = pageNum;
    updateNavigationButtons();

    pdfDoc.getPage( pageNum ).then( function ( page ) {
        const container = document.getElementById( 'pdf-container' );

        // Hapus canvas lama dengan fade effect
        const oldCanvas = container.querySelector( 'canvas' );
        if ( oldCanvas ) {
            oldCanvas.style.opacity = '0';
            setTimeout( () => {
                container.innerHTML = '';
                createAndRenderCanvas( page, container );
            }, 150 );
        } else {
            createAndRenderCanvas( page, container );
        }
    } ).catch( function ( error ) {
        isRendering = false;
        console.error( 'Error rendering page:', error );
        showNotification( '⚠️ Gagal memuat halaman' );
    } );
}

function createAndRenderCanvas( page, container ) {
    // Buat canvas baru
    const canvas = document.createElement( 'canvas' );
    canvas.className = 'pdf-page-canvas';
    canvas.style.opacity = '0';
    container.appendChild( canvas );

    // Calculate viewport with rotation
    const viewport = page.getViewport( {
        scale: currentScale,
        rotation: currentRotation
    } );

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const context = canvas.getContext( '2d' );
    const renderContext = {
        canvasContext: context,
        viewport: viewport
    };

    page.render( renderContext ).promise.then( function () {
        // Fade in effect
        canvas.style.transition = 'opacity 0.3s ease';
        canvas.style.opacity = '1';

        isRendering = false;
        showNotification( `📄 Halaman ${currentPage} dari ${pdfDoc.numPages}` );
    } ).catch( function ( error ) {
        isRendering = false;
        console.error( 'Error rendering page:', error );
        showNotification( '⚠️ Gagal memuat halaman' );
    } );
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById( 'prevBtn' );
    const nextBtn = document.getElementById( 'nextBtn' );

    if ( prevBtn ) {
        prevBtn.disabled = currentPage <= 1;
        prevBtn.classList.toggle( 'disabled', currentPage <= 1 );
    }

    if ( nextBtn && pdfDoc ) {
        nextBtn.disabled = currentPage >= pdfDoc.numPages;
        nextBtn.classList.toggle( 'disabled', currentPage >= pdfDoc.numPages );
    }
}

// Navigation functions
function prevPage() {
    if ( isRendering ) {
        showNotification( '⏳ Tunggu halaman selesai dimuat' );
        return;
    }

    if ( currentPage > 1 ) {
        renderPage( currentPage - 1 );
    } else {
        showNotification( '📄 Anda di halaman pertama' );
    }
}

function nextPage() {
    if ( isRendering ) {
        showNotification( '⏳ Tunggu halaman selesai dimuat' );
        return;
    }

    if ( pdfDoc && currentPage < pdfDoc.numPages ) {
        renderPage( currentPage + 1 );
    } else {
        showNotification( '📄 Anda di halaman terakhir' );
    }
}

function goToPage( pageNum ) {
    if ( isRendering ) {
        showNotification( '⏳ Tunggu halaman selesai dimuat' );
        return;
    }

    if ( pdfDoc && pageNum >= 1 && pageNum <= pdfDoc.numPages ) {
        renderPage( pageNum );
    } else {
        showNotification( '⚠️ Nomor halaman tidak valid' );
    }
}

function goToInputPage() {
    const input = document.getElementById( 'pageInput' );
    const pageNum = parseInt( input.value );

    if ( isNaN( pageNum ) ) {
        showNotification( '⚠️ Masukkan nomor halaman yang valid' );
        input.value = currentPage;
        return;
    }

    if ( pdfDoc && pageNum >= 1 && pageNum <= pdfDoc.numPages ) {
        renderPage( pageNum );
    } else {
        showNotification( `⚠️ Halaman harus antara 1-${pdfDoc ? pdfDoc.numPages : '?'}` );
        input.value = currentPage;
    }
}

// Rotate functions
function rotateLeft() {
    if ( isRendering ) {
        showNotification( '⏳ Tunggu halaman selesai dimuat' );
        return;
    }

    currentRotation -= 90;
    if ( currentRotation < 0 ) {
        currentRotation = 270;
    }
    renderPage( currentPage );
    showNotification( `🔄 Rotasi: ${currentRotation}°` );
}

function rotateRight() {
    if ( isRendering ) {
        showNotification( '⏳ Tunggu halaman selesai dimuat' );
        return;
    }

    currentRotation += 90;
    if ( currentRotation >= 360 ) {
        currentRotation = 0;
    }
    renderPage( currentPage );
    showNotification( `🔄 Rotasi: ${currentRotation}°` );
}

// Fullscreen function
function toggleFullscreen() {
    isFullscreen = !isFullscreen;
    const body = document.body;
    const icon = document.getElementById( 'fullscreenIcon' );

    if ( isFullscreen ) {
        body.classList.add( 'fullscreen-mode' );
        icon.className = 'fas fa-compress';
        showNotification( '📺 Mode Fullscreen Aktif' );

        // Request native fullscreen on mobile
        if ( document.documentElement.requestFullscreen ) {
            document.documentElement.requestFullscreen().catch( err => {
                console.log( 'Fullscreen not supported:', err );
            } );
        }
    } else {
        body.classList.remove( 'fullscreen-mode' );
        icon.className = 'fas fa-expand';
        showNotification( '📱 Mode Normal' );

        // Exit native fullscreen
        if ( document.exitFullscreen ) {
            document.exitFullscreen().catch( err => {
                console.log( 'Exit fullscreen error:', err );
            } );
        }
    }

    // Re-render to adjust canvas size
    setTimeout( () => {
        if ( pdfDoc && !isRendering ) {
            renderPage( currentPage );
        }
    }, 300 );
}

// Listen for native fullscreen changes
document.addEventListener( 'fullscreenchange', function () {
    if ( !document.fullscreenElement && isFullscreen ) {
        // User exited fullscreen via ESC or browser button
        isFullscreen = false;
        document.body.classList.remove( 'fullscreen-mode' );
        document.getElementById( 'fullscreenIcon' ).className = 'fas fa-expand';
    }
} );

// Utility functions
function hideLoading() {
    const overlay = document.getElementById( 'loadingOverlay' );
    if ( overlay ) {
        overlay.style.display = 'none';
    }
}

function showNotification( message ) {
    const existing = document.querySelector( '.mobile-notification' );
    if ( existing ) existing.remove();

    const notification = document.createElement( 'div' );
    notification.className = 'mobile-notification';
    notification.innerHTML = message;
    document.body.appendChild( notification );

    setTimeout( () => notification.remove(), 2000 );
}

function showHelp() {
    alert( `📱 NAVIGASI PDF:
• Tombol Sebelumnya/Selanjutnya untuk berpindah halaman
• Rotate untuk memutar dokumen (90°, 180°, 270°)
• Fullscreen untuk tampilan layar penuh
• Keyboard: Arrow keys, PageUp/Down, Home/End

🔒 KEAMANAN AKTIF:
• Klik kanan diblokir
• Copy/Print diblokir
• Developer tools diblokir

✨ FITUR BARU:
• Rotasi dokumen 360°
• Mode fullscreen untuk mobile & PC
• Transisi halaman yang smooth
• Kontrol intuitif dengan touch support`);
}

// Security setup
function setupSecurity() {
    // Disable Right Click
    document.addEventListener( 'contextmenu', function ( e ) {
        e.preventDefault();
        showNotification( '🔒 Klik kanan diblokir' );
    } );

    // Disable Shortcuts
    document.addEventListener( 'keydown', function ( e ) {
        // F12
        if ( e.key === "F12" ) {
            e.preventDefault();
            showNotification( '🔒 Developer tools diblokir' );
            return false;
        }

        // Ctrl+U, Ctrl+S, Ctrl+P, Ctrl+C, Ctrl+A
        if ( e.ctrlKey && ['u', 's', 'p', 'c', 'a'].includes( e.key.toLowerCase() ) ) {
            e.preventDefault();
            showNotification( '🔒 Fitur diblokir' );
            return false;
        }

        // Ctrl+Shift+I / Ctrl+Shift+J (Developer Tools)
        if ( e.ctrlKey && e.shiftKey && ['i', 'j'].includes( e.key.toLowerCase() ) ) {
            e.preventDefault();
            showNotification( '🔒 Developer tools diblokir' );
            return false;
        }

        // Arrow keys for navigation
        if ( e.key === 'ArrowUp' || e.key === 'ArrowLeft' ) {
            prevPage();
            e.preventDefault();
        }
        if ( e.key === 'ArrowDown' || e.key === 'ArrowRight' ) {
            nextPage();
            e.preventDefault();
        }

        // Page Up / Page Down
        if ( e.key === 'PageUp' ) {
            prevPage();
            e.preventDefault();
        }
        if ( e.key === 'PageDown' ) {
            nextPage();
            e.preventDefault();
        }

        // Home / End
        if ( e.key === 'Home' ) {
            goToPage( 1 );
            e.preventDefault();
        }
        if ( e.key === 'End' && pdfDoc ) {
            goToPage( pdfDoc.numPages );
            e.preventDefault();
        }

        // F11 or F for Fullscreen
        if ( e.key === 'f' || e.key === 'F' || e.key === 'F11' ) {
            if ( e.key === 'F11' ) {
                e.preventDefault();
            }
            toggleFullscreen();
        }

        // R for Rotate
        if ( e.key === 'r' || e.key === 'R' ) {
            rotateRight();
            e.preventDefault();
        }

    } );

    // Prevent drag
    document.addEventListener( 'dragstart', function ( e ) {
        e.preventDefault();
    } );

    // Prevent text selection on canvas
    document.addEventListener( 'selectstart', function ( e ) {
        if ( e.target.tagName === 'CANVAS' ) {
            e.preventDefault();
        }
    } );
}

// Auto-hide loading after timeout (fallback)
setTimeout( function () {
    hideLoading();
}, 10000 );

// Handle window resize
let resizeTimeout;
window.addEventListener( 'resize', function () {
    if ( pdfDoc && !isRendering ) {
        clearTimeout( resizeTimeout );
        resizeTimeout = setTimeout( () => {
            renderPage( currentPage );
        }, 300 );
    }
} );

// Allow input on number field
document.addEventListener( 'DOMContentLoaded', function () {
    const pageInput = document.getElementById( 'pageInput' );
    if ( pageInput ) {
        pageInput.addEventListener( 'keypress', function ( e ) {
            if ( e.key === 'Enter' ) {
                goToInputPage();
            }
        } );
    }
} );