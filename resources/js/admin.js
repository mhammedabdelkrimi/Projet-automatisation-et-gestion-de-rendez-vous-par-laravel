import './logo-rotator.js';

// Admin Dashboard Client Scripts

document.addEventListener('DOMContentLoaded', function () {
    // Show current date
    updateHeaderDate();

    // Restore last active tab if present, else default to 'overview'
    const lastTab = localStorage.getItem('activeAdminTab') || 'overview';
    switchTab(lastTab);

    // Sidebar tab triggers
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });

    // Default: Filter services grid to show phase 1 on startup
    filterServicesPhase(1);

    // Filter services on details pages tab
    const pagesSearchInput = document.getElementById('pagesServicesSearchInput');
    const pagesTableBody = document.getElementById('pagesServicesTableBody');
    if (pagesSearchInput && pagesTableBody) {
        pagesSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = pagesTableBody.querySelectorAll('.page-service-row');
            rows.forEach(row => {
                const nameFr = row.getAttribute('data-name-fr') || '';
                const nameAr = row.getAttribute('data-name-ar') || '';
                if (nameFr.includes(query) || nameAr.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // AJAX upload handler for editing service image on file select
    const editImageInput = document.getElementById('edit_image');
    if (editImageInput) {
        editImageInput.addEventListener('change', function() {
            const serviceId = this.getAttribute('data-service-id');
            if (!serviceId) return;

            const file = this.files[0];
            if (!file) return;

            // Form data
            const formData = new FormData();
            formData.append('image', file);

            // Fetch CSRF Token
            const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

            // Update UI to loading state
            const previewImg = document.getElementById('edit_service_img_preview');
            const saveBtn = document.querySelector('#editServiceForm button[type="submit"]');
            if (saveBtn) saveBtn.disabled = true;

            fetch(`/admin/services/${serviceId}/image`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (saveBtn) saveBtn.disabled = false;

                if (data.success) {
                    // Update client cache for updated service images
                    window.updatedServiceImages = window.updatedServiceImages || {};
                    window.updatedServiceImages[serviceId] = data.filename;

                    // Refresh modal preview with cache busting URL
                    if (previewImg) {
                        previewImg.src = data.url;
                    }

                    // Update the image on the dashboard service card in real-time
                    const card = document.querySelector(`.service-card-item[data-service-id="${serviceId}"]`);
                    if (card) {
                        const cardImg = card.querySelector('.service-card-img-wrapper img');
                        if (cardImg) cardImg.src = data.url;
                    }

                    alert(data.message || 'Image mise à jour avec succès.');
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour de l\'image.');
                    editImageInput.value = ''; // Clear file input
                }
            })
            .catch(error => {
                if (saveBtn) saveBtn.disabled = false;
                console.error('Error:', error);
                alert('Une erreur réseau s\'est produite. Veuillez réessayer.');
                editImageInput.value = ''; // Clear file input
            });
        });
    }

    // Event delegation for history preview and download actions
    document.addEventListener('click', function(e) {
        const btnDownload = e.target.closest('.btn-action-download');
        const btnPreview = e.target.closest('.btn-action-preview');
        
        if (btnDownload) {
            e.preventDefault();
            generateBilanPDFFromHistory(btnDownload, 'download');
        } else if (btnPreview) {
            e.preventDefault();
            generateBilanPDFFromHistory(btnPreview, 'open');
        }
    });

    // Real-time checking for new appointments
    let lastAppointmentId = 0;
    
    // Find initial max ID from DOM
    document.querySelectorAll('.appointment-row').forEach(row => {
        const id = parseInt(row.getAttribute('data-id'));
        if (id && id > lastAppointmentId) {
            lastAppointmentId = id;
        }
    });

    if (document.getElementById('appointmentsTable')) {
        // Poll every 15 seconds
        setInterval(checkNewAppointments, 15000);
    }

    function checkNewAppointments() {
        fetch(`/admin/appointments/check?last_id=${lastAppointmentId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.has_new && data.html) {
                lastAppointmentId = data.max_id;

                const tbody = document.getElementById('appointmentsTableBody');
                if (tbody) {
                    // Remove empty row indicator if present
                    const emptyRow = tbody.querySelector('tr td.text-center');
                    if (emptyRow && emptyRow.parentNode) {
                        emptyRow.parentNode.remove();
                    }

                    // Keep track of existing row IDs before prepending
                    const existingIds = Array.from(tbody.querySelectorAll('.appointment-row')).map(r => r.getAttribute('data-id'));

                    // Prepend new rows directly to preserve table structure
                    tbody.insertAdjacentHTML('afterbegin', data.html);

                    // Add highlight animation only to the newly added rows
                    tbody.querySelectorAll('.appointment-row').forEach(row => {
                        const id = row.getAttribute('data-id');
                        if (!existingIds.includes(id)) {
                            row.classList.add('new-appointment-row');
                        }
                    });

                    // Prepend to overview 24h table if it exists
                    const recentTbody = document.getElementById('recent24hTableBody');
                    if (recentTbody && data.recent_24h_html) {
                        recentTbody.insertAdjacentHTML('afterbegin', data.recent_24h_html);

                        // Ensure the recent 24h section container is visible (in case it was hidden)
                        const recentSection = document.getElementById('recent24hSection');
                        if (recentSection) {
                            recentSection.style.display = 'block';
                        }

                        // Hide the fallback "Aucune activité récente" banner if visible
                        const fallbackBanner = document.getElementById('noRecentActivityBanner');
                        if (fallbackBanner) {
                            fallbackBanner.style.display = 'none';
                        }
                    }

                    // Play premium chime sound
                    playNotificationSound();

                    // Show custom toast notification
                    showToast(`Nouveau rendez-vous reçu ! (${data.new_count} nouveau(x))`);

                    // Update stats counters
                    const statsCount = document.getElementById('stats_appointments_count');
                    if (statsCount && data.appointments_count) {
                        statsCount.innerText = data.appointments_count;
                        statsCount.style.transform = 'scale(1.25)';
                        statsCount.style.transition = 'transform 0.25s ease';
                        setTimeout(() => {
                            statsCount.style.transform = 'scale(1)';
                        }, 250);
                    }

                    // Re-apply active search filter if query is typed
                    if (typeof window.filterAppointments === 'function') {
                        window.filterAppointments();
                    }
                }
            }
        })
        .catch(err => console.warn('Error checking appointments:', err));
    }

    function playNotificationSound() {
        try {
            const AudioContextConstructor = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextConstructor) return;
            const ctx = new AudioContextConstructor();
            const now = ctx.currentTime;
            
            // Double-note chime
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(783.99, now); // G5
            gain1.gain.setValueAtTime(0.12, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.25);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start(now);
            osc1.stop(now + 0.25);
            
            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(1046.50, now + 0.1); // C6
            gain2.gain.setValueAtTime(0.18, now + 0.1);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.4);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start(now + 0.1);
            osc2.stop(now + 0.4);
        } catch (e) {
            console.warn('Audio chime blocked by browser policy:', e);
        }
    }

    function showToast(message) {
        if (!document.getElementById('toast-styles')) {
            const style = document.createElement('style');
            style.id = 'toast-styles';
            style.innerHTML = `
                .toast-notification {
                    position: fixed;
                    bottom: 24px;
                    right: 24px;
                    background: #1e293b;
                    color: #ffffff;
                    padding: 14px 18px;
                    border-radius: 10px;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    z-index: 10000;
                    opacity: 0;
                    transform: translateY(15px);
                    transition: opacity 0.3s ease, transform 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    font-weight: 500;
                    font-size: 0.9rem;
                }
                .toast-notification.show {
                    opacity: 1;
                    transform: translateY(0);
                }
                @keyframes rowHighlight {
                    0% { background-color: rgba(20, 184, 166, 0.2); }
                    100% { background-color: transparent; }
                }
                .new-appointment-row {
                    animation: rowHighlight 3s ease-out forwards;
                }
            `;
            document.head.appendChild(style);
        }

        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2" style="width: 18px; height: 18px;">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 50);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4000);
    }
});

// Update the header date in French/Arabic
function updateHeaderDate() {
    const dateEl = document.getElementById('currentDate');
    if (!dateEl) return;

    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateToday = new Date();
    
    // Choose locale based on body class
    const isArabic = document.body.classList.contains('lang-ar');
    const locale = isArabic ? 'ar-MA' : 'fr-FR';

    dateEl.innerText = dateToday.toLocaleDateString(locale, options);
}

// Switch between sidebar tabs
window.switchTab = function (tabId) {
    localStorage.setItem('activeAdminTab', tabId);
    
    // Toggle active pane
    const panes = document.querySelectorAll('.tab-pane');
    panes.forEach(pane => pane.classList.remove('active'));
    
    const activePane = document.getElementById(tabId);
    if (activePane) activePane.classList.add('active');

    // Toggle active sidebar item
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-tab') === tabId) {
            item.classList.add('active');
        }
    });
}

// Language Switch System
window.setLang = function (lang) {
    const frBtns = document.querySelectorAll('.lang-switch button[id^="fr"]');
    const arBtns = document.querySelectorAll('.lang-switch button[id^="ar"]');

    frBtns.forEach(btn => btn.classList.remove('active'));
    arBtns.forEach(btn => btn.classList.remove('active'));

    if (lang === 'ar') {
        document.documentElement.lang = "ar";
        document.body.style.direction = "rtl";
        document.body.classList.remove('lang-fr');
        document.body.classList.add('lang-ar');
        arBtns.forEach(btn => btn.classList.add('active'));
    } else {
        document.documentElement.lang = "fr";
        document.body.style.direction = "ltr";
        document.body.classList.remove('lang-ar');
        document.body.classList.add('lang-fr');
        frBtns.forEach(btn => btn.classList.add('active'));
    }

    // Refresh header date format
    updateHeaderDate();
}

// Live search filter in appointments table
window.filterAppointments = function () {
    const query = document.getElementById('appointmentSearch').value.toLowerCase().trim();
    const rows = document.querySelectorAll('.appointment-row');

    rows.forEach(row => {
        const searchData = row.getAttribute('data-search');
        if (searchData && searchData.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Filter service list by phase (1, 2, or 3)
window.filterServicesPhase = function (phase) {
    const cards = document.querySelectorAll('.service-card-item');
    cards.forEach(card => {
        const cardPhase = parseInt(card.getAttribute('data-phase'));
        if (cardPhase === phase) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });

    // Toggle active sub-tab styling
    const tabs = document.querySelectorAll('.phase-tab');
    tabs.forEach((tab, index) => {
        tab.classList.remove('active');
        if (index + 1 === phase) {
            tab.classList.add('active');
        }
    });
}

// MODAL CONTROLS: ADD SERVICE
window.openAddServiceModal = function () {
    const modal = document.getElementById('addServiceModal');
    if (modal) modal.style.display = 'flex';
}

window.closeAddServiceModal = function () {
    const modal = document.getElementById('addServiceModal');
    if (modal) modal.style.display = 'none';
}

// MODAL CONTROLS: EDIT SERVICE
window.openEditServiceModal = function (service) {
    const modal = document.getElementById('editServiceModal');
    if (!modal) return;

    // Fill the form fields with service data
    document.getElementById('edit_title_fr').value = service.title_fr;
    document.getElementById('edit_title_ar').value = service.title_ar;
    document.getElementById('edit_desc_fr').value = service.desc_fr;
    document.getElementById('edit_desc_ar').value = service.desc_ar;
    document.getElementById('edit_phase').value = service.phase;

    // Set service ID and current image path/filename on file input element
    const fileInput = document.getElementById('edit_image');
    if (fileInput) {
        fileInput.value = ''; // Reset chosen file
        fileInput.setAttribute('data-service-id', service.id);
    }

    // Resolve the active image (using client cache if it has been updated via AJAX)
    const activeImage = (window.updatedServiceImages && window.updatedServiceImages[service.id]) 
        ? window.updatedServiceImages[service.id] 
        : service.image;

    // Load preview image
    const previewImg = document.getElementById('edit_service_img_preview');
    if (previewImg) {
        previewImg.src = `/images/services/${activeImage}`;
    }

    // Update the form action dynamically to post to the update route
    const form = document.getElementById('editServiceForm');
    if (form) {
        form.action = `/admin/services/${service.id}`;
    }

    modal.style.display = 'flex';
}

window.closeEditServiceModal = function () {
    const modal = document.getElementById('editServiceModal');
    if (modal) modal.style.display = 'none';
}

// DYNAMIC BLOCKS SYSTEM FOR SERVICE PAGE
let blockCounter = 0;
window.addNewBlockRow = function (blockData = {}) {
    const container = document.getElementById('blocks_container');
    if (!container) return;

    const idx = blockCounter++;
    const row = document.createElement('div');
    row.className = 'block-row';
    row.id = `block_row_${idx}`;
    row.style.border = '1px solid var(--border-color)';
    row.style.borderRadius = '8px';
    row.style.padding = '15px';
    row.style.background = '#f8f9fa';
    row.style.position = 'relative';

    row.innerHTML = `
        <button type="button" onclick="removeBlockRow(${idx})" style="position: absolute; top: 10px; right: 10px; background: #e53e3e; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; line-height: 1; z-index: 10;">&times;</button>
        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 15px;">
            <!-- 1. Titre du bloc (petit_titre) -->
            <div class="form-group">
                <label>Titre de Section (Français)</label>
                <input type="text" name="blocks[${idx}][title_fr]" class="form-control" value="${blockData.title_fr || ''}" placeholder="ex: Nos Installations">
            </div>
            <div class="form-group">
                <label>عنوان القسم (العربية)</label>
                <input type="text" name="blocks[${idx}][title_ar]" class="form-control" value="${blockData.title_ar || ''}" placeholder="مثال: منشآتنا" style="direction: rtl;">
            </div>

            <!-- 2. Image du bloc (image) -->
            <div class="form-group full-width">
                <label>Image du Bloc (remplace l'existante si chargée)</label>
                <input type="file" name="blocks_image_${idx}" class="form-control file-input" accept="image/*">
                <input type="hidden" name="blocks[${idx}][existing_image]" value="${blockData.image || ''}">
                <div class="gallery-preview-wrapper" id="block_preview_${idx}">
                    ${blockData.image ? `<div class="gallery-preview-item" style="margin-top: 5px;"><img src="/images/services/details/${blockData.image}" alt="preview" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;"></div>` : ''}
                </div>
            </div>

            <!-- 3. Description (wysiwyg) -->
            <div class="form-group full-width">
                <label>Description du Bloc (Français - Texte Riche)</label>
                <div id="quill_fr_${idx}" style="height: 150px; background: white; color: black; border-radius: 4px;"></div>
                <input type="hidden" name="blocks[${idx}][desc_fr]" id="input_desc_fr_${idx}">
            </div>
            <div class="form-group full-width">
                <label>الوصف (العربية - نص منسق)</label>
                <div id="quill_ar_${idx}" style="height: 150px; background: white; color: black; border-radius: 4px; direction: rtl; text-align: right;"></div>
                <input type="hidden" name="blocks[${idx}][desc_ar]" id="input_desc_ar_${idx}">
            </div>
        </div>
    `;
    container.appendChild(row);

    // Populate inputs
    document.getElementById(`input_desc_fr_${idx}`).value = blockData.desc_fr || '';
    document.getElementById(`input_desc_ar_${idx}`).value = blockData.desc_ar || '';

    // Initialize Quill
    if (typeof Quill !== 'undefined') {
        const quillFr = new Quill(`#quill_fr_${idx}`, {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });
        quillFr.root.innerHTML = blockData.desc_fr || '';
        quillFr.on('text-change', () => {
            document.getElementById(`input_desc_fr_${idx}`).value = quillFr.root.innerHTML;
        });

        const quillAr = new Quill(`#quill_ar_${idx}`, {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });
        quillAr.root.innerHTML = blockData.desc_ar || '';
        
        quillAr.root.setAttribute('dir', 'rtl');
        quillAr.root.style.textAlign = 'right';
        
        quillAr.on('text-change', () => {
            document.getElementById(`input_desc_ar_${idx}`).value = quillAr.root.innerHTML;
        });
    } else {
        // Fallback to text inputs
        const descFrField = document.getElementById(`input_desc_fr_${idx}`);
        descFrField.type = 'text';
        descFrField.className = 'form-control';
        const descArField = document.getElementById(`input_desc_ar_${idx}`);
        descArField.type = 'text';
        descArField.className = 'form-control';
        descArField.style.direction = 'rtl';
    }
}

window.removeBlockRow = function (idx) {
    const row = document.getElementById(`block_row_${idx}`);
    if (row) row.remove();
}

// MODAL CONTROLS: CONFIGURE SERVICE DETAIL PAGE
window.openConfigurePageModal = function (service) {
    const modal = document.getElementById('configurePageModal');
    if (!modal) return;

    // Clear blocks container
    blockCounter = 0;
    const blocksContainer = document.getElementById('blocks_container');
    if (blocksContainer) blocksContainer.innerHTML = '';

    // Parse content_fr
    let contentFr = {};
    if (service.content_fr) {
        try {
            contentFr = JSON.parse(service.content_fr);
        } catch(e) {
            contentFr = {
                hero_title: service.title_fr,
                show_rdv_btn: true,
                blocks: [
                    { title_fr: 'Nos installations', desc_fr: service.content_fr }
                ]
            };
        }
    }

    // Parse content_ar
    let contentAr = {};
    if (service.content_ar) {
        try {
            contentAr = JSON.parse(service.content_ar);
        } catch(e) {
            contentAr = {
                hero_title: service.title_ar,
                show_rdv_btn: true,
                blocks: [
                    { title_ar: 'منشآتنا', desc_ar: service.content_ar }
                ]
            };
        }
    }

    // Fill main fields
    document.getElementById('page_hero_title_fr').value = contentFr.hero_title || service.title_fr || '';
    document.getElementById('page_hero_title_ar').value = contentAr.hero_title || service.title_ar || '';
    
    const showRdvCheckbox = document.getElementById('page_show_rdv_btn');
    if (showRdvCheckbox) {
        showRdvCheckbox.checked = (contentFr.show_rdv_btn !== false);
    }

    // Clear files
    document.getElementById('page_hero_image').value = '';
    
    const heroPreview = document.getElementById('page_hero_image_preview');
    if (heroPreview) heroPreview.innerHTML = '';

    // Parse cover/hero image
    let images = service.additional_images;
    if (typeof images === 'string') {
        try {
            images = JSON.parse(images);
        } catch(e) {
            images = {};
        }
    }
    if (!images || typeof images !== 'object') {
        images = {};
    }

    if (images.hero && heroPreview) {
        heroPreview.innerHTML = `<div class="gallery-preview-item" style="margin-top: 5px;"><img src="/images/services/details/${images.hero}" alt="hero" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;"></div>`;
    }

    // Render blocks
    let frBlocks = contentFr.blocks || [];
    let arBlocks = contentAr.blocks || [];
    let blockImages = images.blocks || [];

    let maxBlocks = Math.max(frBlocks.length, arBlocks.length);
    if (maxBlocks === 0 && service.content_fr) {
        // Fallback for legacy text
        addNewBlockRow({
            title_fr: 'Nos installations',
            title_ar: 'منشآتنا',
            desc_fr: service.content_fr,
            desc_ar: service.content_ar,
            image: (Array.isArray(service.additional_images) ? service.additional_images[0] : null)
        });
    } else {
        for (let i = 0; i < maxBlocks; i++) {
            let fb = frBlocks[i] || {};
            let ab = arBlocks[i] || {};
            addNewBlockRow({
                title_fr: fb.title_fr || fb.title || '',
                title_ar: ab.title_ar || ab.title || '',
                desc_fr: fb.desc_fr || fb.desc || '',
                desc_ar: ab.desc_ar || ab.desc || '',
                image: blockImages[i] || null
            });
        }
    }

    // Form Action
    const form = document.getElementById('configurePageForm');
    if (form) {
        form.action = `/admin/services/${service.id}/pages`;
    }

    modal.style.display = 'flex';
}

window.closeConfigurePageModal = function () {
    const modal = document.getElementById('configurePageModal');
    if (modal) modal.style.display = 'none';
}

// MODAL CONTROLS: EDIT APPOINTMENT
window.openEditAppointmentModal = function (rdv) {
    const modal = document.getElementById('editAppointmentModal');
    if (!modal) return;

    // Format date string to YYYY-MM-DD
    let dateStr = rdv.date;
    if (dateStr && dateStr.includes('T')) {
        dateStr = dateStr.split('T')[0];
    } else if (dateStr && dateStr.includes(' ')) {
        dateStr = dateStr.split(' ')[0];
    }

    // Format time string to HH:MM
    let timeStr = rdv.time;
    if (timeStr && timeStr.length > 5) {
        timeStr = timeStr.substring(0, 5);
    }

    document.getElementById('edit_appt_date').value = dateStr || '';
    document.getElementById('edit_appt_time').value = timeStr || '';

    // Set form action
    const form = document.getElementById('editAppointmentForm');
    if (form) {
        form.action = `/admin/appointments/${rdv.id}`;
    }

    modal.style.display = 'flex';
}

window.closeEditAppointmentModal = function () {
    const modal = document.getElementById('editAppointmentModal');
    if (modal) modal.style.display = 'none';
}

// MODAL CONTROLS: DETAILED APPOINTMENT VIEW & EDIT
window.openDetailAppointmentModal = function (rdv) {
    const modal = document.getElementById('detailAppointmentModal');
    if (!modal) return;

    // Fill standard fields
    document.getElementById('det_firstname').value = rdv.firstname || '';
    document.getElementById('det_lastname').value = rdv.lastname || '';
    document.getElementById('det_age').value = rdv.age || '';
    document.getElementById('det_gender').value = rdv.gender || 'homme';
    document.getElementById('det_phone').value = rdv.phone || '';
    document.getElementById('det_email').value = rdv.email || '';
    document.getElementById('det_description').value = rdv.description || '';

    // Format date string to YYYY-MM-DD
    let dateStr = rdv.date;
    if (dateStr && dateStr.includes('T')) {
        dateStr = dateStr.split('T')[0];
    } else if (dateStr && dateStr.includes(' ')) {
        dateStr = dateStr.split(' ')[0];
    }
    document.getElementById('det_date').value = dateStr || '';

    // Format time string to HH:MM
    let timeStr = rdv.time;
    if (timeStr && timeStr.length > 5) {
        timeStr = timeStr.substring(0, 5);
    }
    document.getElementById('det_time').value = timeStr || '';

    // Render services badges
    const servicesListEl = document.getElementById('det_services_list');
    if (servicesListEl) {
        servicesListEl.innerHTML = '';
        let servicesArr = rdv.services;
        if (typeof servicesArr === 'string') {
            try {
                servicesArr = JSON.parse(servicesArr);
            } catch(e) {
                servicesArr = [];
            }
        }
        if (Array.isArray(servicesArr) && servicesArr.length > 0) {
            servicesArr.forEach(s => {
                const badge = document.createElement('span');
                badge.className = 'badge badge-teal';
                badge.innerText = s;
                servicesListEl.appendChild(badge);
            });
        } else {
            servicesListEl.innerHTML = '<span class="text-gray">-</span>';
        }
    }

    // Toggle accept button visibility depending on status
    const acceptBtn = document.getElementById('modalAcceptBtn');
    if (acceptBtn) {
        if (rdv.status === 'accepte') {
            acceptBtn.style.display = 'none';
        } else {
            acceptBtn.style.display = 'inline-flex';
        }
    }

    // Set action URLs
    const editForm = document.getElementById('detailAppointmentForm');
    if (editForm) {
        editForm.action = `/admin/appointments/${rdv.id}`;
    }

    const acceptForm = document.getElementById('modalAcceptForm');
    if (acceptForm) {
        acceptForm.action = `/admin/appointments/${rdv.id}/accept`;
    }

    const deleteForm = document.getElementById('modalDeleteForm');
    if (deleteForm) {
        deleteForm.action = `/admin/appointments/${rdv.id}`;
    }

    modal.style.display = 'flex';
}

window.closeDetailAppointmentModal = function () {
    const modal = document.getElementById('detailAppointmentModal');
    if (modal) modal.style.display = 'none';
}

window.submitModalAccept = function () {
    const form = document.getElementById('modalAcceptForm');
    if (form) {
        form.submit();
    }
}

window.submitModalDelete = function () {
    if (confirm('Voulez-vous vraiment supprimer ce rendez-vous ?')) {
        const form = document.getElementById('modalDeleteForm');
        if (form) {
            form.submit();
        }
    }
}

window.openAddAppointmentModal = function () {
    const modal = document.getElementById('addAppointmentModal');
    if (modal) modal.style.display = 'flex';
}

window.closeAddAppointmentModal = function () {
    const modal = document.getElementById('addAppointmentModal');
    if (modal) modal.style.display = 'none';
}

// ==========================================================
// =================== BILANS CANVAS EDITOR =================
// ==========================================================
let canvas = null;
let ctx = null;
let currentTool = 'draw'; // 'draw', 'text', 'check'
let currentColor = 'red';
let brushSize = 3;
let isDrawing = false;
let lastX = 0;
let lastY = 0;
let backgroundImage = null;

// Undo & Redo History Stacks
let undoStack = [];
let redoStack = [];
const maxHistory = 30;

// Initialize Bilan Canvas Editor when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    canvas = document.getElementById('bilanCanvas');
    if (!canvas) return;
    ctx = canvas.getContext('2d');

    // Drawing Event Listeners (Mouse)
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);

    // Drawing Event Listeners (Touch for mobile/tablet)
    canvas.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            const pos = getTouchPos(canvas, e);
            startDrawing(pos);
            e.preventDefault();
        }
    }, { passive: false });
    
    canvas.addEventListener('touchmove', (e) => {
        if (e.touches.length === 1) {
            const pos = getTouchPos(canvas, e);
            draw(pos);
            e.preventDefault();
        }
    }, { passive: false });

    canvas.addEventListener('touchend', stopDrawing);

    // --- Dynamic Event Listeners to avoid ES module / global scoping issues ---
    
    // Tool buttons selectors clicks
    const btnToolDraw = document.getElementById('tool_draw');
    if (btnToolDraw) btnToolDraw.addEventListener('click', () => setBilanTool('draw'));

    const btnToolText = document.getElementById('tool_text');
    if (btnToolText) btnToolText.addEventListener('click', () => setBilanTool('text'));

    const btnToolCheck = document.getElementById('tool_check');
    if (btnToolCheck) btnToolCheck.addEventListener('click', () => setBilanTool('check'));

    // Color dots clicks
    document.querySelectorAll('.color-dot').forEach(dot => {
        dot.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            setBilanColor(color, this);
        });
    });

    // Brush size range slider change
    const inputBrushSize = document.getElementById('brush_size');
    if (inputBrushSize) {
        inputBrushSize.addEventListener('input', function() {
            updateBilanBrushSize(this.value);
        });
    }

    // Text size range slider change
    const inputTextSize = document.getElementById('text_size_slider');
    if (inputTextSize) {
        inputTextSize.addEventListener('input', function() {
            const sizeValEl = document.getElementById('text_size_val');
            if (sizeValEl) sizeValEl.innerText = this.value;
        });
    }

    // Undo & Redo Toolbar buttons
    const btnUndo = document.getElementById('btn_undo');
    if (btnUndo) btnUndo.addEventListener('click', undoAction);

    const btnRedo = document.getElementById('btn_redo');
    if (btnRedo) btnRedo.addEventListener('click', redoAction);

    // Clear / Reset Canvas click
    const btnClearCanvas = document.getElementById('btn_clear_canvas');
    if (btnClearCanvas) btnClearCanvas.addEventListener('click', clearBilanCanvas);

    // Save Bilan click
    const btnSaveBilan = document.getElementById('btn_save_bilan');
    if (btnSaveBilan) btnSaveBilan.addEventListener('click', saveBilanToServer);

    // Export PDF click
    const btnExportImage = document.getElementById('btn_export_image');
    if (btnExportImage) btnExportImage.addEventListener('click', exportBilanPDF);

    // Catalog schema card clicks (Opens editor modal)
    document.querySelectorAll('.schema-card').forEach(card => {
        card.addEventListener('click', function() {
            const src = this.getAttribute('data-src');
            const filename = this.getAttribute('data-filename');
            openBilanEditor(src, filename);
        });
    });

    // Close editor triggers (backdrop and close cross)
    document.querySelectorAll('.Bilan-modal-close-trigger').forEach(trigger => {
        trigger.addEventListener('click', closeBilanEditor);
    });

    // Real-time catalog schema filtering search input
    const schemaSearchInput = document.getElementById('bilanSchemaSearch');
    if (schemaSearchInput) {
        schemaSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.schema-card');
            
            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                if (name.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

// Helper to get touch position relative to canvas
function getTouchPos(canvasDom, touchEvent) {
    const rect = canvasDom.getBoundingClientRect();
    return {
        clientX: touchEvent.touches[0].clientX,
        clientY: touchEvent.touches[0].clientY,
        offsetX: touchEvent.touches[0].clientX - rect.left,
        offsetY: touchEvent.touches[0].clientY - rect.top
    };
}

// Save Canvas state for Undo/Redo operations
function saveState() {
    if (!canvas || !ctx) return;
    if (undoStack.length >= maxHistory) {
        undoStack.shift();
    }
    undoStack.push(canvas.toDataURL());
    redoStack = []; // Reset Redo stack whenever user performs a new active modification
    updateUndoRedoButtons();
}

// Update Undo and Redo buttons visual states in DOM
function updateUndoRedoButtons() {
    const btnUndo = document.getElementById('btn_undo');
    const btnRedo = document.getElementById('btn_redo');
    
    if (btnUndo) {
        const canUndo = undoStack.length > 1;
        btnUndo.disabled = !canUndo;
        btnUndo.style.opacity = canUndo ? '1' : '0.4';
        btnUndo.style.cursor = canUndo ? 'pointer' : 'not-allowed';
    }
    if (btnRedo) {
        const canRedo = redoStack.length > 0;
        btnRedo.disabled = !canRedo;
        btnRedo.style.opacity = canRedo ? '1' : '0.4';
        btnRedo.style.cursor = canRedo ? 'pointer' : 'not-allowed';
    }
}

// Perform Undo action
function undoAction() {
    if (undoStack.length <= 1) return; // Keep initial clean background state

    const currentState = undoStack.pop();
    redoStack.push(currentState);

    const prevImgSrc = undoStack[undoStack.length - 1];
    const img = new Image();
    img.src = prevImgSrc;
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        updateUndoRedoButtons();
    };
}

// Perform Redo action
function redoAction() {
    if (redoStack.length === 0) return;

    const nextImgSrc = redoStack.pop();
    undoStack.push(nextImgSrc);

    const img = new Image();
    img.src = nextImgSrc;
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        updateUndoRedoButtons();
    };
}

// Start drawing or perform action on click
function startDrawing(e) {
    const x = e.offsetX;
    const y = e.offsetY;

    if (currentTool === 'draw') {
        isDrawing = true;
        [lastX, lastY] = [x, y];
    } else if (currentTool === 'text') {
        drawTextOnCanvas(x, y);
    } else if (currentTool === 'check') {
        drawCheckOnCanvas(x, y);
    }
}

// Draw line on mousemove
function draw(e) {
    if (!isDrawing || currentTool !== 'draw') return;
    const x = e.offsetX;
    const y = e.offsetY;

    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    
    // Line style
    ctx.strokeStyle = currentColor;
    ctx.lineWidth = brushSize;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    
    ctx.stroke();
    [lastX, lastY] = [x, y];
}

// Stop drawing
function stopDrawing() {
    if (isDrawing) {
        isDrawing = false;
        saveState(); // Save state when drawing line is finished
    }
}

// Set active tool
function setBilanTool(tool) {
    currentTool = tool;
    
    // Toggle active button style
    document.querySelectorAll('.tool-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(`tool_${tool}`).classList.add('active');

    // Toggle tool config panels
    document.querySelectorAll('.tool-config-panel').forEach(panel => panel.style.display = 'none');
    document.getElementById(`config_${tool}`).style.display = 'block';
}

// Set drawing color
function setBilanColor(color, element) {
    currentColor = color;
    document.querySelectorAll('.color-dot').forEach(dot => dot.classList.remove('active'));
    element.classList.add('active');
}

// Update brush size
function updateBilanBrushSize(val) {
    brushSize = val;
    document.getElementById('brush_val').innerText = val;
}

// Open Clinical Editor Modal and load selected diagram
function openBilanEditor(src, schemaName) {
    const modal = document.getElementById('bilanEditorModal');
    if (modal) modal.style.display = 'flex';

    // Update loaded schema name label
    document.getElementById('loaded_schema_name').innerText = schemaName;

    // Reset patient details form inside modal
    document.getElementById('bilan_patient_name').value = '';
    document.getElementById('bilan_date').value = new Date().toISOString().substring(0, 10);
    document.getElementById('bilan_pathology').value = '';
    document.getElementById('bilan_notes').value = '';

    // Set defaults tool states
    currentTool = 'draw';
    currentColor = 'red';
    brushSize = 3;
    document.getElementById('brush_size').value = 3;
    document.getElementById('brush_val').innerText = '3';

    // Reset text defaults
    const textInputVal = document.getElementById('text_input_val');
    if (textInputVal) textInputVal.value = 'Douleur';
    const textFontFamily = document.getElementById('text_font_family');
    if (textFontFamily) textFontFamily.value = "'Inter', sans-serif";
    const textFontStyle = document.getElementById('text_font_style');
    if (textFontStyle) textFontStyle.value = 'bold';
    const textSizeSlider = document.getElementById('text_size_slider');
    if (textSizeSlider) textSizeSlider.value = 16;
    const textSizeVal = document.getElementById('text_size_val');
    if (textSizeVal) textSizeVal.innerText = '16';
    
    // Toggle active tools
    document.querySelectorAll('.tool-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('tool_draw').classList.add('active');
    document.querySelectorAll('.tool-config-panel').forEach(p => p.style.display = 'none');
    document.getElementById('config_draw').style.display = 'block';

    document.querySelectorAll('.color-dot').forEach(dot => dot.classList.remove('active'));
    // Find the red color dot and activate it
    const redDot = document.querySelector('.color-dot[data-color="red"]');
    if (redDot) redDot.classList.add('active');

    // Load image file
    const img = new Image();
    img.crossOrigin = 'anonymous'; // Avoid tainted canvas
    img.src = src;
    img.onload = function() {
        backgroundImage = img;
        
        // Dynamically calculate canvas size to maintain aspect ratio
        const maxWidth = 700; // Optimal max width for the workspace
        let finalWidth = img.width;
        let finalHeight = img.height;
        
        if (img.width > maxWidth) {
            const ratio = maxWidth / img.width;
            finalWidth = maxWidth;
            finalHeight = img.height * ratio;
        } else if (img.width < 500) {
            // If image is too small, scale it up slightly for better editing
            const ratio = 600 / img.width;
            finalWidth = 600;
            finalHeight = img.height * ratio;
        }
        
        canvas.width = finalWidth;
        canvas.height = finalHeight;

        // Reset Canvas manually with clean background
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);
        
        // Reset history stacks
        undoStack = [];
        redoStack = [];
        saveState(); // Push initial canvas state
    };
}

// Close Clinical Editor Modal
function closeBilanEditor() {
    const modal = document.getElementById('bilanEditorModal');
    if (modal) modal.style.display = 'none';
    backgroundImage = null;
    undoStack = [];
    redoStack = [];
}

// Clear drawing, keeping background
function clearBilanCanvas() {
    if (!canvas || !ctx) return;
    
    // Clear whole canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Redraw background image if loaded
    if (backgroundImage) {
        ctx.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);
    }

    saveState(); // Record clean canvas state in history stack
}

// Draw text on click
function drawTextOnCanvas(x, y) {
    const textVal = document.getElementById('text_input_val').value.trim();
    if (!textVal) return;

    const fontFamily = document.getElementById('text_font_family').value;
    const fontStyle = document.getElementById('text_font_style').value;
    const fontSize = document.getElementById('text_size_slider').value;

    ctx.font = `${fontStyle} ${fontSize}px ${fontFamily}`;
    ctx.fillStyle = currentColor || 'black'; // Use active color selected in color picker
    ctx.textBaseline = 'middle';
    
    // Draw a small background glow for readability
    ctx.shadowColor = 'white';
    ctx.shadowBlur = 4;
    ctx.fillText(textVal, x, y);
    ctx.shadowBlur = 0; // Reset

    saveState(); // Save state after drawing text
}

// Draw checkmark or cross on click
function drawCheckOnCanvas(x, y) {
    const checkType = document.querySelector('input[name="check_type"]:checked').value;
    
    ctx.font = `bold ${Math.max(16, brushSize * 5)}px 'Inter', sans-serif`;
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'center';
    
    // Shadow for visibility
    ctx.shadowColor = 'white';
    ctx.shadowBlur = 4;
    
    if (checkType === 'check') {
        ctx.fillStyle = 'green';
        ctx.fillText('✓', x, y);
    } else {
        ctx.fillStyle = 'red';
        ctx.fillText('✗', x, y);
    }
    
    ctx.shadowBlur = 0; // Reset

    saveState(); // Save state after drawing check/cross
}

// Save Bilan to the database via AJAX POST (All text inputs are optional)
function saveBilanToServer() {
    // Make fields completely optional, defaulting to placeholders if empty
    const patientNameInput = document.getElementById('bilan_patient_name').value.trim();
    const patientName = patientNameInput !== "" ? patientNameInput : 'Bilan';
    
    const dateInput = document.getElementById('bilan_date').value;
    const date = dateInput !== "" ? dateInput : new Date().toISOString().substring(0, 10);
    
    const pathology = document.getElementById('bilan_pathology').value.trim();
    const notes = document.getElementById('bilan_notes').value.trim();

    if (!backgroundImage) {
        alert('Veuillez sélectionner un schéma diagnostique avant d\'enregistrer.');
        return;
    }

    // Get base64 encoded PNG image from canvas
    const dataUrl = canvas.toDataURL('image/png');

    // Send POST request
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Disable save button to avoid duplicate clicks
    const saveBtn = document.getElementById('btn_save_bilan');
    if (saveBtn) saveBtn.disabled = true;

    fetch('/admin/bilans', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            patient_name: patientName,
            date: date,
            pathology: pathology,
            notes: notes,
            image: dataUrl
        })
    })
    .then(response => response.json())
    .then(data => {
        if (saveBtn) saveBtn.disabled = false;
        
        if (data.success) {
            alert(data.message);
            // Reload the page to refresh statistics and show the saved report in the history archive table
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue lors de l\'enregistrement.'));
        }
    })
    .catch(error => {
        if (saveBtn) saveBtn.disabled = false;
        console.error('Error:', error);
        alert('Une erreur réseau s\'est produite. Veuillez réessayer.');
    });
}

// Export current annotated Canvas as PDF
function exportBilanPDF() {
    const patientNameInput = document.getElementById('bilan_patient_name').value.trim();
    const patientName = patientNameInput !== "" ? patientNameInput : 'Bilan';

    const dateInput = document.getElementById('bilan_date').value;
    const date = dateInput !== "" ? dateInput : new Date().toISOString().substring(0, 10);

    const pathology = document.getElementById('bilan_pathology').value.trim();
    const notes = document.getElementById('bilan_notes').value.trim();

    if (!backgroundImage) {
        alert('Veuillez sélectionner un schéma diagnostique avant d\'exporter.');
        return;
    }

    // Get canvas image as base64 PNG
    const canvasDataUrl = canvas.toDataURL('image/png');

    // Get logo URL (absolute URL for cross-origin compatibility)
    const logoUrl = document.querySelector('#bilanPrintContainer img[src*="logo1"]')
        ? document.querySelector('#bilanPrintContainer img[src*="logo1"]').src
        : window.location.origin + '/images/logos/logo1.png';

    // Format date nicely (YYYY-MM-DD -> DD/MM/YYYY)
    let displayDate = date;
    if (date && date.includes('-')) {
        const parts = date.split('-');
        displayDate = parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    // Build the full PDF HTML content as a string
    const notesSection = notes !== "" ? `
        <div style="margin-bottom:15px;">
            <h3 style="font-size:0.95rem;font-weight:700;border-bottom:1.5px solid #cbd5e0;padding-bottom:2px;margin:0 0 5px 0;color:#2d3748;">Observations cliniques &amp; Plan de traitement</h3>
            <div style="font-size:0.88rem;color:#2d3748;white-space:pre-line;background:#f7fafc;padding:8px;border-radius:4px;border:1px solid #edf2f7;min-height:40px;">${notes.replace(/</g,'&lt;').replace(/>/g,'&gt;')}</div>
        </div>` : '';

    const htmlContent = `
        <div style="width:794px;background:white;padding:20px;font-family:Arial,Helvetica,sans-serif;box-sizing:border-box;color:#1a202c;line-height:1.5;direction:ltr;">
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #319795;padding-bottom:10px;margin-bottom:15px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <img src="${logoUrl}" style="height:60px;object-fit:contain;" crossorigin="anonymous">
                    <div>
                        <h1 style="font-size:1.15rem;font-weight:800;color:#2d3748;margin:0;text-transform:uppercase;letter-spacing:0.5px;">Centre Thérapeutique Privé</h1>
                        <p style="font-size:0.85rem;font-weight:700;color:#319795;margin:2px 0 0 0;">Expérience de +20 ans</p>
                    </div>
                </div>
                <div style="text-align:right;font-size:0.75rem;color:#718096;line-height:1.3;">
                    <p style="margin:0;font-weight:600;">36, Av Mohammed V, 2ème étg, N° 3, Fès, Maroc</p>
                    <p style="margin:2px 0 0 0;">Tél : 0535 94 18 08 / 0661 93 65 00</p>
                    <p style="margin:2px 0 0 0;">E-mail : therapeutiquecentre@gmail.com</p>
                </div>
            </div>
            <div style="text-align:center;margin-bottom:15px;">
                <h2 style="font-size:1.45rem;font-weight:800;color:#1a202c;border:1.5px solid #2d3748;padding:6px 20px;display:inline-block;border-radius:4px;background:#f7fafc;margin:0;text-transform:uppercase;">Bilan Kinésithérapique</h2>
            </div>
            <table style="width:100%;border-collapse:collapse;margin-bottom:15px;font-size:0.88rem;">
                <tr>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;width:180px;">Nom &amp; Prénom :</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;">${patientName}</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;width:140px;">Date :</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;width:160px;">${displayDate}</td>
                </tr>
                <tr>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;">Pathologie / Diagnostic :</td>
                    <td colspan="3" style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;">${(pathology || 'Non spécifié').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</td>
                </tr>
            </table>
            <div style="display:flex;justify-content:center;margin-bottom:15px;background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:5px;">
                <img src="${canvasDataUrl}" style="width:100%;max-height:600px;object-fit:contain;">
            </div>
            ${notesSection}
            <div style="display:flex;justify-content:flex-end;margin-top:15px;padding-right:20px;">
                <div style="text-align:center;width:220px;">
                    <p style="font-size:0.82rem;font-weight:700;margin:0 0 50px 0;color:#4a5568;">Signature &amp; Cachet du Praticien</p>
                    <div style="border-top:1.5px solid #cbd5e0;width:100%;"></div>
                </div>
            </div>
        </div>`;

    // Create a temporary off-screen container so html2canvas can render it properly.
    // Wrap it inside a 0x0 container with overflow hidden so it remains completely invisible during rendering.
    const tempWrapper = document.createElement('div');
    tempWrapper.style.cssText = 'position:fixed;left:0;top:0;width:0;height:0;overflow:hidden;z-index:-9999;pointer-events:none;';
    tempWrapper.innerHTML = htmlContent;
    document.body.appendChild(tempWrapper);

    const contentEl = tempWrapper.firstElementChild;

    // Wait for DOM reflow/repaint to ensure html2canvas captures correctly without offsets.
    setTimeout(async () => {
        try {
            const canvasResult = await html2canvas(contentEl, {
                scale: 2,
                useCORS: true,
                scrollX: 0,
                scrollY: 0,
                windowWidth: contentEl.scrollWidth,
                windowHeight: contentEl.scrollHeight
            });

            const canvasWidth = canvasResult.width;
            const canvasHeight = canvasResult.height;

            // Resolve global jsPDF constructor (checking both standard modular and older global scopes)
            const jsPDFConstructor = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : window.jsPDF;
            if (!jsPDFConstructor) {
                throw new Error("jsPDF library is not loaded.");
            }

            const doc = new jsPDFConstructor({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Layout metrics
            const marginX = 10;
            const marginY = 10;
            const pageWidth = 210;
            const pageHeight = 297;
            const imgWidth = pageWidth - (marginX * 2); // 190 mm
            const usablePageHeight = pageHeight - (marginY * 2); // 277 mm

            // Slice height in canvas pixels corresponding to usable page height
            const sliceHeightPx = (canvasWidth * usablePageHeight) / imgWidth;

            let sourceY = 0;
            let pageIndex = 0;

            while (sourceY < canvasHeight) {
                if (pageIndex > 0) {
                    doc.addPage();
                }

                const currentSliceHeightPx = Math.min(sliceHeightPx, canvasHeight - sourceY);

                // Create a temporary canvas for this specific page slice
                const sliceCanvas = document.createElement('canvas');
                sliceCanvas.width = canvasWidth;
                sliceCanvas.height = currentSliceHeightPx;

                const ctxSlice = sliceCanvas.getContext('2d');
                // Fill with white background to prevent JPEG conversion from rendering transparent background as black
                ctxSlice.fillStyle = '#ffffff';
                ctxSlice.fillRect(0, 0, sliceCanvas.width, sliceCanvas.height);

                // Draw the specific slice from the main captured canvas
                ctxSlice.drawImage(
                    canvasResult,
                    0, sourceY, canvasWidth, currentSliceHeightPx, // source
                    0, 0, canvasWidth, currentSliceHeightPx        // destination
                );

                // Convert slice canvas to high quality JPEG image data
                const imgData = sliceCanvas.toDataURL('image/jpeg', 0.98);

                // Calculate image height on PDF page in mm
                const imgHeight = (currentSliceHeightPx * imgWidth) / canvasWidth;

                // Add slice image to current PDF page
                doc.addImage(imgData, 'JPEG', marginX, marginY, imgWidth, imgHeight);

                sourceY += currentSliceHeightPx;
                pageIndex++;
            }

            // Save generated PDF file
            doc.save(`Bilan_${patientName.replace(/\s+/g, '_')}_${date}.pdf`);

        } catch (err) {
            console.error("PDF Export Error:", err);
            alert("Une erreur est survenue lors de la génération du PDF.");
        } finally {
            // Safely remove the temporary DOM element
            if (tempWrapper && tempWrapper.parentNode) {
                tempWrapper.parentNode.removeChild(tempWrapper);
            }
        }
    }, 150);
}

// Generate PDF from Bilan history archive dynamically on the client-side
function generateBilanPDFFromHistory(element, actionType) {
    const patientName = element.getAttribute('data-patient-name') || 'Bilan';
    const date = element.getAttribute('data-date') || '';
    const pathology = element.getAttribute('data-pathology') || '';
    const notes = element.getAttribute('data-notes') || '';
    const imagePath = element.getAttribute('data-image-path');

    if (!imagePath) {
        alert("Erreur: image du bilan introuvable.");
        return;
    }

    // Format date nicely (YYYY-MM-DD -> DD/MM/YYYY)
    let displayDate = date;
    if (date && date.includes('-')) {
        const parts = date.split('-');
        displayDate = parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    // Get logo URL (absolute URL for cross-origin compatibility)
    const logoUrl = document.querySelector('#bilanPrintContainer img[src*="logo1"]')
        ? document.querySelector('#bilanPrintContainer img[src*="logo1"]').src
        : window.location.origin + '/images/logos/logo1.png';

    // Build the full PDF HTML content as a string
    const notesSection = notes !== "" ? `
        <div style="margin-bottom:15px;">
            <h3 style="font-size:0.95rem;font-weight:700;border-bottom:1.5px solid #cbd5e0;padding-bottom:2px;margin:0 0 5px 0;color:#2d3748;">Observations cliniques &amp; Plan de traitement</h3>
            <div style="font-size:0.88rem;color:#2d3748;white-space:pre-line;background:#f7fafc;padding:8px;border-radius:4px;border:1px solid #edf2f7;min-height:40px;">${notes.replace(/</g,'&lt;').replace(/>/g,'&gt;')}</div>
        </div>` : '';

    const htmlContent = `
        <div style="width:794px;background:white;padding:20px;font-family:Arial,Helvetica,sans-serif;box-sizing:border-box;color:#1a202c;line-height:1.5;direction:ltr;">
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #319795;padding-bottom:10px;margin-bottom:15px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <img src="${logoUrl}" style="height:60px;object-fit:contain;" crossorigin="anonymous">
                    <div>
                        <h1 style="font-size:1.15rem;font-weight:800;color:#2d3748;margin:0;text-transform:uppercase;letter-spacing:0.5px;">Centre Thérapeutique Privé</h1>
                        <p style="font-size:0.85rem;font-weight:700;color:#319795;margin:2px 0 0 0;">Expérience de +20 ans</p>
                    </div>
                </div>
                <div style="text-align:right;font-size:0.75rem;color:#718096;line-height:1.3;">
                    <p style="margin:0;font-weight:600;">36, Av Mohammed V, 2ème étg, N° 3, Fès, Maroc</p>
                    <p style="margin:2px 0 0 0;">Tél : 0535 94 18 08 / 0661 93 65 00</p>
                    <p style="margin:2px 0 0 0;">E-mail : therapeutiquecentre@gmail.com</p>
                </div>
            </div>
            <div style="text-align:center;margin-bottom:15px;">
                <h2 style="font-size:1.45rem;font-weight:800;color:#1a202c;border:1.5px solid #2d3748;padding:6px 20px;display:inline-block;border-radius:4px;background:#f7fafc;margin:0;text-transform:uppercase;">Bilan Kinésithérapique</h2>
            </div>
            <table style="width:100%;border-collapse:collapse;margin-bottom:15px;font-size:0.88rem;">
                <tr>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;width:180px;">Nom &amp; Prénom :</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;">${patientName}</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;width:140px;">Date :</td>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;width:160px;">${displayDate}</td>
                </tr>
                <tr>
                    <td style="padding:4px 10px;border:1px solid #cbd5e0;font-weight:700;background:#edf2f7;">Pathologie / Diagnostic :</td>
                    <td colspan="3" style="padding:4px 10px;border:1px solid #cbd5e0;color:#2d3748;">${(pathology || 'Non spécifié').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</td>
                </tr>
            </table>
            <div style="display:flex;justify-content:center;margin-bottom:15px;background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:5px;">
                <img id="history_bilan_image" src="${imagePath}" style="width:100%;max-height:600px;object-fit:contain;" crossorigin="anonymous">
            </div>
            ${notesSection}
            <div style="display:flex;justify-content:flex-end;margin-top:15px;padding-right:20px;">
                <div style="text-align:center;width:220px;">
                    <p style="font-size:0.82rem;font-weight:700;margin:0 0 50px 0;color:#4a5568;">Signature &amp; Cachet du Praticien</p>
                    <div style="border-top:1.5px solid #cbd5e0;width:100%;"></div>
                </div>
            </div>
        </div>`;

    // Create a temporary off-screen container
    // Wrap it inside a 0x0 container with overflow hidden so it remains completely invisible during rendering.
    const tempWrapper = document.createElement('div');
    tempWrapper.style.cssText = 'position:fixed;left:0;top:0;width:0;height:0;overflow:hidden;z-index:-9999;pointer-events:none;';
    tempWrapper.innerHTML = htmlContent;
    document.body.appendChild(tempWrapper);

    const contentEl = tempWrapper.firstElementChild;
    const imgEl = document.getElementById('history_bilan_image');

    // Show a loading feedback on the button/preview-trigger
    const isButton = element.tagName.toLowerCase() === 'button' && !element.classList.contains('btn-action-preview');
    const originalContent = element.innerHTML;
    if (isButton) {
        element.innerHTML = 'Génération...';
    }
    element.style.pointerEvents = 'none';

    // Wait for the image to load completely
    const generatePDF = async () => {
        try {
            const canvasResult = await html2canvas(contentEl, {
                scale: 2,
                useCORS: true,
                scrollX: 0,
                scrollY: 0,
                windowWidth: contentEl.scrollWidth,
                windowHeight: contentEl.scrollHeight
            });

            const canvasWidth = canvasResult.width;
            const canvasHeight = canvasResult.height;

            const jsPDFConstructor = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : window.jsPDF;
            if (!jsPDFConstructor) {
                throw new Error("jsPDF library is not loaded.");
            }

            const doc = new jsPDFConstructor({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            const marginX = 10;
            const marginY = 10;
            const pageWidth = 210;
            const pageHeight = 297;
            const imgWidth = pageWidth - (marginX * 2); // 190 mm
            const usablePageHeight = pageHeight - (marginY * 2); // 277 mm

            const sliceHeightPx = (canvasWidth * usablePageHeight) / imgWidth;

            let sourceY = 0;
            let pageIndex = 0;

            while (sourceY < canvasHeight) {
                if (pageIndex > 0) {
                    doc.addPage();
                }

                const currentSliceHeightPx = Math.min(sliceHeightPx, canvasHeight - sourceY);

                const sliceCanvas = document.createElement('canvas');
                sliceCanvas.width = canvasWidth;
                sliceCanvas.height = currentSliceHeightPx;

                const ctxSlice = sliceCanvas.getContext('2d');
                ctxSlice.fillStyle = '#ffffff';
                ctxSlice.fillRect(0, 0, sliceCanvas.width, sliceCanvas.height);

                ctxSlice.drawImage(
                    canvasResult,
                    0, sourceY, canvasWidth, currentSliceHeightPx,
                    0, 0, canvasWidth, currentSliceHeightPx
                );

                const imgData = sliceCanvas.toDataURL('image/jpeg', 0.98);
                const imgHeight = (currentSliceHeightPx * imgWidth) / canvasWidth;

                doc.addImage(imgData, 'JPEG', marginX, marginY, imgWidth, imgHeight);

                sourceY += currentSliceHeightPx;
                pageIndex++;
            }

            if (actionType === 'download') {
                doc.save(`Bilan_${patientName.replace(/\s+/g, '_')}_${date}.pdf`);
            } else {
                // Open in new window
                const blob = doc.output('blob');
                const url = URL.createObjectURL(blob);
                window.open(url, '_blank');
            }

        } catch (err) {
            console.error("PDF Generation Error:", err);
            alert("Une erreur est survenue lors de la génération du PDF.");
        } finally {
            // Restore button content
            if (isButton) {
                element.innerHTML = originalContent;
            }
            element.style.pointerEvents = '';
            
            // Cleanup
            if (tempWrapper && tempWrapper.parentNode) {
                tempWrapper.parentNode.removeChild(tempWrapper);
            }
        }
    };

    if (imgEl.complete) {
        generatePDF();
    } else {
        imgEl.onload = generatePDF;
        imgEl.onerror = () => {
            alert("Erreur de chargement de l'image du bilan.");
            if (isButton) {
                element.innerHTML = originalContent;
            }
            element.style.pointerEvents = '';
            if (tempWrapper && tempWrapper.parentNode) {
                tempWrapper.parentNode.removeChild(tempWrapper);
            }
        };
    }
}

window.openUploadSchemaModal = function() {
    const modal = document.getElementById('uploadSchemaModal');
    if (modal) {
        modal.style.display = 'flex';
    }
};

window.closeUploadSchemaModal = function() {
    const modal = document.getElementById('uploadSchemaModal');
    if (modal) {
        modal.style.display = 'none';
        const form = modal.querySelector('form');
        if (form) form.reset();
    }
};

window.renameSchemaPrompt = function(oldFilename, currentLabel) {
    const newName = prompt(`Entrez le nouveau nom pour le schéma "${currentLabel}" :`, currentLabel);
    if (newName === null) return; // Cancelled
    
    const trimmed = newName.trim();
    if (!trimmed) {
        alert("Le nom ne peut pas être vide.");
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/admin/schemas/rename', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            old_filename: oldFilename,
            new_name: trimmed
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || "Une erreur est survenue.");
        }
    })
    .catch(err => {
        console.error("Error renaming schema:", err);
        alert("Une erreur est survenue lors de la communication avec le serveur.");
    });
};

window.deleteSchemaConfirm = function(filename, label) {
    if (!confirm(`Voulez-vous vraiment supprimer le schéma "${label}" ? Cette action est irréversible.`)) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/admin/schemas/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            filename: filename
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || "Une erreur est survenue.");
        }
    })
    .catch(err => {
        console.error("Error deleting schema:", err);
        alert("Une erreur est survenue lors de la communication avec le serveur.");
    });
};
