<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$list_fuel_sis = $class->get_list_sis_by_term( 'fuel' );
$taxonomy = 'si_countries'; // Replace with your taxonomy name
$countries = get_terms( array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => false, // Set to true to only get terms with posts
) );
get_header();
?>

<?php do_action('before_main_content'); ?>

    <h1 class="entry-title"><?php the_title(); ?></h1>

    <?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
        <div class="alert alert-success" role="alert">
            SI Appliance updated successfully!
        </div>
    <?php } ?>


    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_fuel_sis as $k => $v) { $json_string = json_encode($v["country_term_id"]); ?>
                <tr>
                    <td style="width:5%"><?php echo esc_html( $v['id'] ); ?></td>
                    <td style="width:55%"><?php echo esc_html( $v['number'] ); ?></td>
                    <td style="width:55%"><?php echo esc_html( $v['link'] ); ?></td>
                    <td style="width:20%; text-align:right;">
                        <a class="btn btn-link edit-si-edit" data-deid="<?php echo esc_html( $v['id'] ); ?>" data-denumber="<?php echo esc_html( $v['number'] ); ?>" data-delink="<?php echo esc_html( $v['link'] ); ?>" data-decountries="<?php echo esc_html($json_string); ?>" data-bs-toggle="modal" data-bs-target="#editModal" href="#" role="button">Edit</a>
                    </td>

                </tr>

            <?php } ?>
        </tbody>
    </table>

    <!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Fuel SI</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="siForm" action="/data-entry/form-process/" method="post">


            <div class="mb-3 row">
                <label for="denumber" class="col-sm-2 col-form-label">SI No.</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="denumber" id="denumber" value="">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="delink" class="col-sm-2 col-form-label">SI URL Link</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="delink" id="delink" value="">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <select id="countryTerms" name="countries[]" class="form-select" multiple aria-label="Multiple select example">

                    <?php foreach ($countries as $country_term) { ?>
                        <option value="<?php echo esc_html( $country_term->term_id ); ?>"><?php echo esc_html( $country_term->name ); ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <?php wp_nonce_field( 'update_si_appliance', 'update_si_appliance_field' ); ?>
            <input type="hidden" class="form-control" name="rd" value="fuel">
            <input type="hidden" class="form-control" name="process" value="update-statutory-instrument">
            <input type="hidden" class="form-control" name="deid" id="deid" value="">


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="saveChanges" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>