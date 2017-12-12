<?php
/*
    Plugin Name: Plugin Pop-Up
    Description: Création de Pop-Up sur  wordpress
    Version: 0.0.1
    Author: ElStrremon
    License: free
*/

add_action("wp_enqueue_scripts", "custom_scripts");
function custom_scripts(){
    wp_enqueue_script("popup_script", plugin_dir_url("./")."/plugin_popup/script.js", array( "jquery" ));
    wp_enqueue_style( "popup_styles", plugin_dir_url( "./" )."/plugin_popup/styles.css" );
}

//Actions hooks
add_action( "init", "create_pop_up_post_type");
function create_pop_up_post_type(){

    register_post_type( "pop-up", [

        "labels" => [
            "name" => "Pop-Up",
            "singular_name" => "Pop-Up",
            "all_items " => "Toutes les Pop-Up",
            "add_new " => "Créer une Pop-Up"
        ],
        "description" => "Création de fenêtre Pop-Up sur votre site web",
        "show_in_menu" => true,
        "public" => true,
        "menu_icon" => "dashicons-star-half",
        "menu_position" => 2,
        "supports" => [
            "title",
            "editor",
            "revisions",
            "thumbnail"
        ]

    ] );

}
add_shortcode( "popup", "display_shortcode" );
function display_shortcode( $atts ){

    $popup = new WP_Query( [
        "post_type" => "pop-up"
    ] );

    $dom = "<div id='popup'>";
    $dom .= "<div class='close'>x</div>";

    if( $popup->have_posts() ){

        while( $popup->have_posts() ){

            $popup->the_post();

            $title = get_the_title();
            $content = get_the_content();
            $thumbnail_url = get_the_post_thumbnail_url( null, "thumbnail" );

            $dom .= "<div class='popup-window'>";
                $dom .= "<div class='popup-content'>";
                    $dom .= "<h3>".$title."</h3>";
                    $dom .= "<p>".$content."</p>";
                $dom .= "</div>";
                $dom .= "<img src='".$thumbnail_url."' />";
            $dom .= "</div>";
        }

    }

    $dom .= "</div>";

    return $dom;

}