<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Centre spécialisé en kinésithérapie, rééducation physique et thérapies multidisciplinaires. Reconnu par des experts d'Amérique, d'Europe et du Golfe arabe.">
    <meta name="keywords"
        content="kinésithérapie, rééducation, centre médical, thérapie physique, santé, physiothérapie, Maroc, Fès, soins médicaux, rééducation sportive">
    <title>CENTRE THÉRAPEUTIQUE PRIVÉ </title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;500;700;800&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    {{-- Lien vers le CSS situé dans resources/css/home.css via Vite --}}
    @vite('resources/css/home.css')
</head>

<body>

    <header class="container">

        {{-- LOGO + TITRE --}}
        <a href="#accueil" class="logo-section">
            <img src="{{ asset('images/logos/logo1.png') }}" alt="logo" class="dynamic-logo">
            <div>
                <h1 class="fr">Centre Thérapeutique Privé</h1>
                <h1 class="ar">المركز الاستشفائي الخاص </h1>
                <h2 id="Exp">Expérience de +20 ans</h2>
            </div>
        </a>

        <ul class="menu">
            <li class="fr"><a href="#accueil" class="menu-link fr">Accueil</a></li>
            <li class="ar"><a href="#accueil" class="menu-link ar">الرئيسية</a></li>

            <li class="fr"><a href="#services" class="menu-link fr">Services</a></li>
            <li class="ar"><a href="#services" class="menu-link ar">الخدمات</a></li>

            <li class="fr"><a href="#apropos" class="menu-link fr">À propos</a></li>
            <li class="ar"><a href="#apropos" class="menu-link ar">معلومات عنا</a></li>

            <li class="fr"><a href="#suivi-medical" class="menu-link fr">Suivi Médical</a></li>
            <li class="ar"><a href="#suivi-medical" class="menu-link ar">المتابعة الطبية</a></li>

            <li class="fr"><a href="#contact" class="menu-link fr">Contact</a></li>
            <li class="ar"><a href="#contact" class="menu-link ar">اتصال</a></li>

            <li class="fr"><a href="{{ url('/rdv') }}" class="menu-link fr">Rendez-vous</a></li>
            <li class="ar"><a href="{{ url('/rdv') }}" class="menu-link ar">موعد</a></li>
        </ul>

        <div class="lang-switch">
            <button id="fr" onclick="setLang('fr')">FR</button>
            <button id="ar" onclick="setLang('ar')">AR</button>
        </div>

        {{-- Bouton hamburger pour mobile (présent dans le CSS, ajouté ici pour compatibilité) --}}
        <button class="hamburger" id="hamburgerBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <section id="accueil">
        <div id="anim">

            <div class="image1">
                <img class="massage" src="{{ asset('images/image1.png') }}" alt="service de santé">
            </div>

            <div class="txt">
                <div class="hero-badge">
                    <span class="fr">Excellence Thérapeutique</span>
                    <span class="ar">التميز العلاجي</span>
                </div>

                <h1 class="hero-title">
                    <span class="fr">Votre santé,<br>notre <span class="highlight">priorité absolue</span></span>
                    <span class="ar">صحتكم<br>هي <span class="highlight">أولويتنا القصوى</span></span>
                </h1>

                <p class="hero-subtitle">
                    <span class="fr">Centre spécialisé en kinésithérapie, rééducation physique et thérapies
                        multidisciplinaires. Reconnu par des experts d'Amérique, d'Europe et du Golfe arabe.</span>
                    <span class="ar">مركز متخصص في الترويض الطبي وإعادة التأهيل الفيزيائي والعلاجات متعددة التخصصات.
                        مشهود لنا بالكفاءة من أمريكا وأوروبا ودول الخليج العربي.</span>
                </p>

                <div class="hero-btns">
                    <a href="/rdv" class="btn-primary">
                        <img class="btn-agenda-icon" src="{{ asset('images/agenda.png') }}" alt="rendez-vous">
                        <span class="fr">Prendre rendez-vous</span>
                        <span class="ar">احجز موعدك</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section id="services">
        @php
            $allDbServices = \DB::table('services')->orderBy('phase', 'asc')->orderBy('id', 'asc')->get()->map(function($item) {
                return (array) $item;
            })->toArray();
        @endphp
        <div class="tout_services">
            <h2 class="section-title">
                <span class="fr">Nos Services de Rééducation et de Thérapie Avancée</span>
                <span class="ar">خدماتنا في الترويض الطبي والعلاج الفيزيائي المتقدم</span>
            </h2>
            <p class="section-subtitle fr">Une prise en charge multidisciplinaire complète utilisant les technologies médicales les plus avancées en rééducation et physiothérapie.</p>
            <p class="section-subtitle ar">رعاية طبية شاملة متعددة التخصصات بأحدث التقنيات العالمية في الترويض الطبي والعلاج الفيزيائي.</p>
        </div>

        <!-- PHASE 1 : RÉÉDUCATION & PATHOLOGIES MÉDICALES -->
        <div class="services-carousel-section">
            <div class="carousel-wrapper">
                <button class="carousel-arrow prev" aria-label="Précédent">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="marquee-container">
                    <div class="marquee-track phase-1-track">
                    @php
                        $phase1_services = array_filter($allDbServices, function($s) { return $s['phase'] == 1; });
                    @endphp

                    {{-- Loop Sets A, B, C, D (4 copies for seamless loop) --}}
                    @for($loopCopy = 0; $loopCopy < 4; $loopCopy++)
                        @foreach($phase1_services as $svc)
                            <div class="service-card-new">
                                <div class="card-banner-wrapper">
                                    <img src="{{ asset('images/services/' . $svc['image']) }}" alt="{{ $svc['title_fr'] }}" class="card-banner-img">
                                </div>
                                <div class="card-content-new">
                                    <h4 class="card-title">
                                        <span class="fr">{{ $svc['title_fr'] }}</span>
                                        <span class="ar">{{ $svc['title_ar'] }}</span>
                                    </h4>
                                    <p class="card-desc">
                                        <span class="fr">{{ $svc['desc_fr'] }}</span>
                                        <span class="ar">{{ $svc['desc_ar'] }}</span>
                                    </p>
                                    <a href="{{ route('services.show', $svc['id']) }}" class="card-btn">
                                        <span class="fr">En savoir plus</span>
                                        <span class="ar">عرض المزيد</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
            <button class="carousel-arrow next" aria-label="Suivant">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
        </div>

        <!-- PHASE 2 : TECHNIQUES THÉRAPEUTIQUES AVANCÉES -->
        <div class="services-carousel-section">
            <div class="carousel-wrapper">
                <button class="carousel-arrow prev" aria-label="Précédent">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="marquee-container">
                    <div class="marquee-track phase-2-track">
                    @php
                        $phase2_services = array_filter($allDbServices, function($s) { return $s['phase'] == 2; });
                    @endphp

                    {{-- Loop Sets A, B, C, D (4 copies for seamless loop) --}}
                    @for($loopCopy = 0; $loopCopy < 4; $loopCopy++)
                        @foreach($phase2_services as $svc)
                            <div class="service-card-new">
                                <div class="card-banner-wrapper">
                                    <img src="{{ asset('images/services/' . $svc['image']) }}" alt="{{ $svc['title_fr'] }}" class="card-banner-img">
                                </div>
                                <div class="card-content-new">
                                    <h4 class="card-title">
                                        <span class="fr">{{ $svc['title_fr'] }}</span>
                                        <span class="ar">{{ $svc['title_ar'] }}</span>
                                    </h4>
                                    <p class="card-desc">
                                        <span class="fr">{{ $svc['desc_fr'] }}</span>
                                        <span class="ar">{{ $svc['desc_ar'] }}</span>
                                    </p>
                                    <a href="{{ route('services.show', $svc['id']) }}" class="card-btn">
                                        <span class="fr">En savoir plus</span>
                                        <span class="ar">عرض المزيد</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
            <button class="carousel-arrow next" aria-label="Suivant">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
        </div>

        <!-- PHASE 3 : BIEN-ÊTRE, SPORT & RÉHABILITATION AVANCÉE -->
        <div class="services-carousel-section">
            <div class="carousel-wrapper">
                <button class="carousel-arrow prev" aria-label="Précédent">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="marquee-container">
                    <div class="marquee-track phase-3-track">
                    @php
                        $phase3_services = array_filter($allDbServices, function($s) { return $s['phase'] == 3; });
                    @endphp

                    {{-- Loop Sets A, B, C, D (4 copies for seamless loop) --}}
                    @for($loopCopy = 0; $loopCopy < 4; $loopCopy++)
                        @foreach($phase3_services as $svc)
                            <div class="service-card-new">
                                <div class="card-banner-wrapper">
                                    <img src="{{ asset('images/services/' . $svc['image']) }}" alt="{{ $svc['title_fr'] }}" class="card-banner-img">
                                </div>
                                <div class="card-content-new">
                                    <h4 class="card-title">
                                        <span class="fr">{{ $svc['title_fr'] }}</span>
                                        <span class="ar">{{ $svc['title_ar'] }}</span>
                                    </h4>
                                    <p class="card-desc">
                                        <span class="fr">{{ $svc['desc_fr'] }}</span>
                                        <span class="ar">{{ $svc['desc_ar'] }}</span>
                                    </p>
                                    <a href="{{ route('services.show', $svc['id']) }}" class="card-btn">
                                        <span class="fr">En savoir plus</span>
                                        <span class="ar">عرض المزيد</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
            <button class="carousel-arrow next" aria-label="Suivant">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
        </div>
    </section>

<section id="apropos" style="background-image: url('{{ asset('images/aproposimg.jpg') }}');">
    <div class="about-container">
        
        <div class="about-grid">
            <!-- Colonne Gauche (70%) : Contenu Textuel Structuré -->
            <div class="about-left-col">
                <h2 class="about-section-title">
                    <span class="fr">À Propos de Moi</span>
                    <span class="ar">نبذة عني</span>
                </h2>
                
                <!-- Bloc 1: Introduction -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Introduction</span>
                        <span class="ar">مقدمة</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p class="about-lead">Je suis <strong>Dr. Salma El Amrani</strong>, Spécialiste en Réhabilitation physique, Masso-Kinésithérapie et Ostéopathie. Depuis plus de 20 ans, je consacre ma carrière à l'accompagnement des personnes souffrant de douleurs, d'handicaps, de limitations fonctionnelles ou à la recherche d'un mieux-être physique durable.</p>
                        </div>
                        <div class="ar">
                            <p class="about-lead">أنا <strong>الدكتورة سلمى العمراني</strong>، أخصائية في إعادة التأهيل الفيزيائي والبدني، والعلاج الطبيعي اليدوي، والتدليك الطبي العلاجي، وتقنيات تقويم العظام (الأوستيوباثي).</p>
                            <p class="about-lead">على مدى أكثر من عشرين عاماً، كرّست مسيرتي المهنية لخدمة المرضى الذين يعانون من الآلام الجسدية، والإعاقات، والاضطرابات الوظيفية، واضطرابات الحركة، واضعةً خبرتي ومعرفتي في خدمة تحسين صحتهم الجسدية والنفسية ومساعدتهم على استعادة استقلاليتهم وجودة حياتهم بشكل مستدام.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloc 2: Parcours académique -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Parcours Académique</span>
                        <span class="ar">التكوين الأكاديمي</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Formée au sein d'une Académie de Médecine et de la culture Physique à l'étranger, en Uk, j'ai reçu le diplôme rouge récompensant les excellents élèves, étant major de ma promotion. J'ai eu la chance d'être formée par des professeurs et scientifiques brillants venus du monde entier, notamment d'Allemagne, de France, de Belgique, d'Italie, d'Espagne, de Russie, d'Israël, du Japon et de Thaïlande. J'ai développé une expertise approfondie et reconnue dans les domaines de la rééducation / réhabilitation physique, les thérapies manuelles et les soins naturels.</p>
                        </div>
                        <div class="ar">
                            <p>تلقيت تكويني الأكاديمي المتخصص بإحدى أكاديميات الطب والثقافة البدنية بأوروبا، حيث حصلت على الدبلوم الأحمر المخصص للطلبة المتفوقين، وتخرجت الأولى على مستوى دفعتي. كما حظيت بفرصة التكوين على يد نخبة من الأساتذة والخبراء الدوليين علماء وعباقرة في مجالات الطب وإعادة التأهيل والعلاج الطبيعي، القادمين من ألمانيا وفرنسا وبلجيكا وإيطاليا وإسبانيا وروسيا واليابان وتايلاند ودول أخرى، الأمر الذي مكّنني من اكتساب تكوين علمي رفيع وخبرة مهنية واسعة في مجالات إعادة التأهيل الفيزيائي والبدني، والترويض الطبي، والعلاجات اليدوية المتقدمة، والتدليك الطبي العلاجي، ومختلف أساليب العلاج الطبيعي والطب التكميلي.</p>
                        </div>
                    </div>
                </div>
                <!-- Bloc 3: Expérience professionnelle -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Expérience Professionnelle</span>
                        <span class="ar">الخبرة المهنية</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Mon parcours professionnel m'a permis d'exercer à l'hôpital militaire à Kharkiv, en tant que Kiné-assistante au Service des urgences, des amputés, des brûlures et des traumatismes. J'ai également participé à des stages hospitaliers multidisciplinaires en physiothérapie, rééducation spécialisée, techniques de massage thérapeutique médical, ventouses thérapeutiques, thérapies manuelles et acupuncture.</p>
                            <p>Au Maroc, j'ai exercé une année à l'Hôpital El Ghassani, puis pendant deux années au CHU, avant de créer et de développer mon propre Centre Thérapeutique de Rééducation <strong>"Centre Thérapeutique Privé Dr. Salma El Amrani"</strong> où j'exerce depuis plus de 17 ans.</p>
                        </div>
                        <div class="ar">
                            <p>خلال مسيرتي المهنية، عملت بالمستشفى العسكري بمدينة خاركيف في أقسام المستعجلات والحروق الحوادث ومبتوري الأطراف، حيث شاركت في برامج إعادة التأهيل الوظيفي واستعادة التوازن الحركي وتحسين القدرات الوظيفية للمرضى. كما استفدت من تدريبات استشفائية متعددة التخصصات شملت العلاج الطبيعي المائي، وإعادة التأهيل الوظيفي لذوي الاحتياجات الخاصة، والتدليك العلاجي، والعلاج بالحجامة، والوخز بالإبر، والعلاجات اليدوية المتميزة المتخصصة.</p>
                            <p>وبعد عودتي إلى المغرب، عملت بالمستشفى الجهوي الغساني بمدينة فاس، ثم بالمركز الاستشفائي الجامعي، قبل أن أؤسس "مركزي العلاجي الخاص الدكتورة سلمى العمراني" الذي يشكل اليوم ثمرة سنوات طويلة من الخبرة والتفاني والوفاء لمرضاي، والذي أزاول فيه مهنتي منذ أكثر من 17 سنة.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloc 4: Philosophie de travail -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Philosophie de Travail</span>
                        <span class="ar">فلسفتي في العمل</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Ma philosophie de travail repose sur une approche globale et personnalisée du patient. Je privilégie les méthodes naturelles, non invasives et respectueuses du corps, conformes aux normes de l'OMS et aux lois de la profession de physiothérapeute. Contrairement aux approches chirurgicales, je m'attache à proposer des solutions thérapeutiques basées sur la rééducation physique, l'ostéopathie, la masso-kinésithérapie et d'autres techniques complémentaires visant à soulager les douleurs, restaurer la mobilité et favoriser la guérison naturelle de l'organisme.</p>
                            <p><p>Polyglotte : Arabe, Français, Anglais et Russe.</p></p>
                        </div>
                        <div class="ar">
                            <p>أؤمن بأن كل مريض حالة فريدة تستحق الإنصات الجيد والتشخيص الدقيق والمتابعة المستمرة، والعمل الدؤوب والصبر، لذلك أعتمد مقاربة شمولية ومتكاملة تراعي خصوصية كل حالة واحتياجاتها الصحية.</p>
                            <p>وترتكز فلسفتي العلاجية على توظيف الأساليب الطبيعية والآمنة التي تحترم توازن الجسم وقدرته الذاتية على التعافي، وكذا معايير منظمة الصحة العالمية وقوانين المهنة الشريفة التي أمتهنها والتي أدينا عليها القسم أمام الله، مع السعي إلى تجنب مرضاي للتدخلات الجراحية كلما كان ذلك ممكناً.</p>
                            <p>متعددة اللغات : العربية والفرنسية والإنجليزية والروسية.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloc 5: Soins et accompagnement -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Soins et Accompagnement</span>
                        <span class="ar">رعاية إنسانية وعلاج مريح</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Dans mon Centre, nous accordons une importance particulière au confort du patient. Nos soins sont conçus pour être les plus doux possible, en privilégiant des méthodes naturelles et adaptées à chaque situation (enfants, adultes, seniors), avec pour objectif d'obtenir des résultats efficaces sans douleur et sans recours à la chirurgie lorsque cela est possible.</p>
                        </div>
                        <div class="ar">
                            <p>داخل المركز، نولي أهمية خاصة لراحة المريض وطمأنينته النفسية والجسدية في كل المراحل العمرية (أطفال / شيوخ، رجال ونساء). لذلك يتم تقديم جميع العلاجات وفق أساليب علمية مدروسة ولطيفة، تتكيف مع طبيعة كل حالة، مع الحرص على تحقيق أفضل النتائج العلاجية الممكنة في أقصر مدة مناسبة، وبأقل قدر من الانزعاج أو الألم، ودون اللجوء إلى الجراحة متى توفرت البدائل العلاجية المناسبة.</p>
                        </div>
                    </div>
                </div>

                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Réseau Médical</span>
                        <span class="ar">شبكة طبية واسعة لخدمة المرضى</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Au-delà des soins prodigués au sein du centre, je mets également à la disposition de mes patients un vaste réseau professionnel. Grâce aux relations de confiance que nous avons développées au fil des années avec des médecins spécialistes de différentes spécialités à Fès, dans différentes villes du Maroc (Rabat, Casablanca, Tanger, Marrakech, Agadir, Meknès et le Sud...) ainsi qu'auprès de plusieurs établissements hospitaliers en Europe, dans les pays arabes et dans les pays du Golfe, nous facilitons l'orientation de nos patients vers les spécialistes les plus adaptés à leurs besoins lorsque cela s'avère nécessaire.</p>
                        </div>
                        <div class="ar">
                            <p>إلى جانب الخدمات العلاجية التي نقدمها داخل المركز، أضع رهن إشارة مرضاي شبكة واسعة من العلاقات المهنية والطبية التي تم بناؤها على مدى سنوات طويلة من العمل والخبرة.</p>
                            <p>وبفضل علاقات التعاون والثقة التي تجمعنا بعدد من الأطباء المتخصصين بمدينة فاس ومختلف مدن المملكة المغربية، من بينها الرباط والدار البيضاء وطنجة ومراكش وأكادير ومكناس ومدن الجنوب، إضافة إلى مؤسسات استشفائية وأطباء مختصين بأوروبا والعديد من الدول العربية ودول الخليج، نعمل على تسهيل توجيه المرضى نحو الاختصاصات الطبية الأكثر ملاءمة لحالتهم كلما دعت الحاجة إلى ذلك.</p>
                        </div>
                    </div>
                </div>

                <!-- Bloc 7: Mission -->
                <div class="about-block">
                    <h3 class="about-block-title">
                        <span class="fr">Mon Engagement &amp; Mission</span>
                        <span class="ar">رسالتي وهدفي</span>
                    </h3>
                    <div class="about-block-content">
                        <div class="fr">
                            <p>Mon engagement est simple : offrir à chaque patient une prise en charge humaine, professionnelle et personnalisée, afin de l'aider à retrouver sa mobilité, son autonomie et sa qualité de vie.</p>
                            <p style="font-weight: 600; color: #1ABC9C; font-style: italic;">« Mon objectif est de vous accompagner vers une meilleure santé grâce à des solutions thérapeutiques naturelles, efficaces et adaptées à vos besoins. »</p>
                            <p style="font-size: 0.95rem; color: #F1F5F9; text-shadow: 0 1px 8px rgba(0, 0, 0, 0.4); margin-top: 10px;">Sous la devise <strong>« L'humanité avant le gain financier »</strong> et <strong>« La santé est un droit pour tout être humain »</strong>, nous prendrons soin de vous avec l'aide de Dieu.</p>
                        </div>
                        <div class="ar">
                            <p>رسالتي هي تقديم رعاية صحية إnsانية ومهنية وشخصية لكل مريض، قائمة على العلم والخبرة والاحترام للذات البشرية، ومساعدته على استعادة حركته واستقلاليته وتحسين جودة حياته.</p>
                            <p style="font-weight: 600; color: #1ABC9C; font-style: italic;">"هدفي هو مرافقتكم نحو صحة أفضل من خلال حلول علاجية طبيعية، فعالة وآمنة، مصممة خصيصاً لتلبية احتياجاتكم وتحقيق أفضل النتائج العلاجية الممكنة."</p>
                            <p style="font-size: 0.95rem; color: #F1F5F9; text-shadow: 0 1px 8px rgba(0, 0, 0, 0.4); margin-top: 10px;">تحت شعار : <strong>« الإنسانية قبل الربح المادي »</strong> و <strong>« الصحة حق لكل إنسان ونحن بجهد الله نرعاكم »</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite (30%) : Photo Professionnelle & Badge -->
            <div class="about-right-col">
                <div class="doctor-profile-frame">
                    <div class="doctor-photo-container">
                        <img src="{{ asset('images/doctor_placeholder.png') }}" alt="Dr. Salma El Amrani" class="doctor-photo">
                    </div>
                    <h3 class="doctor-name-card">
                        <span class="fr">Dr. Salma El Amrani</span>
                        <span class="ar">الدكتورة سلمى العمراني</span>
                    </h3>
                    <h4 class="doctor-title-card">
                        <span class="fr">Spécialiste en Réhabilitation Physique, Masso-Kinésithérapie &amp; Ostéopathie</span>
                        <span class="ar">أخصائية إعادة التأهيل الفيزيائي، الترويض الطبي والأوستيوباثي</span>
                    </h4>
                    <div class="doctor-badge-card">
                        <span class="fr">Expérience de +20 ans</span>
                        <span class="ar">خبرة تفوق 20 سنة</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@php
    $diagnoPath = public_path('images/Diagno');
    $diagnoImages = collect(glob($diagnoPath . '/*'))
        ->map(fn($path) => asset('images/Diagno/' . basename($path)))
        ->values();

    $espacesPath = public_path('images/espaces');
    $espacesImages = collect(glob($espacesPath . '/*'))
        ->map(fn($path) => basename($path))
        ->values();
@endphp
<section id="suivi-medical">
    <div class="sm-outer">

        {{-- ===== EN-TÊTE CENTRÉ ===== --}}
        <div class="sm-header" style="margin-bottom: 40px;">
            <h2 class="sm-title">
                <span class="fr">Diagnostic &amp; <span class="sm-title-accent">Suivi Thérapeutique</span></span>
                <span class="ar">التشخيص و<span class="sm-title-accent">المتابعة العلاجية</span></span>
            </h2>
        </div>

        {{-- ===== DIAGNOSTIC & PARCOURS DE SOIN ===== --}}
        <div class="sm-new-layout-container" data-diagno-images='@json($diagnoImages)'>
            
            {{-- Left: Dynamic Gallery (3x3 Matrix Grid) --}}
            <div class="sm-new-gallery-col">
                <div class="sm-gallery-grid">
                    <div class="sm-gallery-slot" id="diagno-slot-1">
                        <img src="" alt="Diagnostic 1" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-2">
                        <img src="" alt="Diagnostic 2" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-3">
                        <img src="" alt="Diagnostic 3" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-4">
                        <img src="" alt="Diagnostic 4" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-5">
                        <img src="" alt="Diagnostic 5" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-6">
                        <img src="" alt="Diagnostic 6" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-7">
                        <img src="" alt="Diagnostic 7" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-8">
                        <img src="" alt="Diagnostic 8" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                    <div class="sm-gallery-slot" id="diagno-slot-9">
                        <img src="" alt="Diagnostic 9" class="sm-gallery-img">
                        <div class="sm-gallery-shimmer"></div>
                    </div>
                </div>
            </div>

            {{-- Right: Medical Presentation --}}
            <div class="sm-new-content-col">
                <div class="sm-new-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm-badge-icon">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    <span class="fr">Approche Thérapeutique Premium</span>
                    <span class="ar">نهج علاجي متميز</span>
                </div>

                <div class="sm-new-lead">
                    <span class="fr">Un accompagnement médical complet et personnalisé, de l'évaluation initiale jusqu'à la guérison totale — avec une approche douce, naturelle et adaptée à chaque patient.</span>
                    <span class="ar">متابعة طبية شاملة ومخصصة، من التقييم الأولي حتى الشفاء التام — بمنهج لطيف وطبيعي يتكيف مع كل حالة على حدة.</span>
                </div>

                <div class="sm-new-text-wrapper">
                    <div class="fr">
                        <p class="sm-new-paragraph">
                            Notre centre vous accompagne à chaque étape de votre parcours de soin, du diagnostic initial jusqu'à la guérison complète, grâce à une prise en charge médicale intégrée et personnalisée qui respecte les besoins de chaque patient. Nous nous basons sur une évaluation globale et rigoureuse de votre état de santé, comprenant l'étude de vos antécédents, l'analyse de vos symptômes et un examen clinique complet, afin d'élaborer un protocole thérapeutique sur mesure adapté à votre physiologie. Notre méthodologie repose sur des approches thérapeutiques naturelles, sûres, non invasives et progressives, respectant les équilibres physiologiques du corps tout en stimulant sa capacité d'autoguérison, conformément aux recommandations et aux normes de qualité internationales de l'Organisation Mondiale de la Santé (OMS). Nous veillons à suivre l'évolution de votre santé de manière régulière, en ajustant le protocole de traitement pour garantir des résultats durables et une guérison totale. La prise de rendez-vous est simplifiée : contactez-nous par téléphone, visitez notre centre directement, ou remplissez notre formulaire en ligne. Notre équipe vous contactera dans les plus brefs délais pour confirmer votre rendez-vous, répondre à vos questions et vous guider à chaque étape, vous offrant ainsi une expérience de soins humaine, chaleureuse et sécurisée dès votre première consultation.
                        </p>
                    </div>
                    <div class="ar">
                        <p class="sm-new-paragraph">
                            يرافقكم مركزنا في جميع مراحل رحلتكم العلاجية، بدءًا من التشخيص الأولي ووصولًا إلى التعافي الكامل، من خلال رعاية طبية متكاملة وشخصية تراعي احتياجات كل مريض. نعتمد على تقييم شامل ودقيق للحالة الصحية يشمل دراسة التاريخ المرضي، وتحليل الأعراض، وإجراء الفحص السريري اللازم، بهدف إعداد خطة علاجية مصممة خصيصًا وفقًا لطبيعة كل حالة. وترتكز منهجيتنا على أساليب علاجية طبيعية، آمنة، غير جراحية، ومتدرجة، تحترم التوازن الفسيولوجي للجسم وتساعده على استعادة قدرته الطبيعية على الشفاء، مع الالتزام بأعلى معايير الجودة والتوصيات الدولية الصادرة عن منظمة الصحة العالمية. كما نحرص على متابعة تطور الحالة الصحية بشكل منتظم، مع تعديل الخطة العلاجية عند الحاجة لضمان أفضل النتائج وتحقيق تعافٍ مستدام. ويمكنكم حجز موعد بكل سهولة عبر الهاتف، أو بزيارة المركز مباشرة، أو من خلال تعبئة استمارة حجز الموعد على موقعنا الإلكتروني، حيث سيقوم فريقنا بالتواصل معكم في أقرب وقت لتأكيد الموعد والإجابة عن استفساراتكم ومرافقتكم في جميع خطوات العلاج، لنوفر لكم تجربة رعاية صحية إنسانية، مريحة، وآمنة، منذ أول زيارة وحتى اكتمال الشفاء.
                        </p>
                    </div>
                </div>

                <div class="sm-new-cta">
                    <a href="/rdv" class="sm-new-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm-btn-icon">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span class="fr">Prendre rendez-vous</span>
                        <span class="ar">احجز موعدك الآن</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- ===== ESPACES THÉRAPEUTIQUES (carousel) ===== --}}
        <div class="sm-espaces">
            <div class="sm-espaces-header">
                <div class="sm-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
                <span class="fr">Nos Espaces Thérapeutiques</span>
                <span class="ar">فضاءاتنا العلاجية</span>
            </div>
                <p class="sm-espaces-intro">
                    <span class="fr">Des espaces conçus pour votre confort et votre bien-être, alliant modernité médicale et sérénité thérapeutique.</span>
                    <span class="ar">فضاءات مصممة لراحتكم وعافيتكم، تجمع بين الحداثة الطبية والسكينة العلاجية.</span>
                </p>
            </div>
            <div class="carousel-wrapper">
                <button class="carousel-arrow prev" aria-label="Précédent">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="marquee-container">
                    <div class="marquee-track sm-espaces-track">
                        @for($loopCopy = 0; $loopCopy < 4; $loopCopy++)
                            @foreach($espacesImages as $img)
                                <div class="sm-espaces-card">
                                    <img src="{{ asset('images/espaces/' . $img) }}" alt="Espace thérapeutique">
                                    <div class="sm-espaces-overlay">
                                        <span class="fr">Espace Thérapeutique</span>
                                        <span class="ar">الفضاء العلاجي</span>
                                    </div>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                </div>
                <button class="carousel-arrow next" aria-label="Suivant">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>{{-- fin .sm-espaces --}}

    </div>{{-- fin .sm-outer --}}
</section>

<section id="contact" style="scroll-margin-top: 100px;">
    <div class="contact-container">
        <h2 class="section-title">
            <span class="fr">Contactez-Nous</span>
            <span class="ar">اتصل بنا</span>
        </h2>
        
        <div class="contact-content">
            <!-- Map Column -->
            <div class="contact-map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.561294934305!2d-4.975307624441698!3d34.00380057317525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd9f8dbd4a645d1f%3A0xd3ca1b7acaf491d2!2zQ2xpbmlxdWUgQXZpY2VubmV8INmF2LXYrdipINin2KjZhiDYs9mK2YbYpw!5e0!3m2!1sfr!2sma!4v1790508548995!5m2!1sfr!2sma"
                    class="contact-iframe contact-map"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <!-- Details Column -->
            <div class="contact-info-wrapper">
                <!-- Address Detail -->
                <div class="contact-info-card">
                    <div class="contact-info-item">
                        <div class="contact-card-icon">
                            <svg class="contact-icon-svg-main" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <h3 class="fr">Notre Adresse</h3>
                            <h3 class="ar">عنواننا</h3>
                            <p class="fr">36, avenue Mohammed II, en face de la pâtisserie Marhaba, près d’Aoulouz, à côté du Market Al Jouda et de l’agence Maroc Telecom, 1er étage, Fès, Maroc.</p>
                            <p class="ar">36، شارع محمد الثاني، مقابل حلويات مرحبا، بالقرب من أولوز، بجانب ماركت الجود ووكالة اتصالات المغرب، الطابق الأول، فاس، المغرب.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Phone & Email Detail -->
                <div class="contact-info-card">
                    <div class="contact-info-item">
                        <div class="contact-card-icon">
                            <svg class="contact-icon-svg-main" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <h3 class="fr">Téléphones</h3>
                            <h3 class="ar">الهاتف</h3>
                            <p class="phone-link"><a href="tel:0654389090">0654389090</a></p>
                            <p class="phone-link"><a href="tel:0654389090">0617625009</a></p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-card-icon">
                            <svg class="contact-icon-svg-main" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <h3 class="fr">E-mail</h3>
                            <h3 class="ar">البريد الإلكتروني</h3>
                            <p class="phone-link"><a href="mailto:therapeutiquecentre@gmail.com">therapeutiquecentre@gmail.com</a></p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Detail -->
                <div class="contact-social">
                    <div class="contact-info-item">
                        <div class="contact-card-icon">
                            <svg class="contact-icon-svg-main" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <h3 class="fr">Réseaux Sociaux</h3>
                            <h3 class="ar">وسائل التواصل الاجتماعي</h3>
                            <div class="social-buttons">
                                <!-- Instagram -->
                                <a href="https://www.instagram.com/" target="_blank" class="social-button instagram">
                                    <svg class="social-icon-svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                    <span class="social-text">Dr. Salma El Amrani</span>
                                </a>
                                <!-- Facebook -->
                                <a href="https://web.facebook.com/people/" target="_blank" class="social-button facebook">
                                    <svg class="social-icon-svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span class="social-text">Centre Thérapeutique Privé</span>
                                </a>
                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/in//" target="_blank" class="social-button linkedin">
                                    <svg class="social-icon-svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    <span class="social-text">Centre Thérapeutique Privé</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="site-footer">
    <div class="footer-container">
        <!-- Brand / Intro Column -->
        <div class="footer-column brand-col">
            <div class="footer-logo">
                <img src="{{ asset('images/logos/logo1.png') }}" alt="logo" class="footer-logo-img dynamic-logo">
                <div class="footer-brand-text">
                    <h3 class="fr">Centre Thérapeutique Privé</h3>
                    <h3 class="ar">المركز الاستشفائي الخاص</h3>
                    <p class="fr">Expérience de +20 ans</p>
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
                <a href="https://web.facebook.com/people/" target="_blank" class="footer-social-icon facebook" title="Facebook">
                    <svg viewBox="0 0 24 24" class="footer-svg">
                        <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/in//" target="_blank" class="footer-social-icon linkedin" title="LinkedIn">
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
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Neurologie & Neuropédiatrie</span>
                        <span class="ar">ترويض الجهاز العصبي للأطفال والكبار</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Rééducation Respiratoire</span>
                        <span class="ar">ترويض أمراض الجهاز التنفسي</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Orthopédie & Traumatologie</span>
                        <span class="ar">ترويض العظام وتأهيل الكسور والمفاصل</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Rhumatologie & Colonne Vertébrale</span>
                        <span class="ar">علاج الروماتيزم وآلام الظهر والرقبة</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Physiothérapie & Laser Avancé</span>
                        <span class="ar">العلاج الفيزيائي الحديث والكهربائي</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Balnéothérapie & Hydrothérapie</span>
                        <span class="ar">العلاج المائي والجاكوزي الطبي الدافئ</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Uro-Gynécologie & Post-partum</span>
                        <span class="ar">تأهيل الحوض والنساء قبل وبعد الولادة</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Réhabilitation Sportive & Coaching</span>
                        <span class="ar">الترويض الرياضي وإعادة تأهيل الرياضيين</span>
                    </a>
                </li>
                <li>
                    <a href="#services" class="footer-service-item">
                        <svg class="service-link-bullet" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <span class="fr">Massage Médical, Hijama & Bien-être</span>
                        <span class="ar">التدليك الطبي، الحجامة الطبية والاسترخاء</span>
                    </a>
                </li>
                
                <!-- Link to view all detailed services -->
                <li style="grid-column: 1 / -1; margin-top: 5px;">
                    <a href="#services" class="view-all-services-btn">
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
                        <span><a href="tel:">0654389090</a> / <a href="tel:">0617625009</a></span>
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

    <!-- Lightbox Modal for Clinical Follow-up and Spaces -->
    <div class="sm-lightbox-modal" id="smLightboxModal" aria-hidden="true" role="dialog">
        <div class="sm-lightbox-content">
            <button class="sm-lightbox-close" id="smLightboxClose" aria-label="Fermer">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <img src="" alt="Agrandissement" class="sm-lightbox-img" id="smLightboxImg">
            <a href="" class="sm-lightbox-download" id="smLightboxDownload" download>
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span class="fr">Télécharger l'image</span>
                <span class="ar">تحميل الصورة</span>
            </a>
        </div>
    </div>

    {{-- Script JS lié au fichier resources/js/home.js via Vite --}}
    @vite('resources/js/home.js')

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/212661936500" class="whatsapp-float" target="_blank" title="Contactez-nous sur WhatsApp">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        <span class="whatsapp-tooltip">Contactez-nous</span>
    </a>

</body>
</html>
