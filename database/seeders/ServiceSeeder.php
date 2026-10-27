<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::query()->delete();

        $services = [
            // PHASE 1
            [
                'image' => 'service_1_1.png',
                'title_fr' => 'Rééducation Neurologique & Neuropédiatrique',
                'title_ar' => 'ترويض الجهاز العصبي للأطفال والمسنين',
                'desc_fr' => 'Prise en charge AVC, Parkinson, Alzheimer, paralysie et retards moteurs.',
                'desc_ar' => 'علاج الجلطة الدماغية، الباركينسون، الزهايمر، الشلل وتأخر النمو الحركي.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_2.png',
                'title_fr' => 'Rééducation Respiratoire (Bébés & Adultes)',
                'title_ar' => 'ترويض أمراض الجهاز التنفسي',
                'desc_fr' => 'Traitement de l\'essoufflement, encombrement bronchique et maladies chroniques.',
                'desc_ar' => 'ترويض حالات الانسداد الرئوي وإزالة إفرازات الرئة عند الرضع والبالغين.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_3.png',
                'title_fr' => 'Rééducation Orthopédique & Traumatologique',
                'title_ar' => 'ترويض أمراض العظام والمفاصل',
                'desc_fr' => 'Soins après fractures, pose de prothèses (genou/hanche) et traumatismes.',
                'desc_ar' => 'علاج هشاشة العظام، الكسور، وعمليات تبديل المفاصل الاصطناعية.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_4.png',
                'title_fr' => 'Rééducation Rhumatologique',
                'title_ar' => 'ترويض أمراض الروماتيزم',
                'desc_fr' => 'Soulagement de l\'arthrose, arthrite et raideurs articulaires douloureuses.',
                'desc_ar' => 'علاج الروماتيزم وتيبس المفاصل وتسكين الآلام المفصلية الحادة.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_5.png',
                'title_fr' => 'Rééducation Musculaire & Tendineuse',
                'title_ar' => 'علاج الشd العضلي ومشاكل الأوتار',
                'desc_fr' => 'Soins des entorses, tendinites chroniques, déchirures musculaires et ligaments.',
                'desc_ar' => 'علاج مشاكل الأوتار، الشد العضلي المزمن، خشونة الركبة والرباط الصليبي.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_6.png',
                'title_fr' => 'Rééducation de la Colonne Vertébrale',
                'title_ar' => 'علاج آلام العمود الفقري',
                'desc_fr' => 'Correction de la posture, scoliose, cyphose et douleurs cervicales/lombaires.',
                'desc_ar' => 'علاج آلام الرقبة وأسفل الظهر، وانحرافات وتشوهات العمود الفقري.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_7.png',
                'title_fr' => 'Rééducation de la Paralysie Faciale',
                'title_ar' => 'علاج شلل العصب السابع للوجه',
                'desc_fr' => 'Réactivation neuromusculaire du visage et correction des asymétries.',
                'desc_ar' => 'ترويض عضلات الوجه واستعادة حركتها الطبيعية إثر شلل العصب الوجهي.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_8.png',
                'title_fr' => 'Rééducation Post-traumatique',
                'title_ar' => 'الترويض بعد الحوادث والصدمات',
                'desc_fr' => 'Réhabilitation globale suite à des accidents et chocs physiques graves.',
                'desc_ar' => 'استعادة القدرات الوظيفية والحركية للجسم بعد الإصابات والحوادث.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_9.png',
                'title_fr' => 'Rééducation en Réanimation',
                'title_ar' => 'إعادة التأهيل داخل غرف الإنعاش',
                'desc_fr' => 'Maintien de la mobilité articulaire et de la fonction pulmonaire.',
                'desc_ar' => 'إعادة التأهيل الطبي والحفاظ على حركية المفاصل للمرضى في غرف الإنعاش.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_10.png',
                'title_fr' => 'Rééducation Pédiatrique & Retards Moteurs',
                'title_ar' => 'ترويض الأطفال والتأخر الحركي',
                'desc_fr' => 'Traitement du pied bot, hydrocéphalie et retards moteurs du nourrisson.',
                'desc_ar' => 'علاج استسقاء الدماغ، القدم الحنفاء الولادية، وتأخر النمو الحركي.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_11.png',
                'title_fr' => 'Rééducation Digestive & Maladies Internes',
                'title_ar' => 'ترويض اضطرابات الجهاز الهضمي والباطني',
                'desc_fr' => 'Suivi après cancer intestinal et troubles fonctionnels (maladie de Crohn).',
                'desc_ar' => 'علاج اضطرابات القولون ومرض كرون ومرحلة ما بعد سرطان الأمعاء.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_12.png',
                'title_fr' => 'Rééducation Cardio-Vasculaire',
                'title_ar' => 'ترويض أمراض القلب والشرايين',
                'desc_fr' => 'Réentraînement à l\'effort après accident cardiaque et hypertension.',
                'desc_ar' => 'تأهيل عضلة القلب بعد الجلطات وضبط ضغط الدم الشرياني والانسداد.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_13.png',
                'title_fr' => 'Rééducation Gériatrique',
                'title_ar' => 'ترويض المسنين وكبار السن',
                'desc_fr' => 'Maintien de l\'autonomie, prévention des chutes et équilibre du senior.',
                'desc_ar' => 'الحفاظ على الاستقلالية والقدرة الحركية وتجنب السقوط لدى كبار السن.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_14.png',
                'title_fr' => 'Rééducation Cutanée, Brûlés & Cicatrices',
                'title_ar' => 'تأهيل الحروق وتقرحات ',
                'desc_fr' => 'Traitement des brûlures, cicatrices rétractiles et prévention des escarres.',
                'desc_ar' => 'العناية بالجلد وتأهيل حالات الحروق العميقة وتقرحات الفراش المرضية.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_15.png',
                'title_fr' => 'Rééducation post-chirurgicale & Amputations',
                'title_ar' => 'تأهيل ما بعد بتر الأعضاء',
                'desc_fr' => 'Réentraînement fonctionnel précoce et préparation à l\'appareillage.',
                'desc_ar' => 'الرعاية الحركية بعد العمليات الجراحية وإعداد المبتورين لتركيب الأطراف.',
                'phase' => 1
            ],
            [
                'image' => 'service_1_16.png',
                'title_fr' => 'Rééducation des Troubles Neurologiques Complexes',
                'title_ar' => 'تأهيل الاضطرابات العصبية المعقدة',
                'desc_fr' => 'Rééducation vestibulaire, troubles de l\'équilibre, vertiges et coordination.',
                'desc_ar' => 'تأهيل حالات فقدان التوازن، الدوخة، واضطرابات الحركة والاستقلال.',
                'phase' => 1
            ],

            // PHASE 2
            [
                'image' => 'service_2_1.png',
                'title_fr' => 'Physiothérapie Avancée',
                'title_ar' => 'العلاج الفيزيائي الحديث',
                'desc_fr' => 'Électrothérapie, ultrasons, laser thérapeutique et ondes de choc.',
                'desc_ar' => 'علاج بالكهرباء والموجات فوق الصوتية والليزر والموجات التصادمية.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_2.png',
                'title_fr' => 'Kiné-Balnéothérapie & Hydrothérapie',
                'title_ar' => 'علاج طبيعي بالماء',
                'desc_fr' => 'Rééducation en piscine et jacuzzi médical chaud aux sels de Fès.',
                'desc_ar' => 'العلاج المائي في أحواض الجاكوزي الدافئة لتخفيف تشنج المفاصل.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_3.png',
                'title_fr' => 'Ostéopathie Médicale',
                'title_ar' => 'تقويم العظام والمفاصل يدويًا',
                'desc_fr' => 'Manipulations manuelles pour libérer les blocages articulaires.',
                'desc_ar' => 'علاج يدوي لتعديل المفاصل وإزالة انسدادات فقرات العمود الفقري.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_4.png',
                'title_fr' => 'Acupuncture & Dry Needling',
                'title_ar' => 'الوخز بالإبر الجافة والصينية',
                'desc_fr' => 'Soulagement des points gâchettes musculaires et sevrage du tabac.',
                'desc_ar' => 'الوخز بالإبر لتخفيف الآلام والمساعدة على الإقلاع عن التدخين.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_5.png',
                'title_fr' => 'Réflexologie Podale',
                'title_ar' => 'الريفليكسولوجي للقدمين',
                'desc_fr' => 'Stimulation des zones réflexes pour rééquilibrer le corps.',
                'desc_ar' => 'تدليك نقاط الانعكاس في القدم لتنشيط الأعضاء وتخفيف التوتر.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_6.png',
                'title_fr' => 'Hijama Médicale',
                'title_ar' => 'الحجامة الطبية المعقمة',
                'desc_fr' => 'Séance stérile pour les migraines, détox et stimulation immunitaire.',
                'desc_ar' => 'حجامة طبية وقائية وعلاجية للتخلص من السموم المتراكمة والشقيقة.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_7.png',
                'title_fr' => 'Chromothérapie',
                'title_ar' => 'العلاج بالألوان (كروموطيرابي)',
                'desc_fr' => 'Utilisation des ondes lumineuses colorées pour le système nerveux.',
                'desc_ar' => 'استخدام الطيف اللوني لتحفيز التوازن العصبي وتنشيط حيوية الجسم.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_8.png',
                'title_fr' => 'Aromathérapie',
                'title_ar' => 'العلاج بالزيوت العطرية المقطرة',
                'desc_fr' => 'Utilisation d\'huiles essentielles bio pour relaxer l\'esprit.',
                'desc_ar' => 'العلاج بالزيوت العطرية الطبيعية.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_9.png',
                'title_fr' => 'Musicothérapie',
                'title_ar' => 'العلاج بالموسيقى والاسترخاء الصوتي',
                'desc_fr' => 'Ondes sonores apaisantes pour réduire le stress et réguler le sommeil.',
                'desc_ar' => 'موجات موسيقية هادئة وصوتية مدروسة لتحسين النوم وتخفيف الإجهاد.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_10.png',
                'title_fr' => 'Thermothérapie & Cryothérapie',
                'title_ar' => 'العلاج بالحرارة والبرودة',
                'desc_fr' => 'Application thermique pour calmer l\'inflammation et détendre.',
                'desc_ar' => 'استخدام كمادات البرودة لتقليل الالتهاب والحرارة لارتخاء العضلات.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_11.png',
                'title_fr' => 'Mécanothérapie & Ergothérapie',
                'title_ar' => 'الترويض الآلي والعلاج الوظيفي',
                'desc_fr' => 'Rééducation sur appareils pour restaurer l\'autonomie quotidienne.',
                'desc_ar' => 'استخدام أجهزة ميكانيكية لتقوية المفاصل واستعادة الاستقلال الوظيفي.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_12.png',
                'title_fr' => 'Drainage Lymphatique Manuel',
                'title_ar' => 'التصريف اللمفاوي للدوالي',
                'desc_fr' => 'Traitement des œdèmes, varices et lourdeurs de jambes.',
                'desc_ar' => 'تدليك لتنشيط الأوعية اللمفاوية وعلاج ثقل الساقين والدوالي.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_13.png',
                'title_fr' => 'Massage Médical & Esthétique',
                'title_ar' => 'التdليك الطبي والاستشفائي',
                'desc_fr' => 'Pierres volcaniques et huiles végétales bio pour sculpter le corps.',
                'desc_ar' => 'تدليك طبي استشفائي بالأحجار البركانية الساخنة والزيوت الطبيعية.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_14.png',
                'title_fr' => 'Phytothérapie Médicale',
                'title_ar' => 'العلاج بالنباتات الطبية',
                'desc_fr' => 'Conseils en remèdes naturels pour renforcer l\'organisme.',
                'desc_ar' => 'استخدام تركيبات الأعشاب الطبية الآمنة لدعم المناعة والشفاء.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_15.png',
                'title_fr' => 'Sophrologie & Relaxation Guidée',
                'title_ar' => 'التنمية الذاتية والاسترخاء',
                'desc_fr' => 'Respiration et visualisation contre le surmenage intellectuel.',
                'desc_ar' => 'جلسات للتخلص من القلق والتوتر النفسي والتحكم في الضغط العصبي.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_16.png',
                'title_fr' => 'Auriculothérapie',
                'title_ar' => 'العلاج عبر نقاط الأذن',
                'desc_fr' => 'Stimulation réflexe de l\'oreille pour réguler la douleur et l\'anxiété.',
                'desc_ar' => 'تحفيز نقاط الأذن العصبية لتهدئة الألم وعلاج التوتر والشهية.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_17.png',
                'title_fr' => 'Traitement des Dépendances & Tabac',
                'title_ar' => 'علاج الإدمان والإقلاع عن التدخين',
                'desc_fr' => 'Accompagnement physique et psychologique pour éliminer les toxines.',
                'desc_ar' => 'برامج متكاملة للمساعدة على التخلص من التبغ والاعتمادية.',
                'phase' => 2
            ],
            [
                'image' => 'service_2_18.png',
                'title_fr' => 'Soins Cutanés & Cicatriciels',
                'title_ar' => 'العناية بالجروح والندبات والتقرحات',
                'desc_fr' => 'Physiothérapie cutanée pour assouplir les tissus brûlés.',
                'desc_ar' => 'علاج وتحسين مرونة الجلد والندبات الناتجة عن الحروق أو الجراحات.',
                'phase' => 2
            ],

            // PHASE 3
            [
                'image' => 'service_3_1.png',
                'title_fr' => 'Coaching Sportif & Réadaptation d\'Athlètes',
                'title_ar' => 'الترويض الرياضي وإعادة تأهيل المحترفين',
                'desc_fr' => 'Accompagnement des sportifs pour la reprise après blessure (strapping).',
                'desc_ar' => 'تأهيل الفرق الرياضية والرياضيين المحترفين وتأمين المفاصل.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_2.png',
                'title_fr' => 'Préparation Physique & Récupération',
                'title_ar' => 'الإعداد البدني والاسترجاع العضلي',
                'desc_fr' => 'Optimisation de la performance physique et récupération rapide.',
                'desc_ar' => 'تحسين اللياقة البدنية ومساعدة العضلات على الاسترجاع والاستشفاء السريع.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_3.png',
                'title_fr' => 'Diététique & Nutrition Médicale',
                'title_ar' => 'التغذية العلاجية والأنظمة الغذائية',
                'desc_fr' => 'Établissement de régimes biologiques sur mesure selon votre bilan.',
                'desc_ar' => 'تصميم برامج غذائية صحية دقيقة لضبط الوزن وتعزيز المناعة.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_4.png',
                'title_fr' => 'Amincissement & Body Sculpting',
                'title_ar' => 'تنحيف ونحت الجسم',
                'desc_fr' => 'Traitements esthétiques médicaux (Maderothérapie) pour raffermir.',
                'desc_ar' => 'تنحيف منطقة البطن ونحت الجسم بتقنيات خشبية ومعدنية.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_5.png',
                'title_fr' => 'Traitement de la Surcharge Pondérale & Maigreur',
                'title_ar' => 'علاج السمنة المفرطة والنحافة',
                'desc_fr' => 'Prise en charge métabolique contre l\'obésité morbide et la dénutrition.',
                'desc_ar' => 'محاربة تشوهات السمنة المرضية وعلاج النحافة المفرطة.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_6.png',
                'title_fr' => 'Rééducation Périnéale & Post-partum',
                'title_ar' => 'ترويض الحوض وعضلات العجان',
                'desc_fr' => 'Renforcement périnéal pour traiter les fuites et descentes d\'organes.',
                'desc_ar' => 'تقوية عضلات الحوض لعلاج سلس البول وهبوط وتدلي الرحم.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_7.png',
                'title_fr' => 'Troubles Uro-Gynécologiques',
                'title_ar' => 'تأهيل اضطرابات المسالك والرحم',
                'desc_fr' => 'Rééducation sphinctérienne et traitement des douleurs pelviennes.',
                'desc_ar' => 'علاج التوسع المهبلي، مشاكل التحكم البولي، والتشنجات.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_8.png',
                'title_fr' => 'Appareillage & Prothèses Orthopédiques',
                'title_ar' => 'صناعة وتركيب الأطراف الاصطناعية',
                'desc_fr' => 'Conception sur mesure d\'appareils pour amputés et diabétiques.',
                'desc_ar' => 'تصنيع أطراف اصطناعية تعويضية لضحايا الحوادث ومرضى السكري.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_9.png',
                'title_fr' => 'Attelles, Corsets & Semelles Médicales',
                'title_ar' => 'صنع المقومات والجبائر الطبية بمقاسات خاصة',
                'desc_fr' => 'Réalisation d\'orthèses plantaires et corsets personnalisés moulés.',
                'desc_ar' => 'تصميم وتفصيل Semelles orthopédiques وجبائر تصحيح العظام.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_10.png',
                'title_fr' => 'Enfants à Besoins Spécifiques (Autisme, IMC)',
                'title_ar' => 'ترويض الأطفال ذوي الاحتياجات الخاصة',
                'desc_fr' => 'Rééducation motrice et psychomotricité pour enfants autistes.',
                'desc_ar' => 'ترويض أطفال التوحد والشلل الدماغي لزيادة الاستقلالية والحركة.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_11.png',
                'title_fr' => 'Réhabilitation Post-accouchement',
                'title_ar' => 'إعادة التأهيل بعد الولادة للأمهات',
                'desc_fr' => 'Accompagnement post-natal pour retrouver posture et tonus abdominal.',
                'desc_ar' => 'تأهيل النساء بعد الولادة واستعادة اللياقة وعضلات البطن.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_12.png',
                'title_fr' => 'Gestion du Stress & Yoga Thérapeutique',
                'title_ar' => 'علاج التوتر واليوغا العلاجية',
                'desc_fr' => 'Sessions d\'exercices et de méditation pour harmoniser le corps.',
                'desc_ar' => 'يوغا طبية وتأمل للتخلص من الإرهاق الذهني والتوتر العضلي.',
                'phase' => 3
            ],
            [
                'image' => 'service_3_13.png',
                'title_fr' => 'Soins de Bien-être Global',
                'title_ar' => 'العناية والاستشفاء العام والراحة',
                'desc_fr' => 'Balnéothérapie relaxante, sels de bath et jacuzzi pour calmer la fatigue.',
                'desc_ar' => 'حمامات دافئة بالأملاح الفوارة والموسيقى الهادئة لاستعادة النشاط.',
                'phase' => 3
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
