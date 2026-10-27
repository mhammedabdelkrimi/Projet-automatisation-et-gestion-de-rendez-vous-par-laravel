import './logo-rotator.js';

// Language Switch System for RDV Page
window.setLang = function (lang) {
    const frBtn = document.getElementById('fr');
    const arBtn = document.getElementById('ar');

    if (frBtn) frBtn.classList.remove('active');
    if (arBtn) arBtn.classList.remove('active');

    if (lang === 'ar') {
        document.documentElement.lang = "ar";
        document.body.style.direction = "rtl";
        document.body.classList.remove('lang-fr');
        document.body.classList.add('lang-ar');
        if (arBtn) arBtn.classList.add('active');
    } else {
        document.documentElement.lang = "fr";
        document.body.style.direction = "ltr";
        document.body.classList.remove('lang-ar');
        document.body.classList.add('lang-fr');
        if (frBtn) frBtn.classList.add('active');
    }
}

// Initialize Default Language and hamburger trigger
document.addEventListener('DOMContentLoaded', function () {
    window.setLang('fr');

    // Mobile Hamburger Toggle
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const menu = document.querySelector(".menu");
    if (hamburgerBtn && menu) {
        hamburgerBtn.addEventListener("click", function () {
            hamburgerBtn.classList.toggle("active");
            menu.classList.toggle("active");
        });
    }

    // Date change listener for generating time slots
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    
    if (dateInput && timeSelect) {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        dateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            if (!selectedDate) {
                timeSelect.disabled = true;
                timeSelect.innerHTML = `<option value="">${document.documentElement.lang === 'ar' ? 'يرجى اختيار التاريخ أولاً' : "Veuillez d'abord choisir une date"}</option>`;
                return;
            }

            // Check if Sunday
            const parts = selectedDate.split('-');
            const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
            const day = dateObj.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

            if (day === 0) {
                alert(document.documentElement.lang === 'ar' 
                    ? 'المركز مغلق يوم الأحد. يرجى اختيار تاريخ آخر.' 
                    : 'Le centre est fermé le dimanche. Veuillez choisir une autre date.');
                this.value = '';
                timeSelect.disabled = true;
                timeSelect.innerHTML = `<option value="">${document.documentElement.lang === 'ar' ? 'يرجى اختيار التاريخ أولاً' : "Veuillez d'abord choisir une date"}</option>`;
                return;
            }

            // Generate slots
            // Weekdays (Monday-Friday): 09:00 - 19:00 -> last slot starts at 18:30
            // Saturday: 09:00 - 14:00 -> last slot starts at 13:30
            const slots = [];
            const startHour = 9;
            const endHour = (day === 6) ? 14 : 19; // Saturday vs Weekdays

            for (let hour = startHour; hour < endHour; hour++) {
                const hourStr = hour < 10 ? '0' + hour : '' + hour;
                slots.push(`${hourStr}:00`);
                slots.push(`${hourStr}:30`);
            }

            // Fetch booked slots
            timeSelect.disabled = true;
            timeSelect.innerHTML = `<option value="">${document.documentElement.lang === 'ar' ? 'جاري تحميل المواعيد...' : 'Chargement des créneaux...'}</option>`;

            fetch(`/appointments/booked-slots?date=${selectedDate}`)
                .then(response => response.json())
                .then(bookedSlots => {
                    // Filter out already booked slots
                    // bookedSlots is an array of HH:MM (e.g. ['09:30', '14:00'])
                    const availableSlots = slots.filter(slot => !bookedSlots.includes(slot));

                    if (availableSlots.length === 0) {
                        timeSelect.innerHTML = `<option value="">${document.documentElement.lang === 'ar' ? 'لا توجد مواعيد متاحة في هذا اليوم' : 'Aucun créneau disponible ce jour'}</option>`;
                        timeSelect.disabled = true;
                    } else {
                        let optionsHtml = `<option value="">${document.documentElement.lang === 'ar' ? '-- اختر توقيت حصتكم --' : '-- Choisir votre créneau --'}</option>`;
                        availableSlots.forEach(slot => {
                            optionsHtml += `<option value="${slot}">${slot}</option>`;
                        });
                        timeSelect.innerHTML = optionsHtml;
                        timeSelect.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Error fetching booked slots:', err);
                    timeSelect.innerHTML = `<option value="">${document.documentElement.lang === 'ar' ? 'خطأ في تحميل البيانات' : 'Erreur de chargement'}</option>`;
                    timeSelect.disabled = true;
                });
        });
    }
});

// Accordion Toggle Handler
window.toggleAccordion = function (headerButton) {
    const accordionItem = headerButton.parentElement;
    const accordionContent = accordionItem.querySelector('.accordion-content');
    const allItems = accordionItem.parentElement.querySelectorAll('.accordion-item');

    // Toggle selected accordion
    if (accordionItem.classList.contains('active')) {
        accordionItem.classList.remove('active');
        accordionContent.style.maxHeight = null;
    } else {
        accordionItem.classList.add('active');
        accordionContent.style.maxHeight = accordionContent.scrollHeight + "px";
    }
}

// Form Submit Handler
window.handleFormSubmit = function (event) {
    event.preventDefault();
    
    const form = event.target;
    const submitBtn = form.querySelector('.rdv-submit-btn');
    
    // Disable button to prevent double submit
    if (submitBtn) submitBtn.disabled = true;

    // Validate that at least one service checkbox is checked
    const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
    if (checkedServices.length === 0) {
        if (submitBtn) submitBtn.disabled = false;
        
        const currentLang = document.documentElement.lang || 'fr';
        const msg = currentLang === 'ar' 
            ? 'يرجى اختيار خدمة واحدة على الأقل لتأكيد موعدكم.' 
            : 'Veuillez sélectionner au moins un service pour valider votre rendez-vous.';
            
        // Show validation error banner
        let errorBanner = document.getElementById('formErrorBanner');
        if (errorBanner) {
            errorBanner.remove();
        }
        
        const banner = document.createElement('div');
        banner.id = 'formErrorBanner';
        banner.style.background = '#fee2e2';
        banner.style.color = '#ef4444';
        banner.style.padding = '12px';
        banner.style.borderRadius = '8px';
        banner.style.marginBottom = '20px';
        banner.style.fontWeight = '600';
        banner.style.fontSize = '14px';
        banner.style.border = '1px solid #fecaca';
        
        if (currentLang === 'ar') {
            banner.style.direction = 'rtl';
        } else {
            banner.style.direction = 'ltr';
        }
        banner.innerText = msg;
        
        form.prepend(banner);
        document.getElementById('rdvContentSection').scrollIntoView({ behavior: 'smooth' });
        
        // Highlight services wrapper
        const accordionWrapper = form.querySelector('.rdv-accordion-wrapper');
        if (accordionWrapper) {
            accordionWrapper.style.border = '1px solid #ef4444';
            accordionWrapper.style.borderRadius = '8px';
            accordionWrapper.style.padding = '5px';
        }
        return;
    } else {
        // Reset services border if previously highlighted
        const accordionWrapper = form.querySelector('.rdv-accordion-wrapper');
        if (accordionWrapper) {
            accordionWrapper.style.border = '';
            accordionWrapper.style.borderRadius = '';
            accordionWrapper.style.padding = '';
        }
    }
    
    // Clear any previous general error banner
    let errorBanner = document.getElementById('formErrorBanner');
    if (errorBanner) {
        errorBanner.remove();
    }
    
    // Clear any field-specific errors
    form.querySelectorAll('.form-control').forEach(el => {
        el.style.borderColor = '';
    });

    const services = Array.from(form.querySelectorAll('input[name="services[]"]:checked')).map(cb => cb.value);

    const data = {
        firstname: document.getElementById('firstname').value,
        lastname: document.getElementById('lastname').value,
        age: document.getElementById('age').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        gender: form.querySelector('input[name="gender"]:checked')?.value || 'homme',
        date: document.getElementById('date').value,
        time: document.getElementById('time').value,
        services: services,
        description: document.getElementById('description').value,
        lang: document.documentElement.lang || 'fr',
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/rdv', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json().then(json => ({ status: response.status, body: json })))
    .then(({ status, body }) => {
        if (submitBtn) submitBtn.disabled = false;

        if (status === 200 && body.success) {
            const rdvCard = document.getElementById('rdvCard');
            const successBox = document.getElementById('successBox');
            
            if (rdvCard && successBox) {
                rdvCard.style.display = 'none';
                successBox.style.display = 'block';
                document.getElementById('rdvContentSection').scrollIntoView({ behavior: 'smooth' });
            }
        } else {
            // Handle validation errors or server errors
            const currentLang = document.documentElement.lang || 'fr';
            let displayMessage = body.message || (currentLang === 'ar' ? 'حدث خطأ ما. يرجى المحاولة مرة أخرى.' : 'Une erreur est survenue. Veuillez réessayer.');
            
            // Extract the first validation error if present
            if (body.errors) {
                const firstErrorField = Object.keys(body.errors)[0];
                if (firstErrorField && body.errors[firstErrorField] && body.errors[firstErrorField][0]) {
                    displayMessage = body.errors[firstErrorField][0];
                }
            }

            // Create a general error banner
            const banner = document.createElement('div');
            banner.id = 'formErrorBanner';
            banner.style.background = '#fee2e2';
            banner.style.color = '#ef4444';
            banner.style.padding = '12px';
            banner.style.borderRadius = '8px';
            banner.style.marginBottom = '20px';
            banner.style.fontWeight = '600';
            banner.style.fontSize = '14px';
            banner.style.border = '1px solid #fecaca';
            
            // Set text direction depending on page language
            if (currentLang === 'ar') {
                banner.style.direction = 'rtl';
            } else {
                banner.style.direction = 'ltr';
            }
            banner.innerText = displayMessage;
            
            form.prepend(banner);
            document.getElementById('rdvContentSection').scrollIntoView({ behavior: 'smooth' });

            // Highlight invalid fields
            if (body.errors) {
                Object.keys(body.errors).forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        input.style.borderColor = '#ef4444';
                    }
                });
            }
        }
    })
    .catch(error => {
        if (submitBtn) submitBtn.disabled = false;
        console.error('Error:', error);
        alert('Erreur de connexion. Veuillez vérifier votre connexion internet et réessayer.');
    });
}