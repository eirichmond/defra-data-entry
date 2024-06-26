<?php
global $post;
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$approver_counties = $class->get_exemption_countries();
$user = wp_get_current_user();
$roles = $user->roles;
$reviewer_id = get_post_meta( $post->ID, 'reviewer_user_id', true );
$country_approver_key = get_user_meta( $user->ID, 'approver_country_id', true );
$approver_id = get_post_meta( $post->ID, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user', true );
$revoke_assigned_da_id = get_post_meta( $post->ID, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_user_id' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_user_id', true );
if(isset($_GET) && !empty($_GET["revoked"])) {
    $revoked = $_GET["revoked"];
}
?>

<?php if ( in_array('data_reviewer', $roles) && empty($reviewer_id) || in_array('data_reviewer', $roles) && $revoked ) { ?>

    <a href="<?php echo the_permalink(); ?>" class="defra-assign" data-role="data_reviewer" data-nonce="<?php echo wp_create_nonce('defra-assign'); ?>" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-user_id="<?php echo esc_attr( $user->ID ); ?>" title="Assign to me" ><i class="gg-lock"></i></a>

<?php } elseif ( in_array('data_approver', $roles) && empty($approver_id) ) { ?>
    
    <a href="<?php echo the_permalink(); ?>" class="defra-assign" data-role="data_approver" data-nonce="<?php echo wp_create_nonce('defra-assign'); ?>" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-user_id="<?php echo esc_attr( $user->ID ); ?>" title="Assign to me" ><i class="gg-lock"></i></a>
    
<?php } elseif ( in_array('data_approver', $roles) && !empty($approver_id) ) { ?>

    <a href="<?php echo the_permalink(); ?>" title="Review"><i class="gg-eye"></i></a>

<?php } elseif ( in_array('data_approver', $roles) && empty($revoke_assigned_da_id) ) { ?>

    <!-- not clear if this will ever been needed -->
    <a href="<?php echo the_permalink(); ?>" class="defra-assign" data-role="data_approver" data-nonce="<?php echo wp_create_nonce('defra-assign'); ?>" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-user_id="<?php echo esc_attr( $user->ID ); ?>" data-revoked="true" title="Assign to me" ><i class="gg-lock"></i></a>

<?php } else { ?>

    <a href="<?php echo the_permalink(); ?>" title="Review"><i class="gg-eye"></i></a>

<?php } ?>


