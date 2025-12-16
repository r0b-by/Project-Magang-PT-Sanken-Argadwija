// ============================================
// GLOBAL VARIABLES
// ============================================
let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let pageRendering = false;
let pageNumPending = null;
let scale = 1.5;

// PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

// Elements
const pdfViewer = document.getElementById('pdfViewer');
const loadingOverlay = document.getElementById('loadingOverlay');
const currentPageNum = document.getElementById('currentPageNum');
const totalPageNum = document.getElementById('totalPageNum');
const pageIndicator = document.getElementById('pageIndicator');

// Buttons
const btnPrevPage = document.getElementById('btnPrevPage');
const btnNextPage = document.getElementById('btnNextPage');
const btnFirstPage = document.getElementById('btnFirstPage');
const btnHelp = document.getElementById('btnHelp');

// ============================================
// LOAD PDF
// ============================================
const pdfUrl = 'https://raw.githubusercontent.com/mozilla/pdf.js/master/examples/learning/helloworld.pdf';

pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
    console.log('PDF loaded successfully');
    pdfDoc = pdf;
    totalPages = pdf.numPages;
    totalPageNum.textContent = totalPages;
    
    // Render all pages
    renderAllPages();
    
    // Hide loading
    loadingOverlay.classList.add('hidden');
    
    showNotification('✅ PDF berhasil dimuat - ' + totalPages + ' halaman');
}).catch(function(error) {
    console.error('Error loading PDF:', error);
    loadingOverlay.innerHTML = '<p class="text-danger">Error memuat PDF</p>';
    showNotification('❌ Gagal memuat PDF');
});

// ============================================
// RENDER ALL PAGES
// ============================================
function renderAllPages() {
    pdfViewer.innerHTML = ''; // Clear viewer
    
    for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
        renderPage(pageNum);
    }
    
    // Setup scroll listener
    setupScrollListener();
}

// ============================================
// RENDER SINGLE PAGE
// ============================================
function renderPage(pageNum) {
    pdfDoc.getPage(pageNum).then(function(page) {
        console.log('Rendering page ' + pageNum);
        
        // Calculate scale for mobile
        const viewport = page.getViewport({ scale: 1 });
        const container = pdfViewer;
        const containerWidth = container.clientWidth - 20; // 20px for margins
        const calculatedScale = containerWidth / viewport.width;
        scale = Math.min(calculatedScale, 2); // Max scale 2
        
        const scaledViewport = page.getViewport({ scale: scale });
        
        // Create canvas
        const canvas = document.createElement('canvas');
        canvas.className = 'pdf-page-canvas';
        canvas.id = 'page-' + pageNum;
        canvas.dataset.pageNum = pageNum;
        
        const context = canvas.getContext('2d');
        canvas.height = scaledViewport.height;
        canvas.width = scaledViewport.width;
        
        pdfViewer.appendChild(canvas);
        
        // Render page
        const renderContext = {
            canvasContext: context,
            viewport: scaledViewport
        };
        
        page.render(renderContext).promise.then(function() {
            console.log('Page ' + pageNum + ' rendered');
        });
    });
}

// ============================================
// SCROLL LISTENER
// ============================================
function setupScrollListener() {
    let scrollTimeout;
    
    pdfViewer.addEventListener('scroll', function() {
        // Show page indicator
        pageIndicator.style.opacity = '1';
        
        // Update current page based on scroll position
        updateCurrentPage();
        
        // Hide indicator after scrolling stops
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            pageIndicator.style.opacity = '0';
        }, 1500);
    });
}

// ============================================
// UPDATE CURRENT PAGE
// ============================================
function updateCurrentPage() {
    const canvases = pdfViewer.querySelectorAll('.pdf-page-canvas');
    const viewerRect = pdfViewer.getBoundingClientRect();
    const viewerMiddle = viewerRect.top + viewerRect.height / 2;
    
    let closestPage = 1;
    let closestDistance = Infinity;
    
    canvases.forEach(function(canvas) {
        const rect = canvas.getBoundingClientRect();
        const canvasMiddle = rect.top + rect.height / 2;
        const distance = Math.abs(viewerMiddle - canvasMiddle);
        
        if (distance < closestDistance) {
            closestDistance = distance;
            closestPage = parseInt(canvas.dataset.pageNum);
        }
    });
    
    currentPage = closestPage;
    currentPageNum.textContent = currentPage;
}

// ============================================
// SCROLL TO PAGE
// ============================================
function scrollToPage(pageNum) {
    if (pageNum < 1 || pageNum > totalPages) {
        console.log('Invalid page number:', pageNum);
        return;
    }
    
    const targetCanvas = document.getElementById('page-' + pageNum);
    if (!targetCanvas) {
        console.log('Canvas not found for page:', pageNum);
        return;
    }
    
    console.log('Scrolling to page:', pageNum);
    
    // Calculate scroll position
    const canvasRect = targetCanvas.getBoundingClientRect();
    const viewerRect = pdfViewer.getBoundingClientRect();
    const scrollTop = pdfViewer.scrollTop;
    const targetScroll = scrollTop + canvasRect.top - viewerRect.top - 10;
    
    // Smooth scroll
    pdfViewer.scrollTo({
        top: targetScroll,
        behavior: 'smooth'
    });
    
    // Update current page
    currentPage = pageNum;
    currentPageNum.textContent = currentPage;
    
    // Show indicator
    pageIndicator.style.opacity = '1';
    setTimeout(function() {
        pageIndicator.style.opacity = '0';
    }, 2000);
    
    console.log('Scrolled to page:', pageNum);
}

// ============================================
// BUTTON EVENTS
// ============================================
btnPrevPage.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Previous page clicked. Current:', currentPage);
    
    if (currentPage > 1) {
        const prevPage = currentPage - 1;
        scrollToPage(prevPage);
        showNotification('⬆️ Halaman ' + prevPage);
    } else {
        showNotification('⚠️ Sudah di halaman pertama');
    }
});

btnNextPage.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Next page clicked. Current:', currentPage);
    
    if (currentPage < totalPages) {
        const nextPage = currentPage + 1;
        scrollToPage(nextPage);
        showNotification('⬇️ Halaman ' + nextPage);
    } else {
        showNotification('⚠️ Sudah di halaman terakhir');
    }
});

btnFirstPage.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('First page clicked');
    scrollToPage(1);
    showNotification('🏠 Kembali ke halaman 1');
});

btnHelp.addEventListener('click', function(e) {
    e.preventDefault();
    showHelp();
});

// ============================================
// SCROLL BY AMOUNT (Alternative method)
// ============================================
function scrollByAmount(direction) {
    const scrollAmount = pdfViewer.clientHeight * 0.8;
    pdfViewer.scrollBy({
        top: direction === 'up' ? -scrollAmount : scrollAmount,
        behavior: 'smooth'
    });
}

// Add alternative scroll method
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowUp' || e.key === 'PageUp') {
        e.preventDefault();
        scrollByAmount('up');
    } else if (e.key === 'ArrowDown' || e.key === 'PageDown') {
        e.preventDefault();
        scrollByAmount('down');
    } else if (e.key === 'Home') {
        e.preventDefault();
        scrollToPage(1);
    }
});

// ============================================
// HELP FUNCTION
// ============================================
function showHelp() {
    const helpText = `PANDUAN PENGGUNAAN PDF:

📱 CARA NAVIGASI:
• Scroll langsung pada area PDF
• Tombol "Atas" - ke halaman sebelumnya
• Tombol "Bawah" - ke halaman berikutnya
• Tombol "Awal" - kembali ke halaman 1
• Keyboard: ↑↓ atau PageUp/PageDown

📄 INFORMASI:
• Total halaman: ${totalPages}
• Halaman saat ini: ${currentPage}
• Indikator halaman muncul otomatis

🔒 KEAMANAN:
• Klik kanan dinonaktifkan
• Copy/paste diblokir
• Print diblokir (Ctrl+P)
• Semua proteksi aktif

💡 TIPS:
• Scroll natural seperti biasa
• Gunakan tombol untuk navigasi cepat
• Indikator halaman hilang otomatis`;
    
    alert(helpText);
}

// ============================================
// NOTIFICATION FUNCTION
// ============================================
function showNotification(message) {
    // Remove existing notification
    const existing = document.querySelector('.mobile-notification');
    if (existing) existing.remove();
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'mobile-notification';
    notification.innerHTML = message;
    
    document.body.appendChild(notification);
    
    // Auto remove after 2 seconds
    setTimeout(function() {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 2000);
}

// ============================================
// SECURITY FEATURES
// ============================================

// Prevent context menu
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    showNotification('🔒 Klik kanan dinonaktifkan');
    return false;
}, false);

// Prevent keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Block F12, Ctrl+P, Ctrl+C, Ctrl+S, Ctrl+U
    if (e.key === "F12" || 
        (e.ctrlKey && ['p', 'c', 's', 'u'].includes(e.key.toLowerCase()))) {
        e.preventDefault();
        showNotification('🔒 Fitur dinonaktifkan');
        return false;
    }
});

// Prevent text selection via double click
document.addEventListener('dblclick', function(e) {
    e.preventDefault();
    return false;
});

// Prevent drag
pdfViewer.addEventListener('dragstart', function(e) {
    e.preventDefault();
    return false;
});

// ============================================
// RESIZE HANDLER
// ============================================
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        console.log('Window resized, re-rendering pages');
        if (pdfDoc) {
            const currentScroll = pdfViewer.scrollTop;
            renderAllPages();
            setTimeout(function() {
                pdfViewer.scrollTop = currentScroll;
            }, 100);
        }
    }, 500);
});

// ============================================
// ORIENTATION CHANGE
// ============================================
window.addEventListener('orientationchange', function() {
    setTimeout(function() {
        if (pdfDoc) {
            const savedPage = currentPage;
            renderAllPages();
            setTimeout(function() {
                scrollToPage(savedPage);
            }, 500);
        }
    }, 500);
});

// ============================================
// INITIAL SETUP
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded');
    
    // Hide page indicator initially
    pageIndicator.style.opacity = '0';
    pageIndicator.style.transition = 'opacity 0.3s';
    
    // Detect touch device
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    if (isTouchDevice) {
        document.body.classList.add('touch-device');
        console.log('Touch device detected');
    }
});

console.log('PDF Viewer initialized');
console.log('PDF.js version:', pdfjsLib.version);