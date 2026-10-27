<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Détails du service - Centre Thérapeutique Privé Lalla Zahrae Ouadghiri.">
    <title>{{ $service->title_fr }} | CENTRE THÉRAPEUTIQUE</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@300;500;700;800&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    @vite(['resources/css/home.css', 'resources/css/rdv.css'])
    
    <style>
        .detail-container {
            max-width: 100%;
            margin: 90px 0 0 0;
            padding: 0;
        }
        .detail-section-row {
            display: flex;
            align-items: stretch;
            min-height: 480px;
            width: 100%;
        }
        .detail-section-col-img {
            width: 50%;
            position: relative;
        }
        .detail-section-col-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .detail-section-col-text {
            width: 50%;
            padding: 80px 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-sizing: border-box;
        }
        .detail-section-col-text h2 {
            color: #2c6e8a;
            font-family: 'Playfair Display', 'Georgia', serif;
            font-size: 2.3rem;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .detail-section-col-text p, .desc-rich-content, .desc-rich-content p, .desc-rich-content li {
            color: #2d3748;
            font-size: 1.15rem;
            line-height: 1.9;
        }
        .desc-rich-content ul, .desc-rich-content ol {
            padding-left: 20px;
            margin: 10px 0;
        }
        
        /* Language alignment */
        body[dir="rtl"] .detail-section-col-text {
            text-align: right;
        }
        
        .rdv-hero {
            position: relative;
            background-size: cover;
            background-position: center;
            height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .rdv-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55));
            z-index: 1;
        }
        .rdv-hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 800px;
        }
        .rdv-hero-content h1 {
            color: #ffffff;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            margin-top: 0;
        }
        .rdv-hero-content p {
            color: #1ABC9C;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        
        .cta-banner {
            background: linear-gradient(135deg, #1a2a4a 0%, #6b1a1a 100%);
            padding: 80px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            width: 100%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        .cta-banner-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1ABC9C;
            color: #ffffff;
            font-weight: 600;
            padding: 16px 48px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.15rem;
            border: 2px solid transparent;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(26, 188, 156, 0.4);
            letter-spacing: 0.5px;
        }
        .cta-btn:hover {
            background: #16a085;
            border-color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(26, 188, 156, 0.6);
            color: white;
        }
        
        html, body {
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #ffffff;
            color: #2d3748;
        }

        @media (max-width: 992px) {
            .detail-section-row {
                flex-direction: column !important;
            }
            .detail-section-col-img, .detail-section-col-text {
                width: 100% !important;
            }
            .detail-section-col-text {
                padding: 50px 30px !important;
            }
            .detail-section-col-img {
                height: 350px !important;
            }
            .rdv-hero-content h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

    <header class="container">
        {{-- LOGO + TITRE --}}
        <a href="{{ url('/') }}" class="logo-section">
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="dynamic-logo">
            <div>
                <h1 class="fr">Centre Thérapeutique Privé Lalla Zahrae Ouadghiri</h1>
                <h1 class="ar">المركز الاستشفائي الخاص للازهراء ودغيري </h1>
                <h2>LALLA ZAHRAE OUADGHIRI</h2>
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

            <li class="fr"><a href="{{ url('/rdv') }}" class="menu-link fr">Rendez-vous</a></li>
            <li class="ar"><a href="{{ url('/rdv') }}" class="menu-link ar">موعد</a></li>
        </ul>

        <div class="lang-switch">
            <button id="fr" onclick="setLang('fr')">FR</button>
            <button id="ar" onclick="setLang('ar')">AR</button>
        </div>
    </header>

    {{-- Main content --}}
    <main class="detail-container">
        @php
            // Parse content_fr
            $contentFr = null;
            if (!empty($service->content_fr)) {
                $contentFr = json_decode($service->content_fr, true);
                if (json_last_error() !== JSON_ERROR_NONE || !isset($contentFr['blocks'])) {
                    $contentFr = [
                        'hero_title' => $service->title_fr,
                        'show_rdv_btn' => true,
                        'blocks' => [
                            ['title_fr' => 'Nos installations', 'desc_fr' => $service->content_fr]
                        ]
                    ];
                }
            } else {
                $contentFr = [
                    'hero_title' => $service->title_fr,
                    'show_rdv_btn' => true,
                    'blocks' => [
                        ['title_fr' => 'Nos installations', 'desc_fr' => 'Le contenu détaillé de ce service est en cours de rédaction.']
                    ]
                ];
            }

            // Parse content_ar
            $contentAr = null;
            if (!empty($service->content_ar)) {
                $contentAr = json_decode($service->content_ar, true);
                if (json_last_error() !== JSON_ERROR_NONE || !isset($contentAr['blocks'])) {
                    $contentAr = [
                        'hero_title' => $service->title_ar,
                        'show_rdv_btn' => true,
                        'blocks' => [
                            ['title_ar' => 'منشآتنا', 'desc_ar' => $service->content_ar]
                        ]
                    ];
                }
            } else {
                $contentAr = [
                    'hero_title' => $service->title_ar,
                    'show_rdv_btn' => true,
                    'blocks' => [
                        ['title_ar' => 'منشآتنا', 'desc_ar' => 'محتوى هذه الصفحة قيد الكتابة حالياً.']
                    ]
                ];
            }

            // Parse images
            $images = is_string($service->additional_images) ? json_decode($service->additional_images, true) : $service->additional_images;
            if (!is_array($images) && !is_object($images)) {
                $images = [];
            }
            $images = (array) $images;
            
            $heroImage = !empty($images['hero']) ? $images['hero'] : null;
            $blockImages = !empty($images['blocks']) ? $images['blocks'] : [];

            $frBlocks = $contentFr['blocks'] ?? [];
            $arBlocks = $contentAr['blocks'] ?? [];
            $showRdvBtn = ($contentFr['show_rdv_btn'] ?? true);
        @endphp

        <!-- 1. Header Hero Banner (Card Image as background or custom hero) -->
        @php
            $heroBg = $heroImage ? asset('images/services/details/' . $heroImage) : asset('images/services/' . $service->image);
        @endphp
        <div class="rdv-hero" style="background-image: url('{{ $heroBg }}');">
            <div class="rdv-hero-overlay"></div>
            <div class="rdv-hero-content">
                <h1 class="fr">{{ $contentFr['hero_title'] ?? $service->title_fr }}</h1>
                <h1 class="ar">{{ $contentAr['hero_title'] ?? $service->title_ar }}</h1>
                <p class="fr">Présentation et détails de notre spécialité</p>
                <p class="ar">عرض وتفاصيل تخصصنا الطبي</p>
            </div>
        </div>

        <!-- 2. Loop over blocks -->
        @php
            $maxBlocks = max(count($frBlocks), count($arBlocks));
        @endphp
        @for($i = 0; $i < $maxBlocks; $i++)
            @php
                $fb = $frBlocks[$i] ?? [];
                $ab = $arBlocks[$i] ?? [];
                $bImg = $blockImages[$i] ?? null;
                $isOdd = ($i % 2 === 0);
            @endphp
            <div class="detail-section-row" style="background: {{ $isOdd ? '#ffffff' : '#f8f9fa' }}; flex-direction: {{ $isOdd ? 'row' : 'row-reverse' }};">
                <!-- Image Column -->
                <div class="detail-section-col-img">
                    @if(!empty($bImg))
                        <img src="{{ asset('images/services/details/' . $bImg) }}" alt="Illustration">
                    @else
                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: rgba(0,0,0,0.03); min-height: 480px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Default" style="width: 150px; height: 150px; object-fit: contain;">
                        </div>
                    @endif
                </div>
                <!-- Text Column -->
                <div class="detail-section-col-text">
                    <h2>
                        <span class="fr">{{ $fb['title_fr'] ?? $fb['title'] ?? '' }}</span>
                        <span class="ar">{{ $ab['title_ar'] ?? $ab['title'] ?? '' }}</span>
                    </h2>
                    <div class="fr desc-rich-content">
                        {!! $fb['desc_fr'] ?? $fb['desc'] ?? '' !!}
                    </div>
                    <div class="ar desc-rich-content">
                        {!! $ab['desc_ar'] ?? $ab['desc'] ?? '' !!}
                    </div>
                </div>
            </div>
        @endfor

        <!-- 3. CTA Banner: Take Appointment Button -->
        @if($showRdvBtn)
            <div class="cta-banner">
                <div class="cta-banner-content">
                    <h3 class="fr" style="color: #ffffff; font-size: 2.2rem; font-weight: 700; margin-bottom: 15px; font-family: 'Poppins', sans-serif;">Prêt à commencer votre traitement ?</h3>
                    <h3 class="ar" style="color: #ffffff; font-size: 2.2rem; font-weight: 700; margin-bottom: 15px; font-family: 'Cairo', sans-serif; margin-top: 0;">هل أنت جاهز لبدء علاجك؟</h3>
                    
                    <p class="fr" style="color: #cbd5e1; font-size: 1.15rem; margin-bottom: 30px; line-height: 1.6;">Prenez rendez-vous dès aujourd'hui et laissez notre équipe d'experts vous accompagner vers un rétablissement complet.</p>
                    <p class="ar" style="color: #cbd5e1; font-size: 1.15rem; margin-bottom: 30px; line-height: 1.6;">احجز موعدك اليوم ودع فريقنا من الخبراء يرافقك نحو الشفاء التام والتعافي الحركي.</p>
                    
                    <a href="{{ url('/rdv') }}" class="cta-btn">
                        <span class="fr">Prendre Rendez-vous</span>
                        <span class="ar">احجز موعدك الآن</span>
                    </a>
                </div>
            </div>
        @endif
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <!-- Brand / Intro Column -->
            <div class="footer-column brand-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="footer-logo-img dynamic-logo">
                    <div class="footer-brand-text">
                        <h3 class="fr">Centre Thérapeutique</h3>
                        <h3 class="ar">المركز الاستشفائي الخاص</h3>
                        <p class="fr">LALLA ZAHRAE OUADGHIRI</p>
                        <p class="ar">للازهراء ودغيري</p>
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
                    <a href="https://web.facebook.com/people/Centre-Th%C4%97rapeutique-Priv%C4%97-Lalla-Zahrae/100063763982070/" target="_blank" class="footer-social-icon facebook" title="Facebook">
                        <svg viewBox="0 0 24 24" class="footer-svg">
                            <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/in/centre-th%C3%A9rapeutique-lalla-zahrae-ouadghiri-a24a30419/" target="_blank" class="footer-social-icon linkedin" title="LinkedIn">
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
                            <span class="fr">Neurologie & Neuropédiatrie</span>
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
                            <span class="fr">Orthopédie & Traumatologie</span>
                            <span class="ar">ترويض العظام وتأهيل الكسور والمفاصل</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Rhumatologie & Colonne Vertébrale</span>
                            <span class="ar">علاج الروماتيزم وآلام الظهر والرقبة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Physiothérapie & Laser Avancé</span>
                            <span class="ar">العلاج الفيزيائي الحديث والكهربائي</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Balnéothérapie & Hydrothérapie</span>
                            <span class="ar">العلاج المائي والجاكوزي الطبي الدافئ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Uro-Gynécologie & Post-partum</span>
                            <span class="ar">تأهيل الحوض والنساء قبل وبعد الولادة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#services" class="footer-service-item">
                            <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            <span class="fr">Réhabilitation Sportive & Coaching</span>
                            <span class="ar">الترويض الرياضي وإعادة تأهيل الرياضيين</span>
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
                            <span><a href="tel:0535941808">0535 94 18 08</a> / <a href="tel:0661936500">0661 93 65 00</a></span>
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
                <p class="fr">&copy; 2026 Centre Thérapeutique Privé Lalla Zahrae Ouadghiri. Tous droits réservés.</p>
                <p class="ar">&copy; 2026 المركز الاستشفائي الخاص للازهراء ودغيري. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script>
        // Language Toggle logic
        function setLang(lang) {
            localStorage.setItem('lang', lang);
            applyLang(lang);
        }

        function applyLang(lang) {
            document.querySelectorAll('.fr').forEach(el => el.style.display = lang === 'fr' ? 'block' : 'none');
            document.querySelectorAll('.ar').forEach(el => el.style.display = lang === 'ar' ? 'block' : 'none');
            
            // Toggle active classes on buttons
            document.querySelectorAll('.lang-switch button').forEach(btn => {
                if (btn.id === lang) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Adjust document direction for Arabic
            if (lang === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
                document.documentElement.setAttribute('lang', 'ar');
            } else {
                document.documentElement.setAttribute('dir', 'ltr');
                document.documentElement.setAttribute('lang', 'fr');
            }
        }

        // Initialize language
        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('lang') || 'fr';
            applyLang(savedLang);
        });
    </script>
    @vite('resources/js/app.js')
</body>
</html>
