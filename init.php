<?php
/*
Plugin Name: NOUVEAU Semantic Custom Types & Taxonomies Example
Plugin URI: http://nouveauframework.com/plugins/
Description: A simple starting point for creating new post types and/or taxonomies.
Author: Matt Van Andel
Version: 0.1
Author URI: http://mattstoolbox.com/
License: GPLv2 or later

Note that, when in doubt, you can use http://www.generatewp.com to dynamically generate new post types and taxonomies.

Creating Taxonomies:
http://codex.wordpress.org/Function_Reference/register_taxonomy

Creating Post Types:
http://codex.wordpress.org/Function_Reference/register_post_type
*/

NV_Example_TypesAndTax::init();

class NV_Example_TypesAndTax {

    /**
     * INITIALIZE...
     *
     * This adds all of our hooks and runs whatever code we need it to. We create one new hook for each new post type
     * or taxonomy we want to add (to keep things tidy).
     */
    public static function init() {
        add_action('init', array( __CLASS__, 'unregister_types_taxes' ) );
        add_action('init', array( __CLASS__, 'add_type_mytype' ) );
        add_action('init', array( __CLASS__, 'add_tax_mytax' ) );
    }


    /**
     * REMOVE POST TYPES OR TAXONOMIES
     *
     * Remove registered or default post types or taxonomies.
     */
    public static function unregister_types_taxes () {
        // Remove the default blog-centric "post" post type
        //self::unregister_post_type('post');

        // Remove the default "page" post type
        //self::unregister_post_type('page');

        // Remove the "categories" taxonomy from posts
        //self::unregister_taxonomy('category','post');

        // Remove the "tags" taxonomy from posts
        //self::unregister_taxonomy('post_tag','post');
    }


    /**
     * CREATES A NEW POST TYPE
     *
     * Use this function only for a SINGLE post type. Since the registration code can get big and messy, this keeps things
     * nice and neat and simple.
     *
     * This should be done within the 'init' hook.
     */
    public static function add_type_mytype() {

        $nameSingle = __('YOUR_LABEL_HERE','nvLangScope');
        $namePlural = __('YOUR_LABEL_HERES','nvLangScope');
        $nameSlug   = 'your-post-slug-here';                 // a url-safe slug, usually singular (max 20 chars)
        $labels = array (
            'name'              => $namePlural,
            'singular_name'     => $nameSingle,
            'menu_name'         => $namePlural,
            'all_items'         => sprintf(__('All %s','nvLangScope'), $namePlural),
            'add_new'           => __('Add New','nvLangScope'),
            'add_new_item'      => sprintf(__('Add New %s','nvLangScope'), $nameSingle),
            'edit_item'         => sprintf(__('Add New %s','nvLangScope'), $nameSingle),
            'new_item'          => sprintf(__('New %s','nvLangScope'), $nameSingle),
            'view_item'         => sprintf(__('View %s','nvLangScope'), $nameSingle),
            'search_items'      => sprintf(__('Search %s','nvLangScope'), $namePlural),
            'not_found'         => sprintf(__('No %s found','nvLangScope'), $namePlural),
            'not_found_in_trash'=> sprintf(__('No %s found in trash','nvLangScope'), $namePlural),
            'parent_item_colon' => sprintf(__('Parent: %s','nvLangScope'), $nameSingle),
        );

        // REGISTER THE NEW POST TYPE....
        register_post_type(
            $nameSlug,                                      // a url-safe slug, usually singular (max 20 chars)
            array(
                'label'             => $nameSingle,         // visible name, plural
                'description'       => __('','nvLangScope'),// a short description of this post type
                'public'            => true,                // true = intended to be used publicly || false = programmatic use only
                'show_ui'           => true,                // true = automatically create admin UI || false = hide admin ui
                'show_in_menu'      => true,                // true = add to bottom of admin menu || false = do not create an admin menu || (string) specify an existing menu (edit.php or edit.php?post_type=page) to make this a sub-menu item instead
                'menu_position'     => 20,                  // integer. 0 - 100. Determines where to place this in the admin menu. (20 = after "Pages")
                'show_in_nav_menus' => true,                // true = allow this to be selected in menus
                //'menu_icon'         => '',                  // a url for the menu icon, if desired
                'hierarchical'      => false,               // true = allow parent pages || false = flat/blog style content structure
                'query_var'         => true,                // false = do not allow queries in WordPress || (string) to customize query var (?$query_var=$term)
                'capability_type'   => 'post',              // what should be used to inherit basic permissions? (choose: post, page)
                'has_archive'       => true,                // true = automatically reserve an archive page || false = disable archive page for this post type
                'can_export'        => true,                // true = allow this data to be exported with the WordPress export tool
                //'taxonomies'        => array(),             // an array of EXISTING taxonomy slugs to inherit
                //'register_meta_box_cb'=> array(),           // a callback that creates custom admin UI on the edit screen. Use remove_meta_box() and add_meta_box() in this callback
                //'rewrite'           => array(
                    //'slug'              => $nameSlug,               // What will be used in the permalink. e.g. /my-post-slug/...
                    //'with_front'        => true,                    // true = allow links to use front base || false = do not prepend urls with front base
                    //'feeds'             => false,                   // true = generate a feed for this post type || false = no feeds
                    //'pages'             => true,                    // true = allow for pagination || false = disable pagination
                    //'ep_mask'           => EP_NONE,                 // See: http://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/
                //),
                'supports'          => array(               // a list of features supported by this post type
                    'title',
                    'editor',
                    //'author',
                    //'thumbnail',
                    //'excerpt',
                    //'trackbacks',
                    //'custom-fields',
                    //'comments',
                    'revisions',
                    'page-attributes',
                    //'post-formats',
                ),
                //'capabilities'      => array(               // set the capabilities used for this post type
                    //'edit_posts',
                    //'edit_others_posts',
                    //'publish_posts',
                    //'read_private_posts',
                    //'edit_post',  //meta capability
                    //'read_post',  //meta capability
                    //'delete_post' //meta capability
                //),
                'labels' => $labels,
            )
        );

    }

    /**
     * CREATES A NEW TAXONOMY
     *
     * Use this function only for a SINGLE taxonomy. Since the registration code can get big and messy, this keeps things
     * nice and neat and simple.
     *
     * This should be done within the 'init' hook.
     */
    public static function add_tax_mytax() {

        $nameSingle = __('YOUR_LABEL_HERE','nvLangScope');
        $namePlural = __('YOUR_LABEL_HERES','nvLangScope');
        $nameSlug   = 'your-tax-slug-here';                     // a url-safe slug, usually singular (max 20 chars)
        $labels = array(                              // what text to show in various WP UI
            'name'          => $namePlural,
            'singular_name' => $nameSingle,
            'menu_name'     => $namePlural,
            'all_items'     => sprintf(__('All %s','nvLangScope'), $namePlural),
            'edit_item'     => sprintf(__('Edit %s','nvLangScope'), $nameSingle),
            'view_item'     => sprintf(__('View %s','nvLangScope'), $nameSingle),
            'update_item'   => sprintf(__('Update %s','nvLangScope'), $nameSingle),
            'add_new_item'  => sprintf(__('Add New %s','nvLangScope'), $nameSingle),
            'new_item_name' => sprintf(__('New %s Name','nvLangScope'), $nameSingle),
            'parent_item'   => sprintf(__('Parent %s','nvLangScope'), $nameSingle),
            'parent_item_colon' => sprintf(__('Parent: %s','nvLangScope'), $nameSingle),
            'search_items' => sprintf(__('Search %s','nvLangScope'), $namePlural),
            'popular_items' => sprintf(__('Popular %s','nvLangScope'), $namePlural),
            'separate_items_with_commas' => sprintf(__('Separate %s with commas','nvLangScope'), $namePlural),
            'add_or_remove_items' => sprintf(__('Add or remove %s','nvLangScope'), $namePlural),
            'choose_from_most_used'  => sprintf(__('Choose from most used %s','nvLangScope'), $namePlural),
            'not_found'  => sprintf(__('No %s found.','nvLangScope'), $namePlural),
        );

        // REGISTER THE NEW TAXONOMY
        register_taxonomy(
            $nameSlug,                                          // a url-safe slug, usually singular (max 20 chars)
            array ( 'post', 'your-post-slug-here', ),           // an array of post types (by slug) to associate with this taxonomy
            array(
                'label'             => $namePlural,             // visible name, plural
                'hierarchical'      => true,                    // true = CATEGORY STYLE || false = TAG STYLE
                'show_ui'           => true,                    // true = automatically create admin UI || false = hide admin ui
                'show_in_nav_menus' => true,                    // true = allow this to be selected in menus
                'public'            => true,                    // true = intended to be used publicly || false = programmatic use only
                'show_admin_column' => true,                    // true = automatically show terms in admin list table columns
                'show_tagcloud'     => false,                   // true = allow taxonomy in tag cloud widget || false = hide from tag cloud widget
                //'query_var'         => $nameSlug,               // false = do not allow queries in WordPress || (string) to customize query var (?$query_var=$term)
                //'rewrite'           => array(
                    //'slug'              => $nameSlug,               // What wil be used in the permalink. e.g. /my-tax-slug/
                    //'with_front'        => true,                    // true = allow links to use front base || false = do not prepend urls with front base
                    //'hierarchical'      => false,                   // true = allow hierarchical URLs || false = use flat urls
                    //'ep_mask'           => EP_NONE,                 // See: http://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/
                //),
                'labels' => $labels,
            )
        );

    }


    /**
     * Remove post types.
     *
     * WARNING: This should only be called from within an 'init' action hook.
     *
     * @global array $wp_post_types
     *
     * @param string $post_type
     *
     * @return boolean Returns true if post type was found and removed.
     */
    public static function unregister_post_type( $post_type ) {
        global $wp_post_types;

        if ( isset( $wp_post_types[ $post_type ] ) ) {
            unset( $wp_post_types[ $post_type ] );
            return true;
        }

        return false;
    }


    /**
     * Remove a registered taxonomy from an object type.
     *
     * WARNING: This should only be called from within an 'init' action hook.
     *
     * @global array $wp_taxonomies
     *
     * @param string $taxonomy
     * @param string $object_type
     *
     * @return boolean True if successful, false if not
     */
    public static function unregister_taxonomy( $taxonomy, $object_type ) {
        global $wp_taxonomies;

        if ( !isset( $wp_taxonomies[ $taxonomy ] ) ) {
            return false;
        }

        if ( !get_post_type_object( $object_type ) ) {
            return false;
        }

        foreach ( array_keys( $wp_taxonomies[ $taxonomy ]->object_type ) as $array_key ) {
            if ( $object_type == $wp_taxonomies[ $taxonomy ]->object_type[ $array_key ] ) {
                unset ( $wp_taxonomies[ $taxonomy ]->object_type[ $array_key ] );
                return true;
            }
        }

        return false;

    }

}