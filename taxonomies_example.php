<?php
/*
Plugin Name: NOUVEAU Custom Taxonomies Example
Plugin URI: http://nouveauframework.org/plugins/
Description: A simple reference for creating new taxonomies.
Author: Matt van Andel
Version: 2.0
Author URI: http://nouveauframework.org
License: GPLv2 or later

Note that, when in doubt, you can use http://www.generatewp.com to dynamically generate new taxonomies.

Creating Taxonomies:
http://codex.wordpress.org/Function_Reference/register_taxonomy
*/

namespace NV\Plugin\Examples;


/**
 * Add or remove custom taxonomies
 *
 * @package NV\Plugin\Examples
 */
class Taxonomies
{

    /**
     * Register hooks for adding or removing taxonomies.
     */
    public static function init()
    {
        // Add or remove custom taxonomies
        add_action('init', [__NAMESPACE__ . '\Taxonomies', 'add_new']);
        add_action('init', [__NAMESPACE__ . '\Taxonomies', 'remove_multiple']);
    }

    /**
     * CREATES A NEW TAXONOMY
     *
     * Use this function only for a SINGLE taxonomy. Since the registration code can get big and messy, this keeps things
     * nice and neat and simple.
     *
     * This should be done within the 'init' hook.
     */
    public static function add_new()
    {

        // Human-readable label text
        $nameSingle = __('YOUR LABEL HERE', 'nvLangScope');
        $namePlural = __('YOUR PLURAL LABEL HERE', 'nvLangScope');

        // A url-safe slug, usually singular (max 20 chars)
        $nameSlug = 'your-tax-slug-here';

        // Specifies the text that will be displayed in the various WordPress UIs
        $labels = [
            'name'                       => $namePlural,
            'singular_name'              => $nameSingle,
            'menu_name'                  => $namePlural,
            'all_items'                  => sprintf(__('All %s', 'nvLangScope'), $namePlural),
            'edit_item'                  => sprintf(__('Edit %s', 'nvLangScope'), $nameSingle),
            'view_item'                  => sprintf(__('View %s', 'nvLangScope'), $nameSingle),
            'update_item'                => sprintf(__('Update %s', 'nvLangScope'), $nameSingle),
            'add_new_item'               => sprintf(__('Add New %s', 'nvLangScope'), $nameSingle),
            'new_item_name'              => sprintf(__('New %s Name', 'nvLangScope'), $nameSingle),
            'parent_item'                => sprintf(__('Parent %s', 'nvLangScope'), $nameSingle),
            'parent_item_colon'          => sprintf(__('Parent: %s', 'nvLangScope'), $nameSingle),
            'search_items'               => sprintf(__('Search %s', 'nvLangScope'), $namePlural),
            'popular_items'              => sprintf(__('Popular %s', 'nvLangScope'), $namePlural),
            'separate_items_with_commas' => sprintf(__('Separate %s with commas', 'nvLangScope'), $namePlural),
            'add_or_remove_items'        => sprintf(__('Add or remove %s', 'nvLangScope'), $namePlural),
            'choose_from_most_used'      => sprintf(__('Choose from most used %s', 'nvLangScope'), $namePlural),
            'not_found'                  => sprintf(__('No %s found.', 'nvLangScope'), $namePlural),
        ];

        // An array of post types (by slug) to attach to this taxonomy
        $post_types = [
            'post',
            'your-post-slug-here',
        ];

        // All the taxonomies configuration options
        $config = [
            // The primary taxonomy label (human-readable, plural)
            'label'             => $namePlural,

            // The array of labels that we defined above
            'labels'            => $labels,

            // true = CATEGORY STYLE || false = TAG STYLE
            'hierarchical'      => true,

            // true = automatically create admin UI || false = hide admin ui
            'show_ui'           => true,

            // true = allow this to be selected in menus
            'show_in_nav_menus' => true,

            // true = intended to be used publicly || false = programmatic use only
            'public'            => true,

            // true = automatically show terms in admin list table columns
            'show_admin_column' => true,

            // true = allow taxonomy in tag cloud widget || false = hide from tag cloud widget
            'show_tagcloud'     => false,

            // false = do not allow queries in WordPress || (string) to customize query var (?$query_var=$term)
            'query_var'         => $nameSlug,

            // Uncomment to configure custom rewrite rules. Leave it alone for default behavior.
            /*
            'rewrite' => [
                // What wil be used in the permalink. e.g. /my-tax-slug/
                'slug'         => $nameSlug,

                // true = allow links to use front base || false = do not prepend urls with front base
                'with_front'   => true,

                // true = allow hierarchical URLs || false = use flat urls
                'hierarchical' => false,

                // See: http://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/
                'ep_mask'      => EP_NONE,
            ],
            */
        ];

        // Finally, register the taxonomy with WordPress
        register_taxonomy(
            $nameSlug,
            $post_types,
            $config
        );

    }


    /**
     * Remove / unregister any existing taxonomies.
     *
     * Simply uncomment to remove built-in taxonomies from built-in post types
     */
    public static function remove_multiple()
    {

        // Remove the "categories" taxonomy from posts
        //self::remove( 'category', 'post' );

        // Remove the "tags" taxonomy from posts
        //self::remove( 'post_tag', 'post' );
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
    public static function remove($taxonomy, $object_type)
    {
        global $wp_taxonomies;

        if (!isset($wp_taxonomies[$taxonomy])) {
            return false;
        }

        if (!get_post_type_object($object_type)) {
            return false;
        }

        foreach (array_keys($wp_taxonomies[$taxonomy] -> object_type) as $array_key) {
            if ($object_type == $wp_taxonomies[$taxonomy] -> object_type[$array_key]) {
                unset ($wp_taxonomies[$taxonomy] -> object_type[$array_key]);
                return true;
            }
        }

        return false;

    }
}