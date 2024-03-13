<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

    <?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
        <div class="alert alert-success" role="alert">
            New Statutory Instrument Successfully Added!
        </div>
    <?php } else { ?>

        <form class="row" action="/data-entry/form-process/" method="post">
            <div class="row">
                <div class="row mb-3">

                    <label for="si_type" class="col-sm-2 col-form-label">Type</label>

                    <div class="col-sm-10">
                        
                        <select class="form-select" aria-label="select" name="si_type">
                            <option selected disabled value="">Select Type</option>
                            <option value="appliance">Appliance</option>
                            <option value="fuel">Fuel</option>
                        </select>

                    </div>

                </div>

                <div class="row mb-3">
                    
                    <label for="post_title" class="col-sm-2 col-form-label">SI No.</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="post_title" name="post_title">
                    </div>

                </div>

                <div class="row mb-3">
                    
                    <label for="post_content" class="col-sm-2 col-form-label">SI URL Link</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="post_content" name="post_content">
                    </div>

                </div>

                <div class="row mb-3">
                    
                    <label for="si_countries" class="col-sm-2 col-form-label">Country</label>

                    <div class="col-sm-10">

                        <select class="form-select" multiple aria-label="select" id="si_countries" name="si_countries[]">
                            <option selected disabled>Select Country</option>
                            <option value="england">England</option>
                            <option value="n-ireland">N. Ireland</option>
                            <option value="scotland">Scotland</option>
                            <option value="wales">Wales</option>
                        </select>
                    </div>

                </div>


                <div class="col-4">

                    <input type="hidden" name="entry" value="defra_statutory_instrument">
                    <input type="hidden" name="process" value="create-statutory-instrument">
                    <?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>
    
                    <button type="submit" class="btn btn-primary mt-3">Save</button>

                </div>

            </div>
            
        </form>
        
    <?php } ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>