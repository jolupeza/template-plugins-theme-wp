<?php

namespace AltimeaQuiz\Admin\Customposts;

class Quiz
{
    /**
     * Default slug of this landing
     *
     * @var string
     */
    private $slug = 'prueba';

    /**
     * Post type
     *
     * @var string
     */
    private $postType = 'altimea_quiz';

    private $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    public function registerPostType()
    {
        $labels = array(
            'name' => _x( 'Preguntas', $this->domain ),
            'singular_name' => _x('Pregunta', $this->domain),
            'menu_name' => _x( 'Altimea Quiz', $this->domain ),
            'add_new' => _x( 'Nueva Pregunta ', $this->domain ),
            'add_new_item' => _x( 'Agregar nueva Pregunta', $this->domain ),
            'new_item' => _x( 'Nueva Pregunta', $this->domain ),
            'all_items' => _x( 'Todas las Preguntas', $this->domain ),
            'edit_item' => _x( 'Editar Pregunta', $this->domain ),
            'view_item' => _x( 'Ver Pregunta', $this->domain ),
            'search_items' => _x( 'Buscar Preguntas', $this->domain ),
            'not_found' => _x( 'Preguntas no encontradas', $this->domain ),
            'not_found_in_trash' => __('Preguntas no encontradas en la papelera', $this->domain),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => _x('Altimea Quiz', $this->domain),
            'supports' => array( 'title', 'editor' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array('slug' => $this->slug),
            'capability_type' => 'post'
        );

        register_post_type( $this->postType, $args );
    }

    public function registerTaxonomy()
    {
        $labels = array(
            'name' => _x('Quiz Categorías', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Quiz Categorías', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Categoría', $this->domain),
            'popular_items' => __('Categorías Populares', $this->domain),
            'all_items' => __('Todas las Categorías', $this->domain),
            'parent_item' => __('Categoría Padre', $this->domain),
            'parent_item_colon' => __('Categoría Padre', $this->domain),
            'edit_item' => __('Editar Categoría', $this->domain),
            'update_item' => __('Actualizar Categoría', $this->domain),
            'add_new_item' => __('Añadir nueva Categoría', $this->domain),
            'new_item_name' => __('Nueva Categoría', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Categoría', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Quiz Categorías', $this->domain),
        );

        register_taxonomy('quiz_categories', $this->postType, array(
            'labels' => $labels,
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_in_nav_menus' => false,
            'hierarchical' => true
        ));
    }

    public function getPostType()
    {
        return $this->postType;
    }
}
