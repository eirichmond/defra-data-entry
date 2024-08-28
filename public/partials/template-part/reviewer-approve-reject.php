<div class="mb-3">

    <?php if( $count == 1 && $status[0] == '20' ) { ?>
        <button id="approved-by-dr" class="btn btn-success" type="submit" name="status" value="approve">Approve</button>
        <button id="rejected-by-dr" class="btn btn-danger" type="submit" name="status" value="reject">Reject</button>
    <?php } ?>
    
    <?php if( in_array( '600', $status ) && empty($revoked[0]) ) { ?>

        <button class="btn btn-success" type="submit" name="status" value="cancel">Request Cancellation / Revocation</button>
        
    <?php } ?>

    <?php if( in_array( '1', $revoked ) ) { ?>
        <button class="btn btn-success" type="submit" name="status" value="approve-revocation">Approve Revocation</button>
    <?php } ?>

</div>




