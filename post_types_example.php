<?php
/*
Plugin Name: NOUVEAU Custom Post Types Example
Plugin URI: http://nouveauframework.org/plugins/
Description: A simple reference for creating new custom post types.
Author: Matt van Andel
Version: 2.0
Author URI: http://nouveauframework.org
License: GPLv2 or later

Note that, when in doubt, you can use http://www.generatewp.com to dynamically generate new post types.

Creating Post Types:
http://codex.wordpress.org/Function_Reference/register_post_type
*/

namespace NV\Plugin\Examples;


PostTypes::init();

/**
 * Add or remove custom Post Types
 */
class PostTypes
{

    /**
     * Register hooks for adding or removing post types.
     */
    public static function init()
    {
        // Add or remove custom post types
        add_action('init', [__NAMESPACE__ . '\PostTypes', 'add_new']);
        add_action('init', [__NAMESPACE__ . '\PostTypes', 'remove_multiple']);
    }

    /**
     * CREATES A NEW POST TYPE
     *
     * Use this function only for a SINGLE post type.  Since the registration code can get big and messy, this keeps
     * things nice and neat and simple.
     *
     * This should be done within the 'init' hook.
     */
    public static function add_new()
    {

        /**
         * What is the SINGULAR name of this post type
         */
        $nameSingle = __('YOUR_LABEL', 'nvLangScope');

        /**
         * What is the PLURAL name of this post type
         */
        $namePlural = __('YOUR_PLUR_LABEL', 'nvLangScope');

        /**
         * A url-safe slug, usually singular (max 20 chars)
         */
        $nameSlug = 'your-post-slug';

        /**
         * Various friendly text strings for use with your post type.  This has been configured to automatically inherit
         * the appropriate singular and plural names.  Note that these labels don't include some other post type
         * related messages, such as update and errors.  To include those, you need to use the 'post_updated_messages'
         * filter/hook.
         *
         * Generally, you won't need to change anything here.
         */
        $labels = [
            'name'               => $namePlural,
            'singular_name'      => $nameSingle,
            'menu_name'          => $namePlural,
            'name_admin_bar'     => $namePlural,
            'all_items'          => sprintf(__('All %s', 'nvLangScope'), $namePlural),
            'add_new'            => __('Add New', 'nvLangScope'),
            'add_new_item'       => sprintf(__('Add New %s', 'nvLangScope'), $nameSingle),
            'edit_item'          => sprintf(__('Edit %s', 'nvLangScope'), $nameSingle),
            'new_item'           => sprintf(__('New %s', 'nvLangScope'), $nameSingle),
            'view_item'          => sprintf(__('View %s', 'nvLangScope'), $nameSingle),
            'search_items'       => sprintf(__('Search %s', 'nvLangScope'), $namePlural),
            'not_found'          => sprintf(__('No %s found', 'nvLangScope'), $namePlural),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'nvLangScope'), $namePlural),
            'parent_item_colon'  => sprintf(__('Parent: %s', 'nvLangScope'), $nameSingle),

        ];

        $args = [

            'labels'               => $labels,

            /**
             * This isn't used anywhere in core, but you are able to use it in your theme or admin.
             */
            'description'          => __('', 'nvLangScope'), //string

            /**
             * Whether the post type should be used "publicly" by the admin or by front-end users.  This is used as a
             * default setting by many of the following arguments, but you are always better off setting each option
             * individually instead of relying on this one argument.
             */
            'public'               => true, // bool (default: false)

            /**
             * Whether queries can be performed on the front-end as part of parse_request().
             */
            'publicly_queryable'   => true, // bool (default: 'public' value)

            /**
             * Whether to exclude content of this post type from front-end search results.
             */
            'exclude_from_search'  => false, // bool (default: 'public' value)

            /**
             * Whether individual post type items are available for selection in the menus admin.
             */
            'show_in_nav_menus'    => true, // bool (default: 'public' value)

            /**
             * Whether to generate a default UI for managing this post type in the admin. You'll have
             * more control over what's shown in the admin with the other arguments.  To build your
             * own UI, set this to FALSE.
             */
            'show_ui'              => true, // bool (default: 'public' value)

            /**
             * Whether to show post type in the admin menu. If TRUE, a new meny item will be added to the bottom of the
             * WordPress admin menu while FALSE will not create any new menu items for you. Alternatively, you can
             * specify an existing menu (as a string) to add this post type as a sub-menu item instead (e.g. edit.php or
             * edit.php?post_type=page). NOTE: 'show_ui' must be true for this to have any effect.
             */
            'show_in_menu'         => true, // bool (default: 'show_ui' value)

            /**
             * Whether to make this post type available in the WordPress admin bar. The admin bar adds a link to add a
             * new post type item.
             */
            'show_in_admin_bar'    => true, // bool (defaults: 'show_in_menu' value)

            /**
             * The position in the menu order the post type should appear. 'show_in_menu' must be true for this to work.
             * This value can be null or an integer between 0 and 100. A value of 20 would place this after "Pages"
             * while a value of 25 would come after "Comments".
             */
            'menu_position'        => 20, // integer (default: 25 - below "Comments")

            /**
             * The URI to the icon to use for the admin menu item. There is no header icon argument, so you'll need to
             * use CSS to add one.
             */
            'menu_icon'            => null, // string (uses the post icon by default)


            /**
             * Whether the posts of this post type can be exported via the WordPress import/export plugin or a similar
             * plugin.
             */
            'can_export'           => true, // bool (default: TRUE)

            /**
             * Whether to delete posts of this type when deleting a user who has written posts.
             */
            'delete_with_user'     => false, // bool (default: TRUE - if the post type supports 'author')

            /**
             * Whether this post type should allow hierarchical (parent/child/grandchild/etc.) posts. If TRUE, behaves
             * like pages (with levels). If FALSE, behaves like blog posts (flat).
             */
            'hierarchical'         => false, // bool (default: FALSE)

            /**
             * Whether the post type has an index/archive/root page like the "page for posts" for regular posts. If set
             * to TRUE, the post type name will be used for the archive slug.  You can also set this to a string to
             * control the exact name of the archive slug.
             */
            'has_archive'          => true, // bool|string (default: FALSE)

            /**
             * Sets the query_var key for this post type. If set to TRUE, the post type name/slug will be used. You can
             * also set this to a custom string to control the exact key.
             */
            'query_var'            => true, // bool|string (default: TRUE - post type name)


            /**
             * A string used to build the edit, delete, and read capabilities for posts of this type. You can use a
             * string or an array (for singular and plural forms).  The array is useful if the plural form can't be made
             * by simply adding an 's' to the end of the word.  For example, array( 'box', 'boxes' ).
             */
            'capability_type'      => 'post', // string|array (default: 'post')

            /**
             * Whether WordPress should map the meta capabilities (edit_post, read_post, delete_post) for you.  If set
             * to FALSE, you'll need to roll your own handling of this by using the 'map_meta_cap' filter/hook.
             */
            'map_meta_cap'         => true, // bool (defaults: FALSE)

            /**
             * An array listing any EXISTING taxonomies you want to add to this post type. If a taxonomy is not already
             * registered when this post type is registered, you will need to use register_taxonomy() after the fact.
             */
            'taxonomies'           => [], // array

            /**
             * A callback that can be used to add meta boxes (custom UI) to your post edit screens for this post type.
             * You will need to use add_meta_box() and/or remove_meta_box() from within the specified callback.
             */
            'register_meta_box_cb' => null, // callback


            /**
             * How the URL structure should be handled with this post type.  You can set this to an
             * array of specific arguments or true|false.  If set to FALSE, it will prevent rewrite
             * rules from being created.
             */
            'rewrite'              => [

                /* The slug to use for individual posts of this type. */
                'slug'       => null, // string (defaults to the post type name)

                /* Whether to show the $wp_rewrite->front slug in the permalink. */
                'with_front' => false, // bool (defaults to TRUE)

                /* Whether to allow single post pagination via the <!--nextpage--> quicktag. */
                'pages'      => true, // bool (defaults to TRUE)

                /* Whether to create feeds for this post type. */
                'feeds'      => true, // bool (defaults to the 'has_archive' argument)

                /* Assign an endpoint mask to this permalink. */
                'ep_mask'    => EP_PERMALINK, // const (defaults to EP_PERMALINK)
            ],

            /**
             * What WordPress features the post type supports.  Many arguments are strictly useful on the edit post
             * screen in the admin.  However, this will help other themes and plugins decide what to do in certain
             * situations.  You can pass an array of specific features or set it to FALSE to prevent any features from
             * being added.  You can use add_post_type_support() to add features or remove_post_type_support() to remove
             * features later.  The default features are 'title' and 'editor'.
             */
            'supports'             => [

                /* Post titles ($post->post_title). */
                'title',

                /* Post content ($post->post_content). */
                'editor',

                /* Post excerpt ($post->post_excerpt). */
                'excerpt',

                /* Post author ($post->post_author). */
                'author',

                /* Featured images (the user's theme must support 'post-thumbnails'). */
                'thumbnail',

                /* Displays comments meta box.  If set, comments (any type) are allowed for the post. */
                'comments',

                /* Displays meta box to send trackbacks from the edit post screen. */
                'trackbacks',

                /* Displays the Custom Fields meta box. Post meta is supported regardless. */
                'custom-fields',

                /* Displays the Revisions meta box. If set, stores post revisions in the database. */
                'revisions',

                /* Displays the Attributes meta box with a parent selector and menu_order input box. */
                'page-attributes',

                /* Displays the Format meta box and allows post formats to be used with the posts. */
                'post-formats',

                /* Allows use of pre-registered taxonomies with this post type */
                'taxonomies',
            ],

            /**
             * Provides more precise control over the capabilities than the defaults.  By default, WordPress will use
             * the 'capability_type' argument to build these capabilities.  More often than not, this results in many
             * extra capabilities that you probably don't need.  The following is how I set up capabilities for many
             * post types, which only uses three basic capabilities you need to assign to roles: 'manage_examples',
             * 'edit_examples', 'create_examples'. Each post type is unique though, so you'll want to adjust it to fit
             * your needs.
             */
            /*
            'capabilities' => array(

                // meta caps (don't assign these to roles)
                'edit_post'              => 'edit_'.$nameSingle,
                'read_post'              => 'read_'.$nameSingle,
                'delete_post'            => 'delete_'.$nameSingle,

                // primitive/meta caps
                'create_posts'           => 'create_'.$namePlural,

                // primitive caps used outside of map_meta_cap()
                'edit_posts'             => 'edit_'.$namePlural,
                'edit_others_posts'      => 'manage_'.$namePlural,
                'publish_posts'          => 'manage_'.$namePlural,
                'read_private_posts'     => 'read_private_'.$namePlural,

                // primitive caps used inside of map_meta_cap()
                'read'                   => 'read_'.$namePlural,
                'delete_posts'           => 'manage_'.$namePlural,
                'delete_private_posts'   => 'manage_'.$namePlural,
                'delete_published_posts' => 'manage_'.$namePlural,
                'delete_others_posts'    => 'manage_'.$namePlural,
                'edit_private_posts'     => 'edit_'.$namePlural,
                'edit_published_posts'   => 'edit_'.$namePlural,
            ),
            */

        ];

        // REGISTER THE NEW POST TYPE....
        register_post_type($nameSlug, $args);

    }


    /**
     * Remove / unregister any existing post types.
     *
     * Simply uncomment to activate removal of posts or pages.
     */
    public static function remove_multiple()
    {
        // Remove the default blog-centric "post" post type
        //self::remove( 'post' );

        // Remove the default "page" post type
        //self::remove( 'page' );

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
    public static function remove($post_type)
    {
        global $wp_post_types;

        if (isset($wp_post_types[$post_type])) {
            unset($wp_post_types[$post_type]);
            return true;
        }

        return false;
    }

}
