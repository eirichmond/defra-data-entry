<?php
/**
 * all action hooks for markup
 */
add_action('before_main_content', 'before_main_content_callback', 10);
function before_main_content_callback(){

    echo '<main id="primary"><div class="py-6">';
    
}

add_action('after_main_content', 'after_main_content_callback', 10);
function after_main_content_callback(){
    echo '</div></main>';
}