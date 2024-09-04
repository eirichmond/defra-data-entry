<div class="mb-2">
    <?php if( $revoked ) { ?>
        <button id="approved-revocation-by-da" class="btn btn-success" type="submit" name="status" value="approved-revocation-by-da">Approve Revocation</button>
        <button id="rejected-revocation-by-da" class="btn btn-danger" type="submit" name="status" value="rejected-revocation-by-da">Reject Revocation</button>
    <?php } else { ?>
        <button id="approved-by-da" class="btn btn-success" type="submit" name="status" value="approved-by-da">Approve <?php echo esc_html( $post->post_type == 'appliances' ? 'Appliance' : 'Fuel' ); ?></button>
        <button class="btn btn-danger" type="submit" name="status" value="rejected-by-da">Reject <?php echo esc_html( $post->post_type == 'appliances' ? 'Appliance' : 'Fuel' ); ?></button>
    <?php } ?>
</div>

