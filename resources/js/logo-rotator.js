document.addEventListener('DOMContentLoaded', () => {
    // 1. Inject CSS for the 3D rotation transition dynamically
    const style = document.createElement('style');
    style.textContent = `
        .dynamic-logo {
            animation: none !important;
            transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1) !important;
            transform: perspective(600px) rotateY(0deg) scale(1) !important;
            transform-style: preserve-3d !important;
            backface-visibility: hidden !important;
        }
        .dynamic-logo.flipping {
            transform: perspective(600px) rotateY(90deg) scale(0.85) !important;
        }
    `;
    document.head.appendChild(style);

    // 2. Identify the dynamic logo elements
    const getLogos = () => document.querySelectorAll('.dynamic-logo');
    
    // We wait briefly to search for the logo and resolve its directory path.
    // This allows dynamically rendered logos or elements to be present.
    setTimeout(() => {
        const elements = getLogos();
        if (elements.length === 0) return;

        // Resolve the images base directory path dynamically from the first logo's src
        let imagesBaseUrl = '/images/';
        const firstLogo = elements[0];
        const src = firstLogo.getAttribute('src') || firstLogo.src;
        
        if (src) {
            const lastSlashIndex = src.lastIndexOf('/');
            if (lastSlashIndex !== -1) {
                const basePath = src.substring(0, lastSlashIndex + 1); // e.g. "http://domain.com/images/" or "/images/"
                if (basePath.endsWith('/logos/')) {
                    imagesBaseUrl = basePath.substring(0, basePath.length - 6);
                } else {
                    imagesBaseUrl = basePath;
                }
            }
        }

        const logoUrls = [
            imagesBaseUrl + 'logos/logo1.png?v=3',
            imagesBaseUrl + 'logos/logo2.png?v=3',
            imagesBaseUrl + 'logos/logo3.png?v=3'     
        ];
        let currentLogoIndex = 0;

        // Preload logo images to prevent white flashes or layout jumps on swap
        logoUrls.forEach(url => {
            const img = new Image();
            img.src = url;
        });

        // Periodic rotation interval (every 4.5 seconds)
        setInterval(() => {
            const activeElements = getLogos();
            if (activeElements.length === 0) return;

            currentLogoIndex = (currentLogoIndex + 1) % logoUrls.length;
            const nextSrc = logoUrls[currentLogoIndex];

            // Step A: Trigger rotation to 90 degrees with perspective scale down (profile view)
            activeElements.forEach(el => {
                el.classList.add('flipping');
            });

            // Step B: Once rotated to 90 degrees (after 450ms), swap source and rotate from -90 degrees back to 0
            setTimeout(() => {
                activeElements.forEach(el => {
                    // Update source to next logo
                    el.src = nextSrc;
                    
                    // Temporarily remove transition to snap instantly to -90deg and scale down
                    el.style.setProperty('transition', 'none', 'important');
                    el.style.setProperty('transform', 'perspective(600px) rotateY(-90deg) scale(0.85)', 'important');
                    
                    // Force a browser layout reflow/repaint
                    el.offsetHeight;
                    
                    // Re-apply ease-out transition to return to normal flat view (0deg) and normal scale (1)
                    el.style.setProperty('transition', 'transform 0.45s cubic-bezier(0.4, 0, 0.2, 1)', 'important');
                    el.style.setProperty('transform', 'perspective(600px) rotateY(0deg) scale(1)', 'important');
                    
                    // Remove flipping class
                    el.classList.remove('flipping');
                });

                // Step C: Clear inline override styles once the unfold animation finishes (after 450ms)
                setTimeout(() => {
                    activeElements.forEach(el => {
                        el.style.removeProperty('transition');
                        el.style.removeProperty('transform');
                    });
                }, 450);

            }, 450);

        }, 4500);

    }, 100);
});
