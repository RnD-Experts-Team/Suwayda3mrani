<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use App\Models\Language;
use App\Models\SiteContent;
use App\Models\SocialIcon;
use App\Models\Translation;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        AdminUser::create([
            'username' => 'admin',
            'password' => 'admin123', // Will be hashed by the model
            'name' => 'Administrator',
            'is_active' => true,
        ]);

        // Create languages
        Language::create([
            'code' => 'en',
            'name' => 'English',
            'direction' => 'ltr',
            'is_active' => true,
            'is_default' => true,
        ]);

        Language::create([
            'code' => 'ar',
            'name' => 'العربية',
            'direction' => 'rtl',
            'is_active' => true,
            'is_default' => false,
        ]);

        // Create initial content
        $contents = [
            'hero' => [
                'content_en' => [
                    'title' => 'Welcome to Our Website',
                    'subtitle' => 'Your journey starts here',
                    'background_image' => 'https://via.placeholder.com/1920x1080'
                ],
                'content_ar' => [
                    'title' => 'مرحباً بكم في موقعنا',
                    'subtitle' => 'رحلتكم تبدأ من هنا',
                    'background_image' => 'https://via.placeholder.com/1920x1080'
                ]
            ],
            'about_us' => [
                'content_en' => [
                    'title' => 'About Us',
                    'content' => 'Your about us content here...'
                ],
                'content_ar' => [
                    'title' => 'من نحن',
                    'content' => 'محتوى من نحن هنا...'
                ]
            ],
            'our_vision' => [
                'content_en' => [
                    'title' => 'Our Vision',
                    'content' => 'Your vision content here...'
                ],
                'content_ar' => [
                    'title' => 'رؤيتنا',
                    'content' => 'محتوى رؤيتنا هنا...'
                ]
            ],
            'contact_us' => [
                'content_en' => [
                    'title' => 'Contact Us',
                    'phone' => '+1234567890',
                    'whatsapp' => '+1234567890',
                    'email' => 'info@example.com',
                    'address' => 'Your address here'
                ],
                'content_ar' => [
                    'title' => 'تواصل معنا',
                    'phone' => '+1234567890',
                    'whatsapp' => '+1234567890',
                    'email' => 'info@example.com',
                    'address' => 'عنوانكم هنا'
                ]
                ],
                'site_logo' => [
    'content_en' => [
        'logo_url' => '',
        'alt_text' => 'Site Logo'
    ],
    'content_ar' => [
        'logo_url' => '',
        'alt_text' => 'شعار الموقع'
    ]
    ],
    'take_action' => [
    'content_en' => [
        'title' => 'Make a Difference Today',
        'subtitle' => 'Join us in our mission to create positive change in our community. Your support can help us reach more people and make a lasting impact.',
        'image' => 'https://via.placeholder.com/600x400/4CAF50/ffffff?text=Take+Action',
        'button_text' => 'Get Involved',
        'button_url' => '#contact'
    ],
    'content_ar' => [
        'title' => 'أحدث فرقاً اليوم',
        'subtitle' => 'انضم إلينا في مهمتنا لإحداث تغيير إيجابي في مجتمعنا. يمكن لدعمكم أن يساعدنا في الوصول إلى المزيد من الناس وإحداث تأثير دائم.',
        'image' => 'https://via.placeholder.com/600x400/4CAF50/ffffff?text=اتخذ+إجراء',
        'button_text' => 'شارك معنا',
        'button_url' => '#contact'
    ]
]
        ];

        foreach ($contents as $key => $content) {
            SiteContent::create([
                'key' => $key,
                'content_en' => $content['content_en'],
                'content_ar' => $content['content_ar'],
                'is_active' => true,
            ]);
        }

        // Create default translations
    $translations = [
        // Navigation
        'nav.home' => ['en' => 'Home', 'ar' => 'الرئيسية'],
        'nav.media_gallery' => ['en' => 'Media Gallery', 'ar' => 'معرض الوسائط'],
        'nav.about_us' => ['en' => 'About Us', 'ar' => 'من نحن'],
        
        // Buttons
        'button.read_more' => ['en' => 'Read More', 'ar' => 'اقرأ المزيد'],
        'button.view_full_story' => ['en' => 'View Full Story', 'ar' => 'عرض القصة كاملة'],
        'button.view_all_media' => ['en' => 'View All Media', 'ar' => 'عرض جميع الوسائط'],
        'button.back_to_stories' => ['en' => 'Back to Stories', 'ar' => 'العودة للقصص'],
        
        // Sections
        'section.media_gallery' => ['en' => 'Media Gallery', 'ar' => 'معرض الوسائط'],
        'section.media_gallery_desc' => ['en' => 'Explore our latest photos and videos', 'ar' => 'استكشف أحدث الصور والفيديوهات لدينا'],
        'section.stories_of_hope' => ['en' => 'Stories of Hope', 'ar' => 'قصص الأمل'],
        'section.stories_desc' => ['en' => 'Read inspiring stories from our community', 'ar' => 'اقرأ القصص الملهمة من مجتمعنا'],
        'section.our_partners' => ['en' => 'Our Partners', 'ar' => 'شركاؤنا'],
        'section.partners_desc' => ['en' => 'Trusted by leading organizations', 'ar' => 'موثوق من قبل المنظمات الرائدة'],
        
        // Site
        'site.name' => ['en' => 'Your Website Name', 'ar' => 'اسم موقعكم'],
        'site.title' => ['en' => 'Your Website Title', 'ar' => 'عنوان موقعكم'],
        'site.description' => ['en' => 'Your website description here', 'ar' => 'وصف موقعكم هنا'],
        
        // Footer
        'footer.rights' => ['en' => 'All rights reserved', 'ar' => 'جميع الحقوق محفوظة'],
        
        // Hero defaults
        'hero.default_title' => ['en' => 'Welcome to Our Website', 'ar' => 'مرحباً بكم في موقعنا'],
        'hero.default_subtitle' => ['en' => 'Your journey starts here', 'ar' => 'رحلتكم تبدأ من هنا'],

         // Page titles
    'page.home_title' => ['en' => 'Home - Your Website', 'ar' => 'الرئيسية - موقعكم'],
    'page.media_gallery_title' => ['en' => 'Media Gallery - Your Website', 'ar' => 'معرض الوسائط - موقعكم'],
    'page.about_us_title' => ['en' => 'About Us - Your Website', 'ar' => 'من نحن - موقعكم'],
    
    // Page headers
    'page.media_gallery' => ['en' => 'Media Gallery', 'ar' => 'معرض الوسائط'],
    'page.media_gallery_desc' => ['en' => 'Explore our collection of photos and videos', 'ar' => 'استكشف مجموعتنا من الصور والفيديوهات'],
    'page.about_us' => ['en' => 'About Us', 'ar' => 'من نحن'],
    'page.about_us_desc' => ['en' => 'Learn more about our mission and vision', 'ar' => 'تعرف على مهمتنا ورؤيتنا'],
    
    // Filters
    'filter.all' => ['en' => 'All', 'ar' => 'الكل'],
    'filter.photos' => ['en' => 'Photos', 'ar' => 'الصور'],
    'filter.videos' => ['en' => 'Videos', 'ar' => 'الفيديوهات'],
    
    // Media types
    'media.photo' => ['en' => 'Photo', 'ar' => 'صورة'],
    'media.video' => ['en' => 'Video', 'ar' => 'فيديو'],
    
    // Contact
    'contact.phone' => ['en' => 'Phone', 'ar' => 'الهاتف'],
    'contact.whatsapp' => ['en' => 'WhatsApp', 'ar' => 'واتساب'],
    'contact.email' => ['en' => 'Email', 'ar' => 'البريد الإلكتروني'],
    'contact.address' => ['en' => 'Address', 'ar' => 'العنوان'],
    
    // Content placeholders
    'content.about_us_placeholder' => ['en' => 'About us content will appear here...', 'ar' => 'محتوى من نحن سيظهر هنا...'],
    'content.our_vision_placeholder' => ['en' => 'Our vision content will appear here...', 'ar' => 'محتوى رؤيتنا سيظهر هنا...'],
    
    // Labels
    'labels.take_action' => ['en' => 'Take Action', 'ar' => 'اتخذ إجراء'],
    
    // Additional buttons
    'button.learn_more' => ['en' => 'Learn More', 'ar' => 'اعرف المزيد'],

    'media.no_media_found' => ['en' => 'No media found', 'ar' => 'لم يتم العثور على وسائط'],
'media.no_media_desc' => ['en' => 'Start by adding your first media item', 'ar' => 'ابدأ بإضافة أول عنصر وسائط'],
    ];

    foreach ($translations as $key => $values) {
        $group = explode('.', $key)[0];
        
        Translation::create([
            'key' => $key,
            'translations' => $values,
            'group' => $group,
            'is_active' => true,
        ]);
    }
    
    // Create default social icons
    $socialIcons = [
        ['name' => 'Facebook', 'icon_class' => 'fab fa-facebook', 'url' => 'https://facebook.com', 'color' => '#1877f2', 'sort_order' => 1],
        ['name' => 'Twitter', 'icon_class' => 'fab fa-twitter', 'url' => 'https://twitter.com', 'color' => '#1da1f2', 'sort_order' => 2],
        ['name' => 'Instagram', 'icon_class' => 'fab fa-instagram', 'url' => 'https://instagram.com', 'color' => '#e4405f', 'sort_order' => 3],
        ['name' => 'LinkedIn', 'icon_class' => 'fab fa-linkedin', 'url' => 'https://linkedin.com', 'color' => '#0077b5', 'sort_order' => 4],
    ];

    foreach ($socialIcons as $icon) {
        SocialIcon::create($icon);
    }

    SiteContent::create([
    'key' => 'page_headers',
    'content_en' => [
        'media_gallery' => [
            'background_image' => '',
        ],
        'about_us' => [
            'background_image' => '',
        ]
    ],
    'content_ar' => [
        'media_gallery' => [
            'background_image' => '',
        ],
        'about_us' => [
            'background_image' => '',
        ]
    ],
    'is_active' => true,
]);


    }   
}
