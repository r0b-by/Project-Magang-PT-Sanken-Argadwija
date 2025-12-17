/**
 * Sidebar Dropdown Persistence Script
 * Menjaga dropdown tetap terbuka setelah navigasi
 * 
 * @version 1.0
 * @author DMS System
 */

( function () {
    'use strict';

    // Konfigurasi
    const CONFIG = {
        storageKey: 'dms_active_dropdown',
        lastUrlKey: 'dms_last_url',
        animationDuration: 300
    };

    /**
     * Inisialisasi script setelah DOM ready
     */
    document.addEventListener( 'DOMContentLoaded', function () {
        initDropdownPersistence();
        initChevronAnimation();
        initHoverEffects();
        restoreDropdownState();
        preventDropdownClose();
    } );

    /**
     * Setup event listener untuk menyimpan state dropdown
     */
    function initDropdownPersistence() {
        const dropdownLinks = document.querySelectorAll( '.collapse a.nav-link' );

        dropdownLinks.forEach( link => {
            link.addEventListener( 'click', function ( e ) {
                const collapseParent = this.closest( '.collapse' );

                if ( collapseParent ) {
                    // Simpan ID dropdown yang aktif
                    const dropdownId = collapseParent.id;
                    localStorage.setItem( CONFIG.storageKey, dropdownId );

                    // Simpan URL tujuan
                    const targetUrl = this.href;
                    localStorage.setItem( CONFIG.lastUrlKey, targetUrl );

                    console.log( '✓ Dropdown saved:', dropdownId );
                }
            } );
        } );
    }

    /**
     * Setup animasi chevron untuk dropdown toggle
     */
    function initChevronAnimation() {
        const dropdownToggles = document.querySelectorAll( '[data-bs-toggle="collapse"]' );

        dropdownToggles.forEach( toggle => {
            const chevron = toggle.querySelector( '.fa-chevron-down' );
            const targetId = toggle.getAttribute( 'data-bs-target' );
            const targetElement = document.querySelector( targetId );

            if ( targetElement && chevron ) {
                // Event saat dropdown dibuka
                targetElement.addEventListener( 'show.bs.collapse', function () {
                    chevron.style.transform = 'rotate(180deg)';
                    chevron.style.transition = `transform ${CONFIG.animationDuration}ms ease`;
                } );

                // Event saat dropdown ditutup
                targetElement.addEventListener( 'hide.bs.collapse', function () {
                    chevron.style.transform = 'rotate(0deg)';
                } );

                // Set initial state untuk dropdown yang sudah terbuka
                if ( targetElement.classList.contains( 'show' ) ) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        } );
    }

    /**
     * Setup hover effects untuk menu items
     */
    function initHoverEffects() {
        const navLinks = document.querySelectorAll( '.nav-link:not([data-bs-toggle])' );

        navLinks.forEach( link => {
            // Tambahkan smooth transition
            link.style.transition = 'all 0.2s ease';

            // Hover in
            link.addEventListener( 'mouseenter', function () {
                if ( !this.classList.contains( 'active' ) ) {
                    this.style.backgroundColor = 'rgba(13, 110, 253, 0.05)';
                    this.style.transform = 'translateX(3px)';
                }
            } );

            // Hover out
            link.addEventListener( 'mouseleave', function () {
                if ( !this.classList.contains( 'active' ) ) {
                    this.style.backgroundColor = '';
                    this.style.transform = 'translateX(0)';
                }
            } );
        } );
    }

    /**
     * Restore state dropdown setelah page load
     */
    function restoreDropdownState() {
        const activeDropdownId = localStorage.getItem( CONFIG.storageKey );
        const currentUrl = window.location.href;

        if ( activeDropdownId ) {
            const dropdown = document.getElementById( activeDropdownId );

            if ( dropdown ) {
                // Pastikan dropdown terbuka
                if ( !dropdown.classList.contains( 'show' ) ) {
                    const bsCollapse = new bootstrap.Collapse( dropdown, {
                        toggle: false
                    } );
                    bsCollapse.show();
                }

                // Update aria-expanded pada toggle button
                const toggleButton = document.querySelector( `[data-bs-target="#${activeDropdownId}"]` );
                if ( toggleButton ) {
                    toggleButton.setAttribute( 'aria-expanded', 'true' );

                    // Rotate chevron
                    const chevron = toggleButton.querySelector( '.fa-chevron-down' );
                    if ( chevron ) {
                        chevron.style.transform = 'rotate(180deg)';
                    }
                }

                console.log( '✓ Dropdown restored:', activeDropdownId );
            }
        }
    }

    /**
     * Mencegah dropdown tertutup saat klik di dalam dropdown
     */
    function preventDropdownClose() {
        const collapseElements = document.querySelectorAll( '.collapse' );

        collapseElements.forEach( collapse => {
            // Prevent closing when clicking inside
            collapse.addEventListener( 'click', function ( e ) {
                e.stopPropagation();
            } );
        } );
    }

    /**
     * Clear localStorage saat logout atau navigasi keluar
     */
    window.addEventListener( 'beforeunload', function () {
        const currentPath = window.location.pathname;
        const validPaths = ['dashboard', 'iso00', 'barcode', 'access', 'users', 'activity'];

        // Cek apakah masih di area admin
        const isInAdminArea = validPaths.some( path => currentPath.includes( path ) );

        if ( !isInAdminArea ) {
            localStorage.removeItem( CONFIG.storageKey );
            localStorage.removeItem( CONFIG.lastUrlKey );
            console.log( '✓ Dropdown state cleared' );
        }
    } );

    /**
     * Debug helper - uncomment untuk debugging
     */
    // console.log('Sidebar Dropdown Script Loaded');
    // console.log('Active dropdown:', localStorage.getItem(CONFIG.storageKey));

} )();