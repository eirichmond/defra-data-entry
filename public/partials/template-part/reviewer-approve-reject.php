<div class="mb-3">


    <?php if( !isset($revoked) ) { ?>

        <?php if( $count == 1 && $status[0] == '20' || $status[0] == '30' ) { ?>
            <button id="approved-by-dr" class="btn btn-success" type="submit" name="status" value="approve">Approve</button>
            <button id="rejected-by-dr" class="btn btn-danger" type="submit" name="status" value="reject">Reject</button>
        <?php } ?>
        
    <?php } ?>
    
    <?php if( in_array( '600', $status ) && empty($revoked[0]) ) { ?>

        <button class="btn btn-success" type="submit" name="status" value="cancel">Request Cancellation / Revocation</button>
        
    <?php } ?>

    <?php if( in_array( '1', $revoked ) && current_user_can( 'data_reviewer' ) ) { ?>
        <button id="approve-revocation-by-dr" class="btn btn-success" type="submit" name="status" value="approve-revocation">Approve Revocation</button>
    <?php } ?>

</div>




