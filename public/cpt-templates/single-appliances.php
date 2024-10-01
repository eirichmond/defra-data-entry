<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Defra_Data
 */

get_header();
function manufacturer_by_id($manufacturer_id) {
	$manufacturer = get_post($manufacturer_id);
	return $manufacturer->post_title;
}

$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');

$appliance_data_details = $public_class->appliance_data_details($post->ID);

$exempt_england = get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_england_si', true);
$exempt_wales = get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_wales_si', true);
$exempt_scotland = get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_scotland_si', true);
$exempt_ireland = get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_n_ireland_si', true);

$statutory_instruments_england = $public_class->statutory_instrument_assignment( $post->ID, 'england', 'appliance' );
$statutory_instruments_wales = $public_class->statutory_instrument_assignment( $post->ID, 'wales', 'appliance'  );
$statutory_instruments_scotland = $public_class->statutory_instrument_assignment( $post->ID, 'scotland', 'appliance'  );
$statutory_instruments_n_ireland = $public_class->statutory_instrument_assignment( $post->ID, 'n_ireland', 'appliance'  );



$appliance_data_details['exempt_england'] = $exempt_england;
$appliance_data_details['exempt_wales'] = $exempt_wales;
$appliance_data_details['exempt_scotland'] = $exempt_scotland;
$appliance_data_details['exempt_ireland'] = $exempt_ireland;

$appliance_data_details['statutory_instruments_england'] = $statutory_instruments_england;
$appliance_data_details['statutory_instruments_wales'] = $statutory_instruments_wales;
$appliance_data_details['statutory_instruments_scotland'] = $statutory_instruments_scotland;
$appliance_data_details['statutory_instruments_n_ireland'] = $statutory_instruments_n_ireland;

$taxonomy = 'permitted_fuels'; // Replace with the taxonomy you want to retrieve terms from
$permitted_fuels = wp_get_post_terms(get_the_ID(), $taxonomy);

?>

<main id="primary" class="site-main bg-white container pb-2">

	<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title bg-secondary p-2 text-white rounded">', '</h2>' ); ?>
		</header><!-- .entry-header -->

		<p>The appliances listed below are exempt in the relevant country or countries when using the specified fuel(s), when operated in accordance with the instruction and installation manuals and when any conditions are met.</p>
		<p>Available information about this fuel is shown below:</p>

		<div class="row justify-content-end">

			<div class="col-2 text-end">
				<form action="/data-entry/form-process/" method="post">
					<input type="hidden" name="data" value="<?php echo base64_encode(maybe_serialize( $appliance_data_details )) ; ?>">
					<input type="hidden" name="process" value="pdf-appliance-download">
					<?php wp_nonce_field( 'create_pdf_download', 'pdf_download_field' ); ?>
					<button class="btn btn-outline-success" type="submit">Download PDF</button>
				</form>
			</div>

			<div class="col-2 text-end">
				<form action="/data-entry/form-process/" method="post">
					<input type="hidden" name="data" value="<?php echo base64_encode(maybe_serialize( $appliance_data_details )) ; ?>">
					<input type="hidden" name="process" value="csv-appliance-download">
					<?php wp_nonce_field( 'create_csv_download', 'csv_download_field' ); ?>
					<button class="btn btn-outline-success" type="submit">Download CSV</button>
				</form>
			</div>


		</div>


		<div class="entry-content">
			<?php the_content(); ?>

			<table class="display dataTable no-footer" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td width="25%"><strong>Appliance name</strong></td>
						<td><?php the_title(); ?></td>
					</tr>
					<tr>
						<td><strong>Output</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'output_unit_output_value', true)); ?></td>
					</tr>
					<tr>
						<td><strong>Fuel Type</strong></td>
						<td><?php echo esc_html($public_class->get_fuel_type($post->ID)); ?></td>
					</tr>

					<tr>
						<td><strong>Appliance Type</strong></td>
						<td><?php echo esc_html($public_class->get_appliance_type($post->ID)); ?></td>
					</tr>

					<tr>
						<td><strong>Manufacturer</strong></td>
						<td><?php echo get_the_title(get_post_meta($post->ID, 'manufacturer_id', true)); ?></td>
					</tr>

					<tr>
						<th colspan=2>The fireplace must be installed, maintained and operated in accordance with the following specifications:</th>
					</tr>

					<tr>
						<td><strong>Instruction manual title</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'instructions_instruction_manual_title', true) ? get_post_meta($post->ID, 'instructions_instruction_manual_title', true) : 'See conditions if applicable'); ?></td>
					</tr>

					<tr>
						<td><strong>Instruction manual date</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'instructions_instruction_manual_date', true) ? get_post_meta($post->ID, 'instructions_instruction_manual_date', true) : 'See conditions if applicable'); ?></td>
					</tr>

					<tr>
						<td><strong>Instruction manual reference</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'instructions_instruction_manual_reference', true) ? get_post_meta($post->ID, 'instructions_instruction_manual_reference', true) : 'See conditions if applicable'); ?></td>
					</tr>

					<tr>
						<td><strong>Additional conditions</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'additional_conditions_additional_condition_comment', true) ? get_post_meta($post->ID, 'additional_conditions_additional_condition_comment', true) : 'N/A'); ?></td>
					</tr>

					<tr>
						<td><strong>Permitted fuels</strong></td>
						<td>
							<?php foreach ($permitted_fuels as $term) { ?>
							<?php echo esc_html( $term->name ); ?>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<td><strong>England Status<br>Date first exempt</strong></td>
						<td>
							<?php if ( $exempt_england ) { ?>

							<?php foreach ($statutory_instruments_england as $si_england) { ?>

							<?php if ( $si_england["revoke_status_id"] == '400' ) { ?>
							No n/a
							<?php } else { ?>
							<span>Exempt (<?php echo esc_html( $si_england["title"] ); ?>)<br>
								See Footnotes or SI Link</span>

							<?php } ?>

							<?php } ?>
							<?php } ?>

						</td>
					</tr>

					<tr>
						<td><strong>Wales Status<br>Date first exempt</strong></td>
						<td>
							<?php if ( $exempt_wales ) { ?>

							<?php foreach ($statutory_instruments_wales as $si_wales) { ?>

							<?php if ( $si_wales["revoke_status_id"] == '400' ) { ?>
							No n/a
							<?php } else { ?>
							<span>Exempt (<?php echo esc_html( $si_wales["title"] ); ?>)<br>
								See Footnotes or SI Link</span>

							<?php } ?>

							<?php } ?>
							<?php } ?>

						</td>
					</tr>


					<tr>
						<td><strong>Scotland Status<br>Date first exempt</strong></td>
						<td>
							<?php if ( $exempt_scotland ) { ?>

							<?php foreach ($statutory_instruments_scotland as $si_scotland) { ?>


							<?php if ( $si_scotland["revoke_status_id"] == '400' ) { ?>
							No n/a
							<?php } else { ?>
							<span>Exempt (<?php echo esc_html( $si_scotland["title"] ); ?>)<br>
								See Footnotes or SI Link</span>

							<?php } ?>

							<?php } ?>


							<?php } ?>

						</td>
					</tr>


					<tr>
						<td><strong>N. Ireland Status<br>Date first exempt</strong></td>
						<td>
							<?php if ( $exempt_ireland ) { ?>

							<?php foreach ($statutory_instruments_n_ireland as $si_n_ireland) { ?>

							<?php if ( $si_n_ireland["revoke_status_id"] == '400' ) { ?>
							No n/a
							<?php } else { ?>
							<span>Exempt (<?php echo esc_html( $si_n_ireland["title"] ); ?>)<br>
								See Footnotes or SI Link</span>

							<?php } ?>


							<?php } ?>

							<?php } ?>

						</td>
					</tr>

				</tbody>
			</table>

		</div><!-- .entry-content -->

		<footer class="entry-footer mt-4">
			<h5>Footnotes</h5>

			<ol class="smalltext">
				<li id="footnote1">The fuel must not contain halogenated organic compounds or heavy metals as a result of treatment with wood-preservatives or coatings.</li>
				<li id="footnote2">The conditions of exemption have been amended to remove references to fuels which are either no longer available or which cannot be used without contravening the Environmental Permitting (England and Wales) Regulations 2010 (S.I. 2010/675) or the Pollution Prevention and Control (Industrial Emissions) Regulations (Northern Ireland) 2013 (S.R. 2013 No. 160)</li>
				<li id="footnote3">The Environmental Permitting Regulations (England and Wales) 2010 (SI 2010/675) may apply to the burning of some of these wastes.</li>
				<li id="footnote4">Previously exempted by The Smoke Control Areas (Exempted Fireplaces) (England) Order 2015 (SI 2015/307), no longer in force as of 1 October 2015. Now exempted by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
				<li id="footnote5">Exempted for use in England by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
				<li id="footnote6">Previously exempted by The Smoke Control Areas (Exempted Fireplaces) (Scotland) Regulations 2014 (SI 2014/316), no longer in force as of 30th June 2014. Now exempted by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
				<li id="footnote7">Exempted for use in Scotland by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
				<li id="footnote8">Previously exempted by the Smoke Control Areas (Exempted Fireplaces) (No. 2) Regulations (Northern Ireland) 2013 (S.R. 2013 No. 292), as amended, no longer in force as of 10th October 2016. Now exempted by the publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Article 17(7) of the Clean Air (Northern Ireland) Order 1981 by section 16 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
				<li id="footnote9">Exempted for use in Northern Ireland by publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Article 17(7) of the Clean Air (Northern Ireland) Order 1981 by section 16 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
			</ol>

		</footer><!-- .entry-footer -->

	</article><!-- #post -->

	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
