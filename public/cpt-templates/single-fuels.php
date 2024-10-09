<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Defra_Data
 */

$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$fuel_data_details = $public_class->fuel_data_details($post->ID);
$footnote8 = get_post_meta( $post->ID, 'authorised_country_and_statutory_instrument_england_si_0_si_id', true );
$guid = get_post_meta($post->ID, 'fuel_id', true);

$exempt_england = get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_england_si', true);
$exempt_wales = get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_wales_si', true);
$exempt_scotland = get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_scotland_si', true);
$exempt_n_ireland = get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_n_ireland_si', true);

$statutory_instruments_england = $public_class->statutory_instrument_assignment( $post->ID, 'england', 'fuel' );
$statutory_instruments_wales = $public_class->statutory_instrument_assignment( $post->ID, 'wales', 'fuel'  );
$statutory_instruments_scotland = $public_class->statutory_instrument_assignment( $post->ID, 'scotland', 'fuel'  );
$statutory_instruments_n_ireland = $public_class->statutory_instrument_assignment( $post->ID, 'n_ireland', 'fuel'  );


get_header();
?>

<main id="primary" class="site-main bg-white container pb-2">

	<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title bg-secondary p-2 text-white rounded">', '</h2>' ); ?>
		</header><!-- .entry-header -->

		<p>Available information about this fuel is shown below:</p>

		<div class="row justify-content-end">

			<div class="col-2 text-end">
				<form action="/data-entry/form-process/" method="post">
					<input type="hidden" name="data" value="<?php echo base64_encode(maybe_serialize( $fuel_data_details )) ; ?>">
					<input type="hidden" name="process" value="pdf-fuel-download">
					<?php wp_nonce_field( 'create_pdf_download', 'pdf_download_field' ); ?>
					<button class="btn btn-outline-success" type="submit">Download PDF</button>
				</form>
			</div>

			<div class="col-2 text-end">
				<form action="/data-entry/form-process/" method="post">
					<input type="hidden" name="data" value="<?php echo base64_encode(maybe_serialize( $fuel_data_details )) ; ?>">
					<input type="hidden" name="process" value="csv-fuel-download">
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
						<td width="25%"><strong>Fuel ID: (England)</strong></td>
						<td><?php echo esc_html( $footnote8 == '55361' ? 'MSF' . str_pad( $guid, 4, '0', STR_PAD_LEFT) : str_pad( $guid, 4, '0', STR_PAD_LEFT) ); ?></td>
					</tr>
					<tr>
						<td width="25%"><strong>Fuel ID: (Wal, Scot &amp; NI)</strong></td>
						<td><?php echo esc_html( $footnote8 == '55361' ? 'MSF' . str_pad( $guid, 4, '0', STR_PAD_LEFT) : str_pad( $guid, 4, '0', STR_PAD_LEFT) ); ?></td>
					</tr>
					<tr>
						<td width="25%"><strong>Fuel name</strong></td>
						<td><?php the_title(); ?></td>
					</tr>
					<tr>
						<td><strong>Manufacturer</strong></td>
						<td><?php echo esc_html( $public_class->manufacturer_composite_address(get_post_meta($post->ID, 'manufacturer_id', true ))); ?></td>
					</tr>

					<?php if( !empty( get_post_meta($post->ID, 'point_a', true ) ) ) { ?>
					<tr>
						<td><strong>(a)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_a', true )); ?></td>
					</tr>
					<?php } ?>

					<?php if( !empty( get_post_meta($post->ID, 'point_b', true ) ) ) { ?>
					<tr>
						<td><strong>(b)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_b', true )); ?></td>
					</tr>
					<?php } ?>

					<?php if( !empty( get_post_meta($post->ID, 'point_c', true ) ) ) { ?>
					<tr>
						<td><strong>(c)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_c', true )); ?></td>
					</tr>
					<?php } ?>

					<?php if( !empty( get_post_meta($post->ID, 'point_d', true ) ) ) { ?>
					<tr>
						<td><strong>(d)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_d', true )); ?></td>
					</tr>
					<?php } ?>

					<?php if( !empty( get_post_meta($post->ID, 'point_e', true ) ) ) { ?>
					<tr>
						<td><strong>(e)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_e', true )); ?></td>
					</tr>
					<?php } ?>

					<?php if( !empty( get_post_meta($post->ID, 'point_f', true ) ) ) { ?>
					<tr>
						<td><strong>(f)</strong></td>
						<td><?php echo esc_html(get_post_meta($post->ID, 'point_f', true )); ?></td>
					</tr>
					<?php } ?>



					<tr>
						<td><strong>England Status<br>Date first authorised</strong></td>

							<?php if ( $exempt_england ) { ?>

								<?php foreach ($statutory_instruments_england as $si_england) { ?>

									<?php if ( $si_england["revoke_status_id"] == '400' || $si_england["publish_status"] != '600' ) { ?>
										<td>No n/a</td>
									<?php } else { ?>
										<td>
											<span>Authorised (<?php echo esc_html( $si_england["title"] ); ?>)</span>
											<br />
											<?php echo esc_html( date('d/m/Y', strtotime( get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_england_publish_date', true) ) ) ); ?>
										</td>

									<?php } ?>

								<?php } ?>

							<?php } else { ?>

								<td>No n/a</td>

							<?php } ?>

					</tr>

					<tr>
						<td><strong>Wales Status<br>Date first authorised</strong></td>


						<?php if ( $exempt_wales ) { ?>

							<?php foreach ($statutory_instruments_wales as $si_wales) { ?>

								<?php if ( $si_wales["revoke_status_id"] == '400' || $si_wales["publish_status"] != '600' ) { ?>
									<td>No n/a</td>
								<?php } else { ?>
									<td>
										<span>Authorised (<?php echo esc_html( $si_wales["title"] ); ?>)</span>
										<br />
										<?php echo esc_html( date('d/m/Y', strtotime( get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_wales_publish_date', true) ) ) ); ?>
									</td>

								<?php } ?>

							<?php } ?>

						<?php } else { ?>

							<td>No n/a</td>

						<?php } ?>


					</tr>


					<tr>
						<td><strong>Scotland Status<br> Date first authorised</strong></td>

						<?php if ( $exempt_scotland ) { ?>

						<?php foreach ($statutory_instruments_scotland as $si_scotland) { ?>

						<?php if ( $si_scotland["revoke_status_id"] == '400' || $si_scotland["publish_status"] != '600' ) { ?>
						<td>No n/a</td>
						<?php } else { ?>
						<td>
							<span>Authorised (<?php echo esc_html( $si_scotland["title"] ); ?>)</span>
							<br />
							<?php echo esc_html( date('d/m/Y', strtotime( get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_scotland_publish_date', true) ) ) ); ?>
						</td>

						<?php } ?>

						<?php } ?>

						<?php } else { ?>

						<td>No n/a</td>

						<?php } ?>

					</tr>


					<tr>
						<td><strong>N. Ireland Status<br> Date first authorised</strong></td>

						<?php if ( $exempt_n_ireland ) { ?>

							<?php foreach ($statutory_instruments_n_ireland as $si_n_ireland) { ?>

								<?php if ( $si_n_ireland["revoke_status_id"] == '400' || $si_n_ireland["publish_status"] != '600' ) { ?>
									
									<td>No n/a</td>

								<?php } else { ?>

									<td>
										<span>Authorised (<?php echo esc_html( $si_n_ireland["title"] ); ?>)</span>
										<br />
										<?php echo esc_html( date('d/m/Y', strtotime( get_post_meta($post->ID, 'authorised_country_and_statutory_instrument_n_ireland_publish_date', true) ) ) ); ?>
									</td>

								<?php } ?>

							<?php } ?>

						<?php } else { ?>

							<td>No n/a</td>

						<?php } ?>

					</tr>

				</tbody>
			</table>






		</div><!-- .entry-content -->

		<footer class="entry-footer mt-4">

			<h5>Footnotes</h5>

			<ol class="smalltext">
				<li id="footnote1">Fuels that are not commercially available have been authorised previously and continued to be authorised if manufactured before dates specified in the relevant Statutory instruments.</li>
				<li id="footnote2">Previously authorised by The Smoke Control Areas (Authorised Fuels) (England) (No. 2) Regulations 2014 (SI 2014/2366), no longer in force as of 1 October 2015. Now authorised by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
				<li id="footnote3">Authorised for use in England by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015</li>
				<li id="footnote4">Previously authorised by The Smoke Control Areas (Authorised Fuels) (Scotland) Regulations 2014 (SI 2014/317), no longer in force as of 30th June 2014. Now authorised by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
				<li id="footnote5">Authorised for use in Scotland by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
				<li id="footnote6">Previously authorised by the Smoke Control Areas (Authorised Fuels) Regulations (Northern Ireland) 2013 (S.R. 2013 No. 205), as amended, no longer in force as of 10th October 2016. Now authorised by publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Articles 2(2) and 17(3) of the Clean Air (Northern Ireland) Order 1981 by section 15 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
				<li id="footnote7">Authorised for use in Northern Ireland by publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Articles 2(2) and 17(3) of the Clean Air (Northern Ireland) Order 1981 by section 15 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
				<li id="footnote8">Authorised for use in England by publication of this list by the Secretary of State in accordance with Sections 20 &amp; 21 of the Clean Air Act 1993 and now also certified for use in England by publication of this list by the Secretary of State under Regulation 12 of SI 2020 No. 1095, Environmental Protection, England the Air Quality (Domestic Solid Fuels Standards) (England) Regulations 2020.</li>
			</ol>

		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
