<?php

namespace Autoclass_Manager\Admin;

/**
 * The Autoclass Manager Admin defines all functionality for the dashboard
 * of the plugin.
 */

/** 
 * The Autoclass Manager Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Autoclass_Manager_Admin
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    private $allowed;
    
    private $domain;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
        $this->allowed = array(
            'p' => array(
                'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => array(),
        );
        
        $this->domain  = 'autoclass-framework';
    }
    
    /**
     * Add custom content type slides.
     */
    public function add_post_type()
    {
        $this->registerBrands();
        
        $this->registerModels();
        
        $this->registerCars();
        
        $this->registerCustomers();
        
        $this->registerSliders();
        
//        flush_rewrite_rules();
    }
    
    private function registerBrands()
    {
        $labels = array(
            'name' => __('Marcas', $this->domain),
            'singular_name' => __('Marca', $this->domain),
            'add_new' => __('Nueva marca', $this->domain),
            'add_new_item' => __('Agregar nueva marca', $this->domain),
            'edit_item' => __('Editar marca', $this->domain),
            'new_item' => __('Nueva marca', $this->domain),
            'view_item' => __('Ver marca', $this->domain),
            'search_items' => __('Buscar marca', $this->domain),
            'not_found' => __('Marca no encontrada', $this->domain),
            'not_found_in_trash' => __('Marca no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos las marcas', $this->domain),
                //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
                //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
                //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
                //          'featured_image' - Default is Featured Image.
                //          'set_featured_image' - Default is Set featured image.
                //          'remove_featured_image' - Default is Remove featured image.
                //          'use_featured_image' - Default is Use as featured image.
                //          'menu_name' - Default is the same as `name`.
                //          'filter_items_list' - String for the table views hidden heading.
                //          'items_list_navigation' - String for the table pagination hidden heading.
                //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de marcas.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-awards',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
//                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
            // 'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            'rewrite' => [
                'slug' => 'marcas'
            ],
            'show_in_rest' => true
        );
        register_post_type('brands', $args);
    }
    
    private function registerModels()
    {
        $labels = array(
            'name' => __('Modelos', $this->domain),
            'singular_name' => __('Modelo', $this->domain),
            'add_new' => __('Nuevo modelo', $this->domain),
            'add_new_item' => __('Agregar nuevo modelo', $this->domain),
            'edit_item' => __('Editar modelo', $this->domain),
            'new_item' => __('Nuevo modelo', $this->domain),
            'view_item' => __('Ver modelo', $this->domain),
            'search_items' => __('Buscar modelo', $this->domain),
            'not_found' => __('Modelo no encontrado', $this->domain),
            'not_found_in_trash' => __('Modelo no encontrado en la papelera', $this->domain),
            'all_items' => __('Todos los modelos', $this->domain),
                //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
                //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
                //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
                //          'featured_image' - Default is Featured Image.
                //          'set_featured_image' - Default is Set featured image.
                //          'remove_featured_image' - Default is Remove featured image.
                //          'use_featured_image' - Default is Use as featured image.
                //          'menu_name' - Default is the same as `name`.
                //          'filter_items_list' - String for the table views hidden heading.
                //          'items_list_navigation' - String for the table pagination hidden heading.
                //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de modelos.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-forms',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
            // 'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            'rewrite' => [
                'slug' => 'modelos'
            ],
            'show_in_rest' => true
        );
        register_post_type('models', $args);
    }
    
    private function registerCars()
    {
        $labels = array(
            'name' => __('Autos', $this->domain),
            'singular_name' => __('Auto', $this->domain),
            'add_new' => __('Nuevo auto', $this->domain),
            'add_new_item' => __('Agregar nuevo auto', $this->domain),
            'edit_item' => __('Editar auto', $this->domain),
            'new_item' => __('Nuevo auto', $this->domain),
            'view_item' => __('Ver auto', $this->domain),
            'search_items' => __('Buscar auto', $this->domain),
            'not_found' => __('Auto no encontrado', $this->domain),
            'not_found_in_trash' => __('Auto no encontrado en la papelera', $this->domain),
            'all_items' => __('Todos los autos', $this->domain),
                //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
                //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
                //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
                //          'featured_image' - Default is Featured Image.
                //          'set_featured_image' - Default is Set featured image.
                //          'remove_featured_image' - Default is Remove featured image.
                //          'use_featured_image' - Default is Use as featured image.
                //          'menu_name' - Default is the same as `name`.
                //          'filter_items_list' - String for the table views hidden heading.
                //          'items_list_navigation' - String for the table pagination hidden heading.
                //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de autos.',
            'public'              => true,
            // 'exclude_from_search' => false,
            // 'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-shield',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            'rewrite' => [
                'slug' => 'autos'
            ],
            'show_in_rest' => true
        );
        register_post_type('cars', $args);
    }
    
    private function registerCustomers()
    {
        $labels = array(
            'name' => __('Clientes', $this->domain),
            'singular_name' => __('Cliente', $this->domain),
            'add_new' => __('Nuevo cliente', $this->domain),
            'add_new_item' => __('Agregar nuevo cliente', $this->domain),
            'edit_item' => __('Editar cliente', $this->domain),
            'new_item' => __('Nuevo cliente', $this->domain),
            'view_item' => __('Ver cliente', $this->domain),
            'search_items' => __('Buscar cliente', $this->domain),
            'not_found' => __('Cliente no encontrado', $this->domain),
            'not_found_in_trash' => __('Cliente no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos los clientes', $this->domain),
                //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
                //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
                //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
                //          'featured_image' - Default is Featured Image.
                //          'set_featured_image' - Default is Set featured image.
                //          'remove_featured_image' - Default is Remove featured image.
                //          'use_featured_image' - Default is Use as featured image.
                //          'menu_name' - Default is the same as `name`.
                //          'filter_items_list' - String for the table views hidden heading.
                //          'items_list_navigation' - String for the table pagination hidden heading.
                //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de clientes.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-groups',
            // 'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
//                'author',
//                'thumbnail',
//                'page-attributes',
            // 'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
//            'rewrite' => [
//                'slug' => 'marcas'
//            ],
//            'show_in_rest' => false
        );
        register_post_type('customers', $args);
    }
    
    private function registerSliders() {
        $labels = array(
            'name' => __('Sliders', $this->domain),
            'singular_name' => __('Slider', $this->domain),
            'add_new' => __('Nuevo slider', $this->domain),
            'add_new_item' => __('Agregar nuevo slider', $this->domain),
            'edit_item' => __('Editar slider', $this->domain),
            'new_item' => __('Nuevo slider', $this->domain),
            'view_item' => __('Ver slider', $this->domain),
            'search_items' => __('Buscar slider', $this->domain),
            'not_found' => __('Slider no encontrado', $this->domain),
            'not_found_in_trash' => __('Slider no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos los sliders', $this->domain),
                //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
                //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
                //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
                //          'featured_image' - Default is Featured Image.
                //          'set_featured_image' - Default is Set featured image.
                //          'remove_featured_image' - Default is Remove featured image.
                //          'use_featured_image' - Default is Use as featured image.
                //          'menu_name' - Default is the same as `name`.
                //          'filter_items_list' - String for the table views hidden heading.
                //          'items_list_navigation' - String for the table pagination hidden heading.
                //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de slides.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-images-alt2',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
//                'editor',
                'custom-fields',
//                'author',
                'thumbnail',
                'page-attributes',
            // 'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
                // 'taxonomies'  => array('post_tag', 'category'),
                // 'has_archive' => false,
//            'rewrite' => [
//                'slug' => 'marcas'
//            ],
//            'show_in_rest' => false
        );
        register_post_type('sliders', $args);
    }

    public function unregister_post_type()
    {
        global $wp_post_types;
        
        if (isset($wp_post_types['models'])) {
            unset($wp_post_types['models']);
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function rest_filter_add_filters()
    {
        foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
            add_filter( 'rest_' . $post_type->name . '_query', array($this, 'wp_rest_filter_add_filter_param'), 10, 2 );
        }
        
        register_meta('post', 'mb_feeMonth', [
           'show_in_rest' => true,
        ]);
        
        register_meta('post', 'mb_isSold', [
           'show_in_rest' => true,
        ]);
    }
    
    /**
      * Add the filter parameter
      *
      * @param  array           $args    The query arguments.
      * @param  WP_REST_Request $request Full details about the request.
      * @return array $args.
    **/
    public function wp_rest_filter_add_filter_param( $args, $request )
    {
       // Bail out if no filter parameter is set.
       if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
           return $args;
       }
       
       $filter = $request['filter'];
       if ( isset( $filter['posts_per_page'] ) && ( (int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100 ) ) {
           $args['posts_per_page'] = $filter['posts_per_page'];
       }
       
       global $wp;
       $vars = apply_filters( 'rest_query_vars', $wp->public_query_vars );
       
       $vars = $this->allow_meta_query($vars);

       foreach ( $vars as $var ) {
           if ( isset( $filter[ $var ] ) ) {
               $args[ $var ] = $filter[ $var ];
           }
       }
       
       return $args;
    }
   
    private function allow_meta_query( $valid_vars )
    {
        $valid_vars = array_merge( $valid_vars, array( 'meta_query', 'meta_key', 'meta_value', 'meta_compare' ) );
        
        return $valid_vars;
    }
}
