<?php
// ReduxFramework Sample Config File
// For full documentation, please visit: https://docs.reduxframework.com
if ( !class_exists( 'Redux_Framework_sample_config' ) ) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( !class_exists( 'ReduxFramework' ) ) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }

        }

        public function initSettings() {

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if ( !isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        public function setSections() {
            // General Settings
            //plugin is activated
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => esc_html__( 'General', 'gags' ),
                'fields' => array(
                    array(
                        'id'                        => 'gags-general-post',
                        'type'                      => 'info',
                        'icon'                      => 'el-icon-info-sign',
                        'title'                     => esc_html__('Post Settings', 'gags'),
                        'desc'                      => esc_html__('Post common settings.', 'gags'),
                    ),

                    array(
                        'id'                        => 'gags_post_excerpt_length',
                        'type'                      => 'slider',
                        'title'                     => esc_html__('Post Excerpt Length', 'gags'),
                        'default'                   => 65,
                        'min'                       => 20,
                        'step'                      => 1,
                        'max'                       => 65,
                        'display_value'             => 'text'
                    ),
                )
            );

             // Advertisment
            $this->sections[] = array(
                'icon' => 'el-icon-bullhorn',
                'title' => esc_html__('Advertisement', 'gags'),
                'fields' => array(

                    array(
                        'id'                        => 'info-ad-between-post',
                        'type'                      => 'info',
                        'style'                     => 'warning',
                        'icon'                      => 'el-icon-info-sign',
                        'title'                     => esc_html__('Between Posts Ad', 'gags'),
                    ),

                    array(
                        'id'                        => 'between_posts_ads_mode',
                        'type'                      => 'button_set',
                        'title'                     => esc_html__('Ad Mode', 'gags'),
                        'desc'                      => esc_html__('Choose the ad mode', 'gags'),
                        'options'                   => array('1' => 'Local Banner', '2' => 'Ad Code'),
                        'default'                   => '1'
                    ),

                    array(
                        'id'                        => 'between_posts_ads_img',
                        'type'                      => 'media',
                        'required'                  => array('between_posts_ads_mode', 'equals', '1'),
                        'title'                     => esc_html__('Banner Image', 'gags'),
                        'compiler'                  => 'true',
                        'desc'                      => esc_html__('Upload your own banner image.', 'gags'),
                        'default'                   => array('url' => get_template_directory_uri() .'/images/ad-between-post.gif'),
                    ),

                    array(
                        'id'                        => 'between_posts_ads_url',
                        'type'                      => 'text', 
                        'required'                  => array('between_posts_ads_mode', 'equals', '1'),
                        'title'                     => esc_html__('Banner URL', 'gags'),
                        'desc'                      => esc_html__('Where should this banner linked to?', 'gags'),
                        'placeholder'               => 'http://',
                        'default'                   => '#'
                    ),

                    array(
                        'id'                        => 'between_posts_ads_code',
                        'type'                      => 'textarea',
                        'required'                  => array('between_posts_ads_mode', 'equals', '2'),
                        'title'                     => esc_html__('Ad Code', 'gags'),
                        'desc'                      => esc_html__('Paste your ad code.', 'gags'),
                        'default'                   => ''
                    ),

                    // Single Post Ad
                     array(
                        'id'                        => 'single-ad-300x250',
                        'type'                      => 'info',
                        'style'                     => 'warning',
                        'icon'                      => 'el-icon-info-sign',
                        'title'                     => esc_html__('Single Posts Ad', 'gags'),
                    ),

                    array(
                        'id'                        => 'single_posts_ads_mode',
                        'type'                      => 'button_set',
                        'title'                     => esc_html__('Ad Mode', 'gags'),
                        'desc'                      => esc_html__('Choose the ad mode', 'gags'),
                        'options'                   => array('1' => 'Local Banner', '2' => 'Ad Code'),
                        'default'                   => '1'
                    ),

                    array(
                        'id'                        => 'single_posts_ads_img',
                        'type'                      => 'media',
                        'required'                  => array('single_posts_ads_mode', 'equals', '1'),
                        'title'                     => esc_html__('Banner Image', 'gags'),
                        'compiler'                  => 'true',
                        'desc'                      => esc_html__('Upload your own banner image.', 'gags'),
                        'default'                   => array('url' => get_template_directory_uri() .'/images/ad-between-post.gif'),
                    ),

                    array(
                        'id'                        => 'single_posts_ads_url',
                        'type'                      => 'text', 
                        'required'                  => array('single_posts_ads_mode', 'equals', '1'),
                        'title'                     => esc_html__('Banner URL', 'gags'),
                        'desc'                      => esc_html__('Where should this banner linked to?', 'gags'),
                        'placeholder'               => 'http://',
                        'default'                   => '#'
                    ),

                    array(
                        'id'                        => 'single_posts_ads_code',
                        'type'                      => 'textarea',
                        'required'                  => array('single_posts_ads_mode', 'equals', '2'),
                        'title'                     => esc_html__('Ad Code', 'gags'),
                        'desc'                      => esc_html__('Paste your ad code.', 'gags'),
                        'default'                   => ''
                    ),
                 )
            );
        

            // Typography Settings
            $this->sections[] = array(
                'icon'    => 'el-icon-text-width',
                'title'   => esc_html__( 'Typography', 'gags' ),
                'fields'  => array(
                    array(
                        'id'                => 'gags_site_title_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Site Title Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('#logo h2.site-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '25px',
                            'font-weight'       => '600',
                            'color'             => '#ffffff'
                        )
                    ),

                    array(
                        'id'                => 'gags_body_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Main Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('body'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '16px',
                            'font-weight'       => '400',
                            'color'             => '#555'
                        )
                    ),

                    array(
                        'id'                => 'gags_top_menu_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Top Menu Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'text-transform'    => false,
                        'output'            => array('nav#user-menu ul li a', '.user-menu-trigger'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'color'             => '#ffffff',
                        )
                    ),

                    array(
                        'id'                => 'gags_main_menu_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Main Menu Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'text-transform'    => false,
                        'output'            => array('nav#main-menu.site-navigation ul li a'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'color'             => '#ffffff',
                        )
                    ),

                    array(
                        'id'                => 'gags_sub_menu_typography',
                        'type'              => 'typography',
                        'title'             => esc_html__('Sub Menu Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'text-transform'    => false,
                        'output'            => array('nav#main-menu.site-navigation ul li.menu-item-has-children ul.sub-menu li a'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'color'             => '#111111',
                        )
                    ),

                    array(
                        'id'                => 'gags_page_title_default_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Page Title (Default Template) Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.section-title h4.widget-title', 'article.hentry .entry-content h4.widget-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'color'             => '#000000' 
                        )
                    ),

                    array(
                        'id'                => 'gags_page_title_fullwidth_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Page Title (Fullwidth Template) Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.page-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '24px',
                            'font-weight'       => '700',
                            'color'             => '#000000' 
                        )
                    ),

                    array(
                        'id'                => 'gags_posts_title_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Post Title Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('article.hentry.post h3.post-title, article.hentry.post h1.post-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '24px',
                            'font-weight'       => '900',
                            'color'             => '#000000' 
                        )
                    ),

                    array(
                        'id'                => 'gags_widget_posts_title_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Post Title Typography (Widget)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.widget article.hentry.post h3.post-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '16px',
                            'font-weight'       => '700',
                            'color'             => '#000000' 
                        )
                    ),

                    array(
                        'id'                => 'gags_post_like_count_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Post Like Count Number Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'all_styles'        => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('.vote-wrap span.like-count', '.article-vote span'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '24px',
                            'font-weight'       => '700',
                            'color'             => '#666'
                        )
                    ),

                    array(
                        'id'                => 'gags_post_meta_top_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Post Meta Typography', 'gags'),
                        'desc'              => esc_html__('Post meta typography for like text name and post comment', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'all_styles'        => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('.vote-wrap span.like-text', '.article-footer a.comment-count'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '400',
                            'color'             => '#888'
                        )
                    ),

                    array(
                        'id'                => 'gags_post_meta_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Post Meta Typography', 'gags'),
                        'desc'              => esc_html__('Post meta typography for author name and post time published', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'all_styles'        => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('.entry-meta span'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '11px',
                            'font-weight'       => '400',
                            'color'             => '#888'
                        )
                    ),

                    array(
                        'id'                => 'gags_widget_title_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Widgets Title Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'all_styles'        => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'text-transform'    => false,
                        'output'            => array('.widget h4.widget-title'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'color'             => '#000000'
                        )
                    ),

                    array(
                        'id'                => 'gags_list_categories_menu_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('List Categories & Custom Menu Typography Widget', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.categories ul li a', '.gag-custom-menu-widget ul li a'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '600',
                            'color'             => '#000000' 
                        )
                    ),

                    array(
                        'id'                => 'gags_footer_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Footer Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'text-transform'    => false,
                        'output'            => array('footer#colofon'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '12px',
                            'font-weight'       => '400',
                            'color'             => '#777'
                        )
                    ),
                   
                    array(
                        'id'                => 'gags_heading_1',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 1 (h1)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h1'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '40px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_heading_2',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 2 (h2)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h2'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '32px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_heading_3',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 3 (h3)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h3'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '30px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_heading_4',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 4 (h4)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h4'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '22px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_heading_5',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 5 (h5)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h5'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '16px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_heading_6',
                        'type'              => 'typography',
                        'title'             => esc_html__('Heading 6 (h6)', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'output'            => array('article.hentry .entry-content h6'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '12px',
                            'font-weight'       => '700',
                            'color'             => '#000000',
                        )
                    ),

                    array(
                        'id'                => 'gags_author_name_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Dashboard Author Name Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('#dashboard-header .profile .info h2'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '18px',
                            'font-weight'       => '700',
                            'color'             => '#ffffff'
                        )
                    ),

                    array(
                        'id'                => 'gags_author_status_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Dashboard Author Login Status Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('#dashboard-header .profile .info h2 small'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '400',
                            'color'             => '#9c9c9c'
                        )
                    ),

                    array(
                        'id'                => 'gags_author_statistic_count_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Dashboard Author Statistic (Counter) Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.profile-info ul li p'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '24px',
                            'font-weight'       => '700',
                            'color'             => '#ffffff'
                        )
                    ),

                    array(
                        'id'                => 'gags_author_statistic_label_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Dashboard Author Statistic (Text) Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.profile-info ul li p small'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '400',
                            'color'             => '#9c9c9c'
                        )
                    ),

                    array(
                        'id'                => 'gags_tab_dashboard_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Dashboard Tab Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.tab-nav a'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '12px',
                            'font-weight'       => '400',
                            'color'             => '#afafaf'
                        )
                    ),

                    array(
                        'id'                => 'gags_tab_submit_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Submit Tab Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('.tab-header .tabs-nav'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '12px',
                            'font-weight'       => '500',
                            'color'             => '#ffffff'
                        )
                    ),

                    array(
                        'id'                => 'gags_pagination_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Pagination Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'text-transform'    => true,
                        'letter-spacing'    => false,
                        'output'            => array('.pagination span a', '.pagination span', '.pagination a'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '12px',
                            'font-weight'       => '700',
                            'text-transform'    => 'uppercase',
                            'color'             => '#000000'
                        )
                    ),

                    array(
                        'id'                => 'gags_form_field_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Form Field Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'output'            => array('input[type="text"]', 'input[type="email"]', 'input[type="file"]', 'input[type="password"]', 'input[type="password"]', 'textarea', 'select', 'div.tagsinput'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '400',
                            'color'             => '#282828'
                        )
                    ),

                    array(
                        'id'                => 'gags_form_button_font',
                        'type'              => 'typography',
                        'title'             => esc_html__('Form Button Typography', 'gags'),
                        'google'            => true,
                        'subsets'           => true,
                        'preview'           => true,
                        'line-height'       => false,
                        'text-align'        => false,
                        'text-transform'    => true,
                        'letter-spacing'    => false,
                        'output'            => array('input[type="submit"].button', 'button.button'),
                        'default'           => array(
                            'font-family'       => 'Lato',
                            'font-size'         => '14px',
                            'font-weight'       => '700',
                            'text-transform'    => 'uppercase',
                            'color'             => '#ffffff'
                        )
                    ),
                ),
            );

              
            //Color Settings
            $this->sections[] = array(
                'icon'    => 'el-icon-brush',
                'title'   => esc_html__( 'Colors', 'gags' ),
                'fields'  => array(
                    array(
                        'id'                    => 'gags-info-link-color',
                        'type'                  => 'info',
                        'icon'                  => 'el-icon-info-sign',
                        'title'                 => esc_html__('Link Color', 'gags'),
                    ),

                     array(
                        'id'                    => 'gags_main_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Main Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('body a'),
                        'default'               => array(
                                                    'regular'  => '#000000',
                                                    'hover'    => '#1a7aac',
                        )
                    ),

                    array(
                        'id'                    => 'gags_site_title_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Site Title Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('#logo h2.site-title a'),
                        'default'               => array(
                                                    'regular'  => '#ffffff',
                                                    'hover'    => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_top_menu_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Top Menu Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('nav#user-menu ul li a', '.user-menu-trigger', '.search-trigger'),
                        'default'               => array(
                                                    'regular'  => '#fff',
                                                    'hover'    => '#eee',
                        )
                    ),

                    array(
                        'id'                    => 'gags_main_menu_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Main Menu Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('nav#main-menu.site-navigation ul li a'),
                        'default'               => array(
                                                    'regular'  => '#dedede',
                                                    'hover'    => '#fff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_main_sub_menu_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Sub Menu Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('nav#main-menu.site-navigation ul li.menu-item-has-children ul.sub-menu li a', '.user-logged-in-menu ul li a'),
                        'default'               => array(
                                                    'regular'  => '#111111',
                                                    'hover'    => '#111111',
                        )
                    ),

                    array(
                        'id'                    => 'gags_account_menu_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Account Menu Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('nav#user-menu .user-logged-in-menu ul li a'),
                        'default'               => array(
                                                    'regular'  => '#000000',
                                                    'hover'    => '#2c414c',
                        )
                    ),

                    array(
                        'id'                    => 'gags_footer_menu_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Footer Menu Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('nav#footer-menu ul li a'),
                        'default'               => array(
                                                    'regular'  => '#656565',
                                                    'hover'    => '#1a7aac',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_title_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Post Title Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('article.hentry.post h3.post-title a'),
                        'default'               => array(
                                                    'regular'  => '#000000',
                                                    'hover'    => '#1a7aac',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_like_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Post Like Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('.article-vote a'),
                        'default'               => array(
                                                    'regular'  => '#999999',
                                                    'hover'    => '#999999',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_meta_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Post Meta Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('.entry-meta span a', '.article-share a', '.article-share a i'),
                        'default'               => array(
                                                    'regular'  => '#888888',
                                                    'hover'    => '#888888',
                        )
                    ),

                    array(
                        'id'                    => 'gags_paging_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Pagination Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('.pagination span a', '.pagination span', '.pagination a'),
                        'default'               => array(
                                                    'regular'  => '#111111',
                                                    'hover'    => '#ffffff',
                        )
                    ),
                    
                    array(
                        'id'                    => 'gags-info-background-color',
                        'type'                  => 'info',
                        'icon'                  => 'el-icon-info-sign',
                        'title'                 => esc_html__('Background Color', 'gags'),
                    ),

                    array(
                        'id'                    => 'gags_header_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Header Background Color', 'gags'),
                        'output'                => array('#top-header'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#182825',
                        )
                    ),

                    array(
                        'id'                    => 'gags_menu_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Main Menu Background Color', 'gags'),
                        'output'                => array('#main-menu-header'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#1b1b1b',
                        )
                    ),

                    array(
                        'id'                    => 'gags_menu_hover_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Main Menu Background Hover Color', 'gags'),
                        'output'                => array('.site-navigation ul li:hover > a'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#1b1b1b',
                        )
                    ),

                    array(
                        'id'                    => 'gags_sub_menu_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Sub Menu Background Color', 'gags'),
                        'output'                => array('.site-navigation ul li.menu-item-has-children ul.sub-menu', '.user-logged-in-menu ul'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_submenu_background_hover',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Sub Menu Background Hover Color', 'gags'),
                        'output'                => array('.site-navigation ul li.menu-item-has-children ul.sub-menu li:hover > a', '.user-logged-in-menu ul li:hover > a'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#c1e2f3',
                        )
                    ),

                    array(
                        'id'                    => 'gags_main_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Main Background Color', 'gags'),
                        'output'                => array('body'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#fbfbfb',
                        )
                    ),

                    array(
                        'id'                    => 'gags_page_title_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Page (Default Template), Tab Navigation & Widget Title Background Color', 'gags'),
                        'output'                => array('.tab-nav'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#dedede',
                        )
                    ),

                    array(
                        'id'                    => 'gags_hentry_background_color',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Box Hentry Background Color', 'gags'),
                        'output'                => array('#maincontent article.hentry.post'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_hentry_box_shadow',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Box Hentry Shadow Color', 'gags'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#dedede',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_like_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Post Like Button Background Color', 'gags'),
                        'output'                => array('.article-vote i'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#eeeeee',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_like_background_hover',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Post Like Button Background Color Hover', 'gags'),
                        'output'                => array('.article-vote:hover i'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#8bc34a',
                        )
                    ),

                    array(
                        'id'                    => 'gags_post_like_icon_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Post Like Button Icon Color', 'gags'),
                        'active'                => false,
                        'output'                => array('.article-vote i'),
                        'default'               => array(
                                                    'regular'  => '#666666',
                                                    'hover'    => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_paging_link_color',
                        'type'                  => 'link_color',
                        'title'                 => esc_html__('Pagination Link Color', 'gags'),
                        'active'                => false,
                        'output'                => array('.pagination span a', '.pagination span', '.pagination a'),
                        'default'               => array(
                                                    'regular'  => '#111111',
                                                    'hover'    => '#ffffff',
                        )
                    ),

                    array(
                        'id'        => 'gags_paging_shadow',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Pagination Shadow Color', 'gags'),
                        // See Notes below about these lines.
                        // 'output'    => array('background-color' => '.site-header'),
                        //'compiler'  => array('color' => '.site-header, .site-footer', 'background-color' => '.nav-bar'),
                        'default'   => array(
                            'color'     => '#000000',
                            'alpha'     => .34
                        ),
                     
                        // These options display a fully functional color palette.  Omit this argument
                        // for the minimal color picker, and change as desired.
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,  // show default
                            'input_text'                => esc_html__('Select Color', 'gags'),
                        ),                        
                    ),

                    array(
                        'id'                    => 'gags_paging_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Pagination Background Color', 'gags'),
                        'output'                => array('.pagination span', '.pagination a'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_paging_hover_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Pagination Background Hover Color', 'gags'),
                        'output'                => array('.pagination span:hover', '.pagination a:hover'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#000000',
                        )
                    ),

                    array(
                        'id'                    => 'gags_paging_current_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Pagination Current Background Color', 'gags'),
                        'output'                => array('.pagination span.current'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#eeeeee',
                        )
                    ),

                    array(
                        'id'                    => 'gags_author_box_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Author Box Background Color', 'gags'),
                        'output'                => array('#dashboard-header'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#111111',
                        )
                    ),

                    array(
                        'id'                    => 'gags_submit_tab_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Submit Tab Background Color', 'gags'),
                        'output'                => array('.tab-header .tabs-nav'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#aeb7b3',
                        )
                    ),

                    array(
                        'id'                    => 'gags_submit_tab_active_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Submit Tab Active Background Color', 'gags'),
                        'output'                => array('.tab-header .tabs-nav.active'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#9fa7a3',
                        )
                    ),

                    array(
                        'id'                    => 'gags_form_field_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Form Field Background Color', 'gags'),
                        'output'                => array('input[type="text"]', 'input[type="email"]', 'input[type="file"]', 'input[type="password"]', 'input[type="password"]', 'textarea', 'select', 'div.tagsinput'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#ffffff',
                        )
                    ),

                    array(
                        'id'                    => 'gags_form_button_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Form Button Background Color', 'gags'),
                        'output'                => array('input[type="submit"].button', 'button.button'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#1976d2',
                        )
                    ),

                    array(
                        'id'                    => 'gags_form_button_hover_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Form Button Background Hover Color', 'gags'),
                        'output'                => array('input[type="submit"].button:hover', 'button.button:hover'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#1976d2',
                        )
                    ),
                   
                    array(
                        'id'                    => 'gags_footer_background',
                        'type'                  => 'background',
                        'title'                 => esc_html__('Footer Background Color', 'gags'),
                        'output'                => array('footer#colofon'),
                        'preview'               => false,
                        'preview_media'         => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-gradient'   => false,
                        'background-clip'       => false,
                        'background-origin'     => false,
                        'background-size'       => false,
                        'default'               => array(
                                                    'background-color' => '#dddddd',
                        )
                    ),

                    array(
                        'id'                    => 'gags-info-border-color',
                        'type'                  => 'info',
                        'icon'                  => 'el-icon-info-sign',
                        'title'                 => esc_html__('Border Color', 'gags'),
                    ),

                    array(
                        'id'                        => 'gags_page_title_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Page (Default Template), Tab Navigation & Widget Title Border Color', 'gags'),
                        'output'                    => array('.tab-nav'),
                        'all'                       => false,
                        'left'                      => true,
                        'right'                     => false,
                        'top'                       => false,
                        'bottom'                    => false,
                        'default'                   => array(
                                                        'border-width' => '4px',
                                                        'border-color'  => '#919191',
                                                        'border-style'  => 'solid',
                                                    )
                    ),

                    array(
                        'id'                        => 'gags_page_title_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Page (Fullwidth Template) Title Border Color', 'gags'),
                        'output'                    => array('.page-title'),
                        'all'                       => false,
                        'left'                      => false,
                        'right'                     => false,
                        'top'                       => false,
                        'bottom'                    => true,
                        'default'                   => array(
                                                        'border-width' => '1px',
                                                        'border-color'  => '#eeeeee',
                                                        'border-style'  => 'solid',
                                                    )
                    ),

                    array(
                        'id'                        => 'gags_post_hentry_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Article Hentry Border Color', 'gags'),
                        'output'                    => array('article.hentry.post'),
                        'all'                       => false,
                        'left'                      => false,
                        'right'                     => false,
                        'top'                       => false,
                        'bottom'                    => true,
                        'default'                   => array(
                                                        'border-width' => '1px',
                                                        'border-color'  => '#eeeeee',
                                                        'border-style'  => 'solid',
                                                    )
                    ),

                    array(
                        'id'                        => 'gags_account_nav_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Account Navigation Border Color', 'gags'),
                        'output'                    => array('.user-logged-in-menu', 'nav#user-menu > ul li a'),
                        'all'                       => false,
                        'left'                      => true,
                        'right'                     => false,
                        'top'                       => false,
                        'bottom'                    => false,
                        'default'                   => array(
                                                        'border-width' => '1px',
                                                        'border-color'  => '#1b1b1b',
                                                        'border-style'  => 'solid',
                                                    )
                    ),

                    array(
                        'id'                        => 'gags_form_field_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Form Field Border Color', 'gags'),
                        'output'                    => array('input[type="text"]', 'input[type="email"]', 'input[type="file"]', 'input[type="password"]', 'input[type="password"]', 'textarea', 'select', 'div.tagsinput'),
                        'all'                       => true,
                        'default'                   => array(
                                                        'border-width' => '1px',
                                                        'border-color'  => '#dddddd',
                                                        'border-style'  => 'solid',
                                                    )
                    ),

                    array(
                        'id'                        => 'gags_hentry_border',
                        'type'                      => 'border',
                        'title'                     => esc_html__('Box Hentry Border Color', 'gags'),
                        'output'                    => array('#maincontent article.hentry.post .entry-meta'),
                        'all'                       => false,
                        'left'                      => false,
                        'right'                     => false,
                        'top'                       => true,
                        'bottom'                    => false,
                        'default'                   => array(
                                                        'border-width' => '1px',
                                                        'border-color'  => '#eeeeee',
                                                        'border-style'  => 'solid',
                                                    )
                    ),
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__( 'Theme Information 1', 'gags' ),
                'content'   => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'gags' )
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__( 'Theme Information 2', 'gags' ),
                'content'   => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'gags' )
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'gags' );
        }

        //  All the possible arguments for Redux.
        //  For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => 'gags_option',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => true,
                // Show the sections below the admin menu item or not
                'menu_title'           => esc_html__( 'Theme Options', 'gags' ),
                'page_title'           => esc_html__( 'Theme Options', 'gags' ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'       => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography'     => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'            => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon'       => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority'   => 50,
                // Choose an priority for the admin bar menu
                'global_variable'      => '',
                // Ajax save
                'ajax_save'            => true,
                // Set a different name for your global variable other than the opt_name
                'dev_mode'             => false,
                // Show the time the page took to load, etc
                'update_notice'        => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer'           => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'        => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'          => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'     => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'            => get_template_directory_uri() .'/images/warrior-icon.png',
                // Specify a custom URL to an icon
                'last_tab'             => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'            => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'            => 'warriorpanel',
                // Page slug used to denote the panel
                'save_defaults'        => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'         => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'         => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export'   => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                // 'output'               => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'           => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'             => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'          => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                    'hide'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/themewarrior',
                'title' => 'Like us on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/themewarrior',
                'title' => 'Follow us on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/ThemeWarriors/portfolio',
                'title' => 'See our portfolio',
                'icon' => 'el-icon-check'
            );

            // Panel Intro text -> before the form
            $this->args['intro_text'] = wp_kses( __( '<p>If you like this theme, please consider giving it a 5 star rating on ThemeForest. <a href="http://themeforest.net/downloads" target="_blank">Rate now</a>.</p>', 'gags' ), array( 
                    'a' => array( 'href' => array() ), 
                    'p' => array() ) 
                );

            // Add content after the form.
            // $this->args['footer_text'] = esc_html__('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'gags');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}