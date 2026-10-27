<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulaire de rendez-vous - Centre Thérapeutique Privé .">
    <title>CENTRE THÉRAPEUTIQUE PRIVÉ </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@300;500;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/home.css', 'resources/css/rdv.css', 'resources/js/rdv.js'])
</head>
<body>

    <header class="container">
        {{-- LOGO + TITRE --}}
        <a href="#" class="logo-section" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">
            <img src="{{ asset('images/logos/logo1.png') }}" alt="logo" class="dynamic-logo">
            <div>
                <h1 class="fr">Centre Thérapeutique Privé </h1>
                <h1 class="ar">المركز الاستشفائي الخاص</h1>
                <h2>Expérience de +20 ans</h2>
            </div>
        </a>

        <ul class="menu">
            <li class="fr"><a href="{{ url('/') }}#accueil" class="menu-link fr">Accueil</a></li>
            <li class="ar"><a href="{{ url('/') }}#accueil" class="menu-link ar">الرئيسية</a></li>

            <li class="fr"><a href="{{ url('/') }}#services" class="menu-link fr">Services</a></li>
            <li class="ar"><a href="{{ url('/') }}#services" class="menu-link ar">الخدمات</a></li>

            <li class="fr"><a href="{{ url('/') }}#apropos" class="menu-link fr">À propos</a></li>
            <li class="ar"><a href="{{ url('/') }}#apropos" class="menu-link ar">معلومات عنا</a></li>

            <li class="fr"><a href="{{ url('/') }}#suivi-medical" class="menu-link fr">Suivi Médical</a></li>
            <li class="ar"><a href="{{ url('/') }}#suivi-medical" class="menu-link ar">المتابعة الطبية</a></li>

            <li class="fr"><a href="{{ url('/') }}#contact" class="menu-link fr">Contact</a></li>
            <li class="ar"><a href="{{ url('/') }}#contact" class="menu-link ar">اتصال</a></li>

            <li class="fr"><a href="#rdvContentSection" class="menu-link fr active">Rendez-vous</a></li>
            <li class="ar"><a href="#rdvContentSection" class="menu-link ar active">موعد</a></li>
        </ul>

        <div class="lang-switch">
            <button id="fr" onclick="setLang('fr')">FR</button>
            <button id="ar" onclick="setLang('ar')">AR</button>
        </div>

        {{-- Hamburger Menu mobile --}}
        <button class="hamburger" id="hamburgerBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    {{-- Page Banner --}}
    <div class="rdv-banner">
        <img src="{{ asset('images/img_rdv.jpg') }}" alt="Rendez-vous" class="rdv-banner-img">
        <div class="rdv-banner-overlay">
            <div class="rdv-banner-text">
                <h2 class="fr">Prendre Rendez-vous</h2>
                <h2 class="ar">حجز موعد</h2>
            </div>
        </div>
    </div>

    {{-- Main page content wrapper --}}
    <main class="rdv-page-wrapper" id="rdvContentSection">
        <div class="rdv-grid-container">
            
            <!-- LEFT COLUMN: Booking Form -->
            <div class="rdv-main-col">
                
                <!-- Main Form Card -->
                <div class="rdv-form-card" id="rdvCard">
                    <h3 class="form-section-title">
                        <span class="fr">Formulaire de demande de séance</span>
                        <span class="ar">نموذج طلب حصة علاجية</span>
                    </h3>

                    <form id="appointmentForm" onsubmit="handleFormSubmit(event)">
                        <div class="form-grid">
                            
                            {{-- Prenom --}}
                            <div class="form-group">
                                <label for="firstname">
                                    <span class="fr">Prénom</span>
                                    <span class="ar">الاسم الشخصي</span>
                                </label>
                                <input type="text" id="firstname" class="form-control" placeholder="Ex: Ahmed" required>
                            </div>

                            {{-- Nom --}}
                            <div class="form-group">
                                <label for="lastname">
                                    <span class="fr">Nom</span>
                                    <span class="ar">الاسم العائلي</span>
                                </label>
                                <input type="text" id="lastname" class="form-control" placeholder="Ex: Alaoui" required>
                            </div>

                            {{-- Age --}}
                            <div class="form-group">
                                <label for="age">
                                    <span class="fr">Âge (Ans)</span>
                                    <span class="ar">العمر (سنوات)</span>
                                </label>
                                <input type="number" id="age" class="form-control" min="0" max="120" placeholder="Ex: 35" required>
                            </div>

                            {{-- Telephone --}}
                            <div class="form-group">
                                <label for="phone">
                                    <span class="fr">N° de Téléphone</span>
                                    <span class="ar">رقم الهاتف</span>
                                </label>
                                <input type="tel" id="phone" class="form-control" placeholder="Ex: 0612349978" required>
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email">
                                    <span class="fr">Adresse E-mail</span>
                                    <span class="ar">البريد الإلكتروني</span>
                                </label>
                                <input type="email" id="email" class="form-control" placeholder="Ex: nom@exemple.com">
                            </div>

                            {{-- Genre (Extra field) --}}
                            <div class="form-group">
                                <label>
                                    <span class="fr">Genre / Sexe</span>
                                    <span class="ar">الجنس</span>
                                </label>
                                <div class="contact-radio-group" style="padding: 10px 0;">
                                    <label class="contact-radio-label">
                                        <input type="radio" name="gender" value="homme" checked>
                                        <span class="fr">Homme</span>
                                        <span class="ar">ذكر</span>
                                    </label>
                                    <label class="contact-radio-label">
                                        <input type="radio" name="gender" value="femme">
                                        <span class="fr">Femme</span>
                                        <span class="ar">أنثى</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="form-group">
                                <label for="date">
                                    <span class="fr">Date souhaitée</span>
                                    <span class="ar">التاريخ المفضل</span>
                                </label>
                                <input type="date" id="date" class="form-control" required>
                            </div>

                            {{-- Horaire --}}
                            <div class="form-group">
                                <label for="time">
                                    <span class="fr">Horaire souhaité</span>
                                    <span class="ar">التوقيت المفضل</span>
                                </label>
                                <select id="time" class="form-control" required disabled>
                                    <option value="" class="fr">Veuillez d'abord choisir une date</option>
                                    <option value="" class="ar">يرجى اختيار التاريخ أولاً</option>
                                </select>
                            </div>

                            {{-- Services ACCORDION Select (Compact, Select more than one) --}}
                            <div class="form-group full-width">
                                <label style="margin-bottom: 8px;">
                                    <span class="fr">Choix des soins (Vous pouvez sélectionner plusieurs spécialités)</span>
                                    <span class="ar">اختر العلاجات المطلوبة (يمكنك تحديد أكثر من تخصص)</span>
                                </label>
                                
                                @php
                                    $allServices = \DB::table('services')->orderBy('phase', 'asc')->orderBy('id', 'asc')->get();
                                    $phase1 = $allServices->where('phase', 1);
                                    $phase2 = $allServices->where('phase', 2);
                                    $phase3 = $allServices->where('phase', 3);
                                @endphp

                                <div class="rdv-accordion-wrapper">
                                    
                                    <!-- Accordion 1: Phase 1 -->
                                    <div class="accordion-item">
                                        <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="category-icon-svg"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                            <span class="category-title">
                                                <span class="fr">Phase 1 : Kinésithérapie &amp; Rééducation Fonctionnelle</span>
                                                <span class="ar">المرحلة 1: الترويض الطبي وإعادة التأهيل الوظيفي</span>
                                            </span>
                                            <span class="accordion-arrow">▼</span>
                                        </button>
                                        <div class="accordion-content">
                                            <div class="accordion-inner-list">
                                                @forelse($phase1 as $s)
                                                    <label class="service-checkbox-row">
                                                        <input type="checkbox" name="services[]" value="{{ $s->title_fr }}">
                                                        <span class="checkbox-text">
                                                            <span class="fr"><strong>{{ $s->title_fr }}</strong> : {{ $s->desc_fr }}</span>
                                                            <span class="ar"><strong>{{ $s->title_ar }}</strong> : {{ $s->desc_ar }}</span>
                                                        </span>
                                                    </label>
                                                @empty
                                                    <div class="text-center text-gray py-2">
                                                        <span class="fr">Aucun service disponible pour cette phase</span>
                                                        <span class="ar">لا توجد خدمات متاحة لهذه المرحلة</span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accordion 2: Phase 2 -->
                                    <div class="accordion-item">
                                        <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="category-icon-svg"><circle cx="12" cy="12" r="4"/><path d="M12 2v6"/><path d="M12 16v6"/><path d="M4.93 4.93l4.24 4.24"/><path d="M14.83 14.83l4.24 4.24"/><path d="M2 12h6"/><path d="M16 12h6"/><path d="M4.93 19.07l4.24-4.24"/><path d="M14.83 9.17l4.24-4.24"/></svg>
                                            <span class="category-title">
                                                <span class="fr">Phase 2 : Rééducation Spécialisée &amp; Maternité</span>
                                                <span class="ar">المرحلة 2: التأهيل المتخصص وصحة المرأة</span>
                                            </span>
                                            <span class="accordion-arrow">▼</span>
                                        </button>
                                        <div class="accordion-content">
                                            <div class="accordion-inner-list">
                                                @forelse($phase2 as $s)
                                                    <label class="service-checkbox-row">
                                                        <input type="checkbox" name="services[]" value="{{ $s->title_fr }}">
                                                        <span class="checkbox-text">
                                                            <span class="fr"><strong>{{ $s->title_fr }}</strong> : {{ $s->desc_fr }}</span>
                                                            <span class="ar"><strong>{{ $s->title_ar }}</strong> : {{ $s->desc_ar }}</span>
                                                        </span>
                                                    </label>
                                                @empty
                                                    <div class="text-center text-gray py-2">
                                                        <span class="fr">Aucun service disponible pour cette phase</span>
                                                        <span class="ar">لا توجد خدمات متاحة لهذه المرحلة</span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accordion 3: Phase 3 -->
                                    <div class="accordion-item">
                                        <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="category-icon-svg"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                            <span class="category-title">
                                                <span class="fr">Phase 3 : Diagnostic &amp; Suivi Thérapeutique</span>
                                                <span class="ar">المرحلة 3: التشخيص والمتابعة العلاجية</span>
                                            </span>
                                            <span class="accordion-arrow">▼</span>
                                        </button>
                                        <div class="accordion-content">
                                            <div class="accordion-inner-list">
                                                @forelse($phase3 as $s)
                                                    <label class="service-checkbox-row">
                                                        <input type="checkbox" name="services[]" value="{{ $s->title_fr }}">
                                                        <span class="checkbox-text">
                                                            <span class="fr"><strong>{{ $s->title_fr }}</strong> : {{ $s->desc_fr }}</span>
                                                            <span class="ar"><strong>{{ $s->title_ar }}</strong> : {{ $s->desc_ar }}</span>
                                                        </span>
                                                    </label>
                                                @empty
                                                    <div class="text-center text-gray py-2">
                                                        <span class="fr">Aucun service disponible pour cette phase</span>
                                                        <span class="ar">لا توجد خدمات متاحة لهذه المرحلة</span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Description / Symptomes --}}
                            <div class="form-group full-width">
                                <label for="description">
                                    <span class="fr">Description du besoin ou des symptômes</span>
                                    <span class="ar">وصف للحالة الصحية أو الأعراض التي تعانون منها</span>
                                </label>
                                <textarea id="description" class="form-control" rows="5" placeholder="Symptômes, antécédents, ordonnance..." style="resize:vertical;"></textarea>
                            </div>

                        </div>

                        <div class="submit-btn-wrapper">
                            <button type="submit" class="rdv-submit-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span class="fr">Confirmer ma demande de rendez-vous</span>
                                <span class="ar">تأكيد طلب موعدي</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Success Screen --}}
                <div class="rdv-form-card success-box" id="successBox">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="success-icon">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <h3 class="success-title">
                        <span class="fr">Demande de Rendez-vous Envoyée !</span>
                        <span class="ar">تم إرسال طلب الموعد بنجاح!</span>
                    </h3>
                    <p class="success-desc">
                        <span class="fr">Merci pour votre confiance. Notre équipe vous contactera dans les plus brefs délais par téléphone ou par WhatsApp pour valider définitivement le créneau de votre séance.</span>
                        <span class="ar">نشكركم على ثقتكم. سيتصل بكم فريقنا في أقرب وقت ممكن عبر الهاتف أو الواتساب لتأكيد موعد حصتكم العلاجية بشكل نهائي.</span>
                    </p>
                    <a href="{{ url('/') }}" class="home-btn">
                        <span class="fr">Retourner à l'accueil</span>
                        <span class="ar">العودة إلى الرئيسية</span>
                    </a>
                </div>

            </div>

            <!-- RIGHT COLUMN: Side Info Block -->
            <div class="rdv-side-col">
                
                <!-- Side Identity Card -->
                <div class="rdv-side-card">
                    <div class="sidebar-logo-row">
                        <img src="{{ asset('images/logos/logo1.png') }}" alt="logo" class="sidebar-logo-img dynamic-logo">
                        <div class="sidebar-brand-text">
                            <h3 class="fr">Centre Thérapeutique Privé</h3>
                            <h3 class="ar">المركز الاستشفائي الخاص</h3>
                            <p class="fr">Dr. Salma El Amrani</p>
                            <p class="ar">الدكتورة سلمى العمراني</p>
                        </div>
                    </div>
                    
                    <p style="font-family:'Inter', sans-serif; font-size:0.95rem; color:#4A5568; line-height:1.6; margin:0 0 20px 0; text-align:justify;">
                        <span class="fr">Votre partenaire de confiance pour une rééducation fonctionnelle et une physiothérapie de pointe.</span>
                        <span class="ar">شريككم الموثوق لإعادة التأهيل الوظيفي والعلاج الطبيعي المتقدم.</span>
                    </p>

                    <div class="sidebar-social-icons">
                        <a href="https://wa.me/212661936500" target="_blank" class="sidebar-social-icon whatsapp" title="WhatsApp">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.45L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.115-2.903-6.99-1.872-1.873-4.35-2.906-6.986-2.907-5.442 0-9.87 4.42-9.874 9.865-.001 1.638.486 3.24 1.411 4.637L1.93 21.653l4.717-1.499zm11.7-8.172c-.292-.146-1.727-.852-1.993-.949-.266-.098-.46-.146-.653.146-.193.292-.748.949-.917 1.14-.169.193-.339.215-.63.069-.292-.146-1.233-.454-2.35-1.448-.869-.775-1.456-1.733-1.626-2.025-.17-.291-.018-.45.129-.594.132-.13.292-.34.437-.51.145-.17.194-.291.291-.485.097-.194.048-.364-.024-.51-.073-.146-.653-1.573-.895-2.155-.236-.569-.476-.491-.653-.5-.17-.008-.364-.01-.557-.01-.193 0-.508.073-.774.364-.266.292-1.016.992-1.016 2.42 0 1.427 1.04 2.808 1.185 3.002.146.193 2.049 3.129 4.963 4.386.693.3 1.233.48 1.656.613.696.22 1.329.19 1.83.115.558-.083 1.727-.706 1.97-.1388.242-.68.242-1.263.17-1.36-.073-.098-.266-.146-.558-.292z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" class="sidebar-social-icon instagram" title="Instagram">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://web.facebook.com/people/" target="_blank" class="sidebar-social-icon facebook" title="Facebook">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="sidebar-social-icon linkedin" title="LinkedIn">
                            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Side Working Hours Card -->
                <div class="rdv-side-card">
                    <h4 class="side-card-title">
                        <span class="fr">Horaires de Travail</span>
                        <span class="ar">أوقات العمل</span>
                    </h4>
                    <ul class="hours-list">
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Lundi</span><span class="ar">الإثنين</span></span>
                            <span class="hours-time">09:00 - 19:00</span>
                        </li>
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Mardi</span><span class="ar">الثلاثاء</span></span>
                            <span class="hours-time">09:00 - 19:00</span>
                        </li>
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Mercredi</span><span class="ar">الأربعاء</span></span>
                            <span class="hours-time">09:00 - 19:00</span>
                        </li>
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Jeudi</span><span class="ar">الخميس</span></span>
                            <span class="hours-time">09:00 - 19:00</span>
                        </li>
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Vendredi</span><span class="ar">الجمعة</span></span>
                            <span class="hours-time">09:00 - 19:00</span>
                        </li>
                        <li class="hours-row">
                            <span class="hours-day"><span class="fr">Samedi</span><span class="ar">السبت</span></span>
                            <span class="hours-time">09:00 - 14:00</span>
                        </li>
                        <li class="hours-row closed">
                            <span class="hours-day"><span class="fr">Dimanche</span><span class="ar">الأحد</span></span>
                            <span class="hours-time"><span class="fr">Fermé</span><span class="ar">مغلق</span></span>
                        </li>
                    </ul>
                    
                    {{-- Ramadan Hours warning alert --}}
                    <div class="ramadan-alert">
                        <svg class="ramadan-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div class="ramadan-alert-text">
                            <span class="fr"><strong>Ramadan :</strong> Horaires d\'ouverture adaptés de <strong>09:00 à 17:00</strong>.</span>
                            <span class="ar"><strong>رمضان :</strong> تعديل أوقات العمل لتصبح من <strong>09:00 إلى 17:00</strong>.</span>
                        </div>
                    </div>
                </div>

                <!-- Recontact Notification Box -->
                <div class="notice-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="notice-icon-svg">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <div class="notice-text">
                        <span class="fr"><strong>Note :</strong> Notre équipe va vous recontacter le plus tôt possible, soit par <strong>téléphone</strong> ou directement sur <strong>WhatsApp</strong> pour finaliser la date et l'horaire exact de votre séance.</span>
                        <span class="ar"><strong>تنبيه :</strong> سيتصل بكم فريقنا الطبي في أقرب وقت ممكن، إما عبر <strong>الهاتف</strong> أو مباشرة على <strong>الواتساب</strong> لتأكيد وتنسيق الوقت والتاريخ الدقيق لحصتكم.</span>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- SITE FOOTER --}}
    <footer class="site-footer">
        <div class="footer-container">
            <!-- Brand / Intro Column -->
            <div class="footer-column brand-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/logos/logo1.png') }}" alt="logo" class="footer-logo-img dynamic-logo">
                    <div class="footer-brand-text">
                        <h3 class="fr">Centre Thérapeutique Privé</h3>
                        <h3 class="ar">المركز الاستشفائي الخاص</h3>
                        <p class="fr">Dr. Salma El Amrani</p>
                        <p class="ar">الدكتورة سلمى العمراني</p>
                    </div>
                </div>
                <p class="footer-desc fr">Votre partenaire de confiance pour la kinésithérapie, la physiothérapie et la rééducation fonctionnelle de pointe.</p>
                <p class="footer-desc ar">شريككم الموثوق للترويض الطبي، العلاج الطبيعي وإعادة التأهيل الفيزيائي بأحدث التقنيات.</p>
                
                <div class="footer-social-icons">
                    <!-- WhatsApp -->
                    <a href="https://wa.me/212661936500" target="_blank" class="footer-social-icon whatsapp" title="WhatsApp">
                        <svg viewBox="0 0 24 24" class="footer-svg">
                            <path fill="currentColor" d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.45L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.115-2.903-6.99-1.872-1.873-4.35-2.906-6.986-2.907-5.442 0-9.87 4.42-9.874 9.865-.001 1.638.486 3.24 1.411 4.637L1.93 21.653l4.717-1.499zm11.7-8.172c-.292-.146-1.727-.852-1.993-.949-.266-.098-.46-.146-.653.146-.193.292-.748.949-.917 1.14-.169.193-.339.215-.63.069-.292-.146-1.233-.454-2.35-1.448-.869-.775-1.456-1.733-1.626-2.025-.17-.291-.018-.45.129-.594.132-.13.292-.34.437-.51.145-.17.194-.291.291-.485.097-.194.048-.364-.024-.51-.073-.146-.653-1.573-.895-2.155-.236-.569-.476-.491-.653-.5-.17-.008-.364-.01-.557-.01-.193 0-.508.073-.774.364-.266.292-1.016.992-1.016 2.42 0 1.427 1.04 2.808 1.185 3.002.146.193 2.049 3.129 4.963 4.386.693.3 1.233.48 1.656.613.696.22 1.329.19 1.83.115.558-.083 1.727-.706 1.97-.1388.242-.68.242-1.263.17-1.36-.073-.098-.266-.146-.558-.292z"/>
                        </svg>
                    </a>
                    
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/" target="_blank" class="footer-social-icon instagram" title="Instagram">
                        <svg viewBox="0 0 24 24" class="footer-svg">
                            <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    
                    <!-- Facebook -->
                    <a href="https://web.facebook.com/people" target="_blank" class="footer-social-icon facebook" title="Facebook">
                        <svg viewBox="0 0 24 24" class="footer-svg">
                            <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/in" target="_blank" class="footer-social-icon linkedin" title="LinkedIn">
                        <svg viewBox="0 0 24 24" class="footer-svg">
                            <path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Services Links Column -->
            <div class="footer-column links-col">
                <h4 class="fr">Nos Services</h4>
                <h4 class="ar">خدماتنا</h4>
                
                <p class="footer-links-intro fr">Notre centre propose une prise en charge de pointe structurée autour de spécialités médicales et thérapeutiques majeures :</p>
                <p class="footer-links-intro ar">يقدم مركزنا رعاية طبية متكاملة ومتقدمة تتمحور حول التخصصات العلاجية الأساسية التالية :</p>
                
                <ul class="footer-links">
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Neurologie &amp; Neuropédiatrie</span>
                            <span class="ar">ترويض الجهاز العصبي للأطفال والكبار</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Rééducation Respiratoire</span>
                            <span class="ar">ترويض أمراض الجهاز التنفسي</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Orthopédie &amp; Traumatologie</span>
                            <span class="ar">ترويض العظام وتأهيل الكسور والمفاصل</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Rhumatologie &amp; Colonne Vertébrale</span>
                            <span class="ar">علاج الروماتيزم وآلام الظهر والرقبة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Physiothérapie &amp; Laser Avancé</span>
                            <span class="ar">العلاج الفيزيائي الحديث والكهربائي</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Balnéothérapie &amp; Hydrothérapie</span>
                            <span class="ar">العلاج المائي والجاكوزي الطبي الدافئ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Uro-Gynécologie &amp; Post-partum</span>
                            <span class="ar">تأهيل الحوض والنساء قبل وبعد الولادة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Réhabilitation Sportive &amp; Coaching</span>
                            <span class="ar">الترويض الرياضي وإعادة تأهيل الرياضيين</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Massage Médical, Hijama &amp; Bien-être</span>
                            <span class="ar">التدليك الطبي، الحجامة الطبية والاسترخاء</span>
                        </a>
                    </li>
                    
                    <!-- Link to view all detailed services -->
                    <li style="grid-column: 1 / -1; margin-top: 5px;">
                        <a href="{{ url('/') }}#services" class="view-all-services-btn">
                            <span class="fr">Voir tous nos services et spécialités détaillés →</span>
                            <span class="ar">عرض جميع خدماتنا وتخصصاتنا التفصيلية ←</span>
                        </a>
                    </li>
                    
                    <!-- Highlight Badge spans full width of the grid -->
                    <div class="footer-highlight-badge" style="margin-top: 15px;">
                        <svg class="badge-icon-svg" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                        <span class="fr">Reconnu pour notre professionnalisme et notre expertise en Amérique, en Europe et dans les pays du Golfe Arabe</span>
                        <span class="ar">مشهود لنا بالحرفية والخبرة من أمريكا وأوروبا ودول الخليج العربي</span>
                    </div>
                </ul>
            </div>
            
            <!-- Contact Info Column -->
            <div class="footer-column contact-col">
                <h4 class="fr">Contact</h4>
                <h4 class="ar">اتصل بنا</h4>
                <ul class="footer-contact-info">
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg class="footer-contact-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="footer-contact-text">
                            <span class="fr">36, Av Mohammed V, en face de Papetrie Al-Hazzaz, près d'Auderby, à côté du Paramarket et de l'agence de voyage Riad. 2ème étg, N° 3. Fès.</span>
                            <span class="ar">36، شارع محمد الخامس، مقابل مطبعة الهزاز، بالقرب من أودربي، بجوار باراماركت. ووكالة الأسفار رياض، الطابق 2، رقم 3. فاس.</span>
                        </div>
                    </li>
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg class="footer-contact-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="footer-contact-text">
                            <span><a href="tel:0654389090">0654389090</a> / <a href="tel:0617625009">0617625009</a></span>
                        </div>
                    </li>
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg class="footer-contact-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="footer-contact-text">
                            <span><a href="mailto:therapeutiquecentre@gmail.com">therapeutiquecentre@gmail.com</a></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Footer Bottom Copyright Bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <p class="fr">&copy; 2026 Centre Thérapeutique Privé . Tous droits réservés.</p>
                <p class="ar">&copy; 2026 المركز الاستشفائي الخاص . جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

</body>
</html>