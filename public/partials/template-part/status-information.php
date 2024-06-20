<div class="mb-4 mt-4">
    <?php if( $status == '300' || is_array($status) && in_array( '200', $status ) ) { ?>
        <h3 class="text-danger">Revocation Requested</h3>
    <?php } ?>
</div>

