import './logo-rotator.js';

/* ================= LANGUE ================= */
function setLang(lang) {
    const frBtn = document.getElementById('fr');
    const arBtn = document.getElementById('ar');

    // Remove active class from both buttons first
    if (frBtn) frBtn.classList.remove('active');
    if (arBtn) arBtn.classList.remove('active');

    if (lang === 'ar') {
        document.documentElement.lang = "ar";
        document.body.style.direction = "rtl";
        document.querySelectorAll('.fr').forEach(el => el.style.display = "none");
        document.querySelectorAll('.ar').forEach(el => el.style.display = "block");
        if (arBtn) arBtn.classList.add('active');
    } else {
        document.documentElement.lang = "fr";
        document.body.style.direction = "ltr";
        document.querySelectorAll('.fr').forEach(el => el.style.display = "block");
        document.querySelectorAll('.ar').forEach(el => el.style.display = "none");
        if (frBtn) frBtn.classList.add('active');
    }

    // Synchronize active link states between languages
    const activeLink = document.querySelector(".menu-link.active");
    if (activeLink) {
        const href = activeLink.getAttribute("href");
        document.querySelectorAll(`.menu-link[href="${href}"]`).forEach(link => {
            link.classList.add("active");
        });
    }
}
window.setLang = setLang;

// Initialize French as default language on page load
document.addEventListener('DOMContentLoaded', function () {
    setLang('fr');
});

/* ================= NAVBAR FIXE AU SCROLL ================= */
window.addEventListener("scroll", function () {
    const header = document.querySelector(".container");
    if (window.scrollY > 60) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

/* ================= MENU HAMBURGER (mobile) ================= */
document.addEventListener("DOMContentLoaded", function () {
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const menu = document.querySelector(".menu");

    if (hamburgerBtn && menu) {
        hamburgerBtn.addEventListener("click", function () {
            hamburgerBtn.classList.toggle("active");
            menu.classList.toggle("active");
        });
    }
});

/* ================= LIEN ACTIF SELON SECTION VISIBLE ================= */
const navLinks = document.querySelectorAll(".menu a");

function setActiveLink(id) {
    navLinks.forEach(link => {
        link.classList.remove("active");
        const href = link.getAttribute("href");
        if (href === "#" + id) {
            link.classList.add("active");
        }
    });
}

function updateActiveSection() {
    const sections = document.querySelectorAll("section");
    const navbar = document.querySelector(".container");
    if (!navbar || sections.length === 0) return;

    const navbarHeight = navbar.offsetHeight;
    const scrollMiddle = window.scrollY + navbarHeight + 10;

    let currentId = "";

    sections.forEach(section => {
        const id = section.getAttribute("id");
        const sectionTop = section.offsetTop;
        const sectionBottom = sectionTop + section.offsetHeight;

        // Account for scroll-margin-top (100px) specifically on the contact section
        const testScroll = (id === "contact") ? (scrollMiddle + 110) : scrollMiddle;

        if (testScroll >= sectionTop && scrollMiddle < sectionBottom) {
            currentId = id;
        }
    });

    if (!currentId) {
        const atBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 10;
        if (atBottom) {
            const allSections = document.querySelectorAll("section");
            currentId = allSections[allSections.length - 1].getAttribute("id");
        }
    }

    if (currentId) setActiveLink(currentId);
}

window.addEventListener("scroll", updateActiveSection);

window.addEventListener("DOMContentLoaded", function () {
    updateActiveSection();

    if (window.scrollY < 50) {
        setActiveLink("accueil");
    }
});

/* ================= CLIC SUR LIEN MENU ================= */
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".menu-link");

    links.forEach(link => {
        link.addEventListener("click", function () {
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            // Ferme le menu mobile après clic
            const menu = document.querySelector(".menu");
            const hamburgerBtn = document.getElementById("hamburgerBtn");
            if (menu && menu.classList.contains("active")) {
                menu.classList.remove("active");
                hamburgerBtn.classList.remove("active");
            }
        });
    });
});

/* ================= BASCULE DE DESCRIPTION DES SERVICES (VOIR PLUS / VOIR MOINS) ================= */
document.addEventListener("DOMContentLoaded", function () {
    const seeMoreButtons = document.querySelectorAll(".see-more-btn");
    
    seeMoreButtons.forEach(button => {
        button.addEventListener("click", function () {
            const descContainer = this.closest(".service-card-desc");
            if (!descContainer) return;
            
            const frText = descContainer.querySelector(".fr.text-content");
            const arText = descContainer.querySelector(".ar.text-content");
            
            const isExpanded = descContainer.classList.toggle("expanded");
            
            if (isExpanded) {
                // Remplacer par le texte complet
                if (frText) frText.textContent = frText.getAttribute("data-full");
                if (arText) arText.textContent = arText.getAttribute("data-full");
                
                // Mettre à jour les libellés des boutons
                const frBtn = this.querySelector(".fr.btn-text");
                const arBtn = this.querySelector(".ar.btn-text");
                if (frBtn) frBtn.textContent = "Voir moins";
                if (arBtn) arBtn.textContent = "عرض أقل";
            } else {
                // Remplacer par le résumé court
                if (frText) frText.textContent = frText.getAttribute("data-short");
                if (arText) arText.textContent = arText.getAttribute("data-short");
                
                // Mettre à jour les libellés des boutons
                const frBtn = this.querySelector(".fr.btn-text");
                const arBtn = this.querySelector(".ar.btn-text");
                if (frBtn) frBtn.textContent = "Voir plus";
                if (arBtn) arBtn.textContent = "عرض المزيد";
            }
        });
    });
});

/* ================= CAROUSEL NAVIGATION & AUTO-SCROLL ================= */
document.addEventListener("DOMContentLoaded", function () {
    const wrappers = document.querySelectorAll("#services .carousel-wrapper");
    
    wrappers.forEach(wrapper => {
        const container = wrapper.querySelector(".marquee-container");
        const track = wrapper.querySelector(".marquee-track");
        const prevBtn = wrapper.querySelector(".carousel-arrow.prev");
        const nextBtn = wrapper.querySelector(".carousel-arrow.next");
        
        if (!container || !track) return;
        
        let setWidth = 0;
        let isPaused = false;
        let isDown = false;
        let isClicked = false;
        let lastX = 0;
        let speed = 1.189; // pixels per frame
        let animationFrameId = null;
        let isVisible = false;
        
        const cardWidth = 300;
        const defaultGap = 30;
        const scrollStep = cardWidth + defaultGap; // 330px
        
        // Calculate the exact repeating set width
        function calculateSetWidth(adjustScroll = false) {
            const copies = 4;
            const gap = parseFloat(window.getComputedStyle(track).gap) || defaultGap;
            const scrollWidth = track.scrollWidth || container.scrollWidth;
            
            if (scrollWidth > 0) {
                setWidth = (scrollWidth + gap) / copies;
            }
            
            if (adjustScroll && setWidth > 0) {
                // Instantly center the scroll position inside the second set [setWidth, setWidth * 2)
                if (container.scrollLeft < setWidth || container.scrollLeft >= setWidth * 2) {
                    container.scrollLeft = setWidth * 1.5;
                }
            }
        }
        
        // Initial calculation
        calculateSetWidth(true);
        
        // Recompute when images load
        const imgs = track.querySelectorAll("img");
        imgs.forEach(img => {
            if (img.complete) {
                calculateSetWidth();
            } else {
                img.addEventListener("load", () => calculateSetWidth());
            }
        });
        
        // Recompute on window load, resize, visibility changes
        window.addEventListener("load", () => calculateSetWidth(true));
        window.addEventListener("resize", () => calculateSetWidth(true));
        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === "visible") {
                calculateSetWidth(true);
            }
        });
        
        // Smooth continuous scrolling function
        function autoScroll() {
            if (isVisible) {
                if (!isPaused && !isDown && !isClicked) {
                    container.scrollLeft += speed;
                    
                    // Infinite LTR Loop Boundary Check
                    if (setWidth > 0) {
                        if (container.scrollLeft >= setWidth * 2) {
                            container.scrollLeft -= setWidth;
                        } else if (container.scrollLeft < setWidth) {
                            container.scrollLeft += setWidth;
                        }
                    }
                }
                animationFrameId = requestAnimationFrame(autoScroll);
            } else {
                animationFrameId = null;
            }
        }
        
        // Use IntersectionObserver to stop loop when not visible
        const visibilityObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                isVisible = entry.isIntersecting;
                if (isVisible) {
                    if (!animationFrameId) {
                        animationFrameId = requestAnimationFrame(autoScroll);
                    }
                } else {
                    if (animationFrameId) {
                        cancelAnimationFrame(animationFrameId);
                        animationFrameId = null;
                    }
                }
            });
        }, { threshold: 0.05 });
        visibilityObserver.observe(container);
        
        // Boundary check on scroll event (handles mobile swiping, trackpad, and general scroll changes)
        container.addEventListener("scroll", () => {
            if (setWidth > 0 && !isDown) {
                // If it goes too far to the right, pull it back by one set width
                if (container.scrollLeft >= setWidth * 2.5) {
                    container.scrollLeft -= setWidth;
                }
                // If it goes too far to the left, push it forward by one set width
                else if (container.scrollLeft < setWidth * 0.5) {
                    container.scrollLeft += setWidth;
                }
            }
        });
        
        // Pause auto-scroll on hover of wrapper
        wrapper.addEventListener("mouseenter", () => {
            isPaused = true;
        });
        wrapper.addEventListener("mouseleave", () => {
            if (!isDown && !isClicked) isPaused = false;
        });
        
        // Stop scrolling permanently when clicking "En savoir plus"
        const cardBtns = track.querySelectorAll(".card-btn");
        cardBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                isClicked = true;
                isPaused = true;
            });
        });
        
        // Reset scroll lock state when navigating back to this page (e.g. via browser back button / bfcache)
        window.addEventListener("pageshow", () => {
            isClicked = false;
            isPaused = false;
        });
        
        // Arrow Navigation Click Handler
        if (prevBtn) {
            prevBtn.addEventListener("click", () => {
                let target = container.scrollLeft - scrollStep;
                // Pre-boundary wrap check to avoid scrolling into blank space
                if (setWidth > 0 && target < setWidth) {
                    container.scrollLeft += setWidth;
                    target += setWidth;
                }
                container.scrollTo({
                    left: target,
                    behavior: "smooth"
                });
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener("click", () => {
                let target = container.scrollLeft + scrollStep;
                // Pre-boundary wrap check to avoid scrolling into blank space
                if (setWidth > 0 && target >= setWidth * 2) {
                    container.scrollLeft -= setWidth;
                    target -= setWidth;
                }
                container.scrollTo({
                    left: target,
                    behavior: "smooth"
                });
            });
        }
        
        // Drag-to-scroll / swipe support on desktop using delta tracking
        container.addEventListener("mousedown", (e) => {
            isDown = true;
            isPaused = true;
            lastX = e.pageX;
            container.style.cursor = "grabbing";
        });
        
        window.addEventListener("mouseup", () => {
            if (isDown) {
                isDown = false;
                container.style.cursor = "grab";
                setTimeout(() => {
                    if (!isClicked) isPaused = false;
                }, 1000);
            }
        });
        
        container.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const deltaX = e.pageX - lastX;
            lastX = e.pageX;
            
            // Adjust scroll position by relative movement delta
            container.scrollLeft -= deltaX * 1.5;
            
            // Instant boundary wrapping during manual drag
            if (setWidth > 0) {
                if (container.scrollLeft >= setWidth * 2.5) {
                    container.scrollLeft -= setWidth;
                } else if (container.scrollLeft < setWidth * 0.5) {
                    container.scrollLeft += setWidth;
                }
            }
        });
        
        // Touch events for mobile to pause auto-scroll during swipe
        container.addEventListener("touchstart", () => {
            isPaused = true;
        }, { passive: true });
        
        container.addEventListener("touchend", () => {
            setTimeout(() => {
                if (!isClicked) isPaused = false;
            }, 1500);
        }, { passive: true });
    });
});

/* ================= ANIMATION AU SCROLL (FADE-UP) ================= */
document.addEventListener("DOMContentLoaded", function () {
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.05
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animateElements = document.querySelectorAll(
        "#apropos .about-section-title, #apropos .about-block, #apropos .about-right-col"
    );
    animateElements.forEach((el, index) => {
        el.classList.add("fade-up-scroll");
        el.style.setProperty("--delay", (index * 0.03) + "s");
        observer.observe(el);
    });

    /* ================= ESPACES CAROUSEL ================= */
    initEspacesCarousel();

    /* ================= DYNAMIC DIAGNO GALLERY ================= */
    initDiagnoNewGallery();
});

/* ================= ESPACES CAROUSEL ================= */
function initEspacesCarousel() {
    const espacesSection = document.querySelector('.sm-espaces');
    if (!espacesSection) return;

    const wrapper = espacesSection.querySelector('.carousel-wrapper');
    if (!wrapper) return;

    const container = wrapper.querySelector('.marquee-container');
    const track = wrapper.querySelector('.marquee-track.sm-espaces-track');
    const prevBtn = wrapper.querySelector('.carousel-arrow.prev');
    const nextBtn = wrapper.querySelector('.carousel-arrow.next');

    if (!container || !track) return;

    let setWidth = 0;
    let isPaused = false;
    let isDown = false;
    let lastX = 0;
    let speed = 1.189; // pixels per frame
    let animationFrameId = null;
    let isVisible = false;

    const cardWidth = 340;
    const defaultGap = 30;
    const scrollStep = cardWidth + defaultGap;

    // Calculate the exact repeating set width
    function calculateSetWidth(adjustScroll = false) {
        const gap = parseFloat(window.getComputedStyle(track).gap) || defaultGap;
        const scrollWidth = track.scrollWidth || container.scrollWidth;
        const numCards = track.children.length / 4; // since we have 4 copies
        if (numCards > 0 && scrollWidth > 0) {
            setWidth = (scrollWidth + gap) / 4;
        }

        if (adjustScroll && setWidth > 0) {
            if (container.scrollLeft < setWidth || container.scrollLeft >= setWidth * 2) {
                container.scrollLeft = setWidth * 1.5;
            }
        }
    }

    // Initial calculation
    calculateSetWidth(true);

    // Recompute when images load
    const imgs = track.querySelectorAll('img');
    imgs.forEach(img => {
        if (img.complete) {
            calculateSetWidth();
        } else {
            img.addEventListener('load', () => calculateSetWidth());
        }
    });

    // Recompute on window load, resize, visibility changes
    window.addEventListener('load', () => calculateSetWidth(true));
    window.addEventListener('resize', () => calculateSetWidth(true));
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === "visible") {
            calculateSetWidth(true);
        }
    });

    // Smooth continuous scrolling function
    function autoScroll() {
        if (isVisible) {
            if (!isPaused && !isDown) {
                container.scrollLeft += speed;

                // Infinite LTR Loop Boundary Check
                if (setWidth > 0) {
                    if (container.scrollLeft >= setWidth * 2) {
                        container.scrollLeft -= setWidth;
                    } else if (container.scrollLeft < setWidth) {
                        container.scrollLeft += setWidth;
                    }
                }
            }
            animationFrameId = requestAnimationFrame(autoScroll);
        } else {
            animationFrameId = null;
        }
    }

    // Use IntersectionObserver to stop loop when not visible
    const visibilityObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            isVisible = entry.isIntersecting;
            if (isVisible) {
                if (!animationFrameId) {
                    animationFrameId = requestAnimationFrame(autoScroll);
                }
            } else {
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                    animationFrameId = null;
                }
            }
        });
    }, { threshold: 0.05 });
    visibilityObserver.observe(container);

    // Boundary check on scroll event (handles mobile swiping, trackpad, etc.)
    container.addEventListener('scroll', () => {
        if (setWidth > 0 && !isDown) {
            if (container.scrollLeft >= setWidth * 2.5) {
                container.scrollLeft -= setWidth;
            } else if (container.scrollLeft < setWidth * 0.5) {
                container.scrollLeft += setWidth;
            }
        }
    });

    // Pause auto-scroll on hover of wrapper
    wrapper.addEventListener('mouseenter', () => isPaused = true);
    wrapper.addEventListener('mouseleave', () => {
        if (!isDown) isPaused = false;
    });

    // Arrow Navigation Click Handler
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            let target = container.scrollLeft - scrollStep;
            if (setWidth > 0 && target < setWidth) {
                container.scrollLeft += setWidth;
                target += setWidth;
            }
            container.scrollTo({
                left: target,
                behavior: "smooth"
            });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            let target = container.scrollLeft + scrollStep;
            if (setWidth > 0 && target >= setWidth * 2) {
                container.scrollLeft -= setWidth;
                target -= setWidth;
            }
            container.scrollTo({
                left: target,
                behavior: "smooth"
            });
        });
    }

    // Drag-to-scroll
    container.addEventListener('mousedown', (e) => {
        isDown = true;
        isPaused = true;
        lastX = e.pageX;
        container.style.cursor = "grabbing";
    });

    window.addEventListener('mouseup', () => {
        if (isDown) {
            isDown = false;
            container.style.cursor = "grab";
            setTimeout(() => {
                isPaused = false;
            }, 1000);
        }
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const deltaX = e.pageX - lastX;
        lastX = e.pageX;

        container.scrollLeft -= deltaX * 1.5;

        if (setWidth > 0) {
            if (container.scrollLeft >= setWidth * 2.5) {
                container.scrollLeft -= setWidth;
            } else if (container.scrollLeft < setWidth * 0.5) {
                container.scrollLeft += setWidth;
            }
        }
    });

    // Touch events
    container.addEventListener('touchstart', () => isPaused = true, { passive: true });
    container.addEventListener('touchend', () => {
        setTimeout(() => {
            isPaused = false;
        }, 1500);
    }, { passive: true });
}

/* ================= DYNAMIC DIAGNO GALLERY ================= */
function initDiagnoNewGallery() {
    const galleryContainer = document.querySelector('.sm-new-layout-container');
    if (!galleryContainer) return;

    const dataAttr = galleryContainer.getAttribute('data-diagno-images');
    if (!dataAttr) return;

    let images = [];
    try {
        images = JSON.parse(dataAttr);
    } catch (e) {
        console.error("Failed to parse diagno images", e);
        return;
    }

    if (images.length === 0) return;

    // Dynamically query all 9 slots
    const slots = [];
    const slotContainers = [];
    for (let i = 1; i <= 9; i++) {
        const img = document.querySelector(`#diagno-slot-${i} img`);
        const container = document.querySelector(`#diagno-slot-${i}`);
        if (img && container) {
            slots.push(img);
            slotContainers.push(container);
        }
    }

    if (slots.length === 0) return;

    // Initialize first 9 images
    slots.forEach((img, index) => {
        if (img && images[index]) {
            img.src = images[index];
        }
    });

    let nextImgIndex = slots.length % images.length;
    let nextSlotIndex = 0;

    // Cycle one slot at a time with a smooth 3D card flip
    setInterval(() => {
        const currentSlot = slots[nextSlotIndex];
        const currentContainer = slotContainers[nextSlotIndex];
        if (!currentSlot || !currentContainer) return;

        // Step 1: Flip card to 90deg
        currentContainer.classList.add('swapping');

        // Step 2: Swap src after half rotation (250ms)
        setTimeout(() => {
            currentSlot.src = images[nextImgIndex];
            nextImgIndex = (nextImgIndex + 1) % images.length;

            currentSlot.onload = () => {
                currentContainer.classList.remove('swapping');
            };

            // Safety timeout fallback
            setTimeout(() => {
                currentContainer.classList.remove('swapping');
            }, 100);

        }, 250);

        // Move to the next slot (staggered rotation)
        nextSlotIndex = (nextSlotIndex + 1) % slots.length;

    }, 3000);
}

/* ================= LIGHTBOX GALLERY FOR CLINICAL FOLLOW-UP ================= */
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("smLightboxModal");
    const modalImg = document.getElementById("smLightboxImg");
    const downloadBtn = document.getElementById("smLightboxDownload");
    const closeBtn = document.getElementById("smLightboxClose");
    
    if (!modal || !modalImg || !downloadBtn || !closeBtn) return;
    
    function openLightbox(src) {
        modalImg.src = src;
        downloadBtn.href = src;
        // set filename for download using last part of url
        const filename = src.substring(src.lastIndexOf('/') + 1);
        downloadBtn.setAttribute("download", filename);
        modal.classList.add("active");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden"; // disable background scrolling
    }
    
    function closeLightbox() {
        modal.classList.remove("active");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = ""; // enable background scrolling
        // Clear src after fade-out transition to avoid showing old image next time
        setTimeout(() => {
            modalImg.src = "";
        }, 300);
    }
    
    // Add click listeners to diagnostic matrix slots (delegated for dynamic flip swap support)
    const galleryCol = document.querySelector(".sm-new-gallery-col");
    if (galleryCol) {
        galleryCol.addEventListener("click", function (e) {
            const img = e.target.closest("img");
            if (img && img.src) {
                openLightbox(img.src);
            }
        });
    }
    
    // Add click listeners to therapeutic spaces spaces carousel
    const spacesTrack = document.querySelector(".sm-espaces-track");
    if (spacesTrack) {
        spacesTrack.addEventListener("click", function (e) {
            const img = e.target.closest("img");
            if (img && img.src) {
                openLightbox(img.src);
            }
        });
    }
    
    // Close modal on close button click
    closeBtn.addEventListener("click", closeLightbox);
    
    // Close modal on clicking outside the content area
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeLightbox();
        }
    });
    
    // Close modal on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            closeLightbox();
        }
    });
});

