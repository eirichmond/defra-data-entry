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
?>

	<main id="primary" class="site-main bg-white container pb-2">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title bg-secondary p-2 text-white rounded">', '</h2>' ); ?>
				</header><!-- .entry-header -->

				<p>Available information about this fuel is shown below:</p>

				<div class="row">

					<div class="col">

						<div class="text-end mb-2">
							<button class="btn btn-outline-success" type="button">Download PDF</button>
							<button class="btn btn-outline-success" type="button">Download CSV</button>
						</div>

					</div>

				</div>


				<div class="entry-content">
					<?php the_content(); ?>

					<table class="display dataTable no-footer" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td width="25%"><strong>Fuel ID: (England)</strong></td>
								<td width="25%"><?php echo esc_html( get_post_meta($post->ID, 'fuel_id', true) ); ?></td>
								<td width="25%"><strong>Fuel ID: (Wal, Scot &amp; NI)</strong></td>
								<td width="25%"><?php echo esc_html( get_post_meta($post->ID, 'fuel_id', true) ); ?></td>
							</tr>
						</tbody>
					</table>





					<table class="display dataTable no-footer" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td width="25%"><strong>Fuel name</strong></td>
								<td><?php the_title(); ?></td>
							</tr>
							<tr>
								<td><strong>Manufacturer</strong></td>
								<td><?php echo get_the_title(get_post_meta($post->ID, 'manufacturer', true)); ?></td>
							</tr>
						
							<tr>
								<td><strong>England Status<br>
								Date first authorised</strong></td>
								<td>Authorised  (<a href="<?php echo get_the_content(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_england_si', true)); ?>"><?php echo get_the_title(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_england_si', true)); ?></a>)<br>See Footnotes or SI Link</td>
							</tr>
						
							<tr>
								<td><strong>Wales Status<br>
								Date first authorised</strong></td>
								<td>Authorised (<a href="<?php echo get_the_content(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_wales_si', true)); ?>"><?php echo get_the_title(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_wales_si', true)); ?></a>)<br>See Footnotes or SI Link</td>
							</tr>

						
							<tr>
								<td><strong>Scotland Status<br>
									Date first authorised</strong></td>
								<td>Authorised (<a href="<?php echo get_the_content(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_scotland_si', true)); ?>"><?php echo get_the_title(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_scotland_si', true)); ?></a>)<br>See Footnotes or SI Link</td>
							</tr>

						
							<tr>
								<td><strong>N. Ireland Status<br>
									Date first authorised</strong></td>
								<td>Authorised (<a href="<?php echo get_the_content(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_n_ireland_si', true)); ?>"><?php echo get_the_title(get_post_meta($post->ID, 'exempt-in_country_and_statutory_instrument_n_ireland_si', true)); ?></a>)<br>See Footnotes or SI Link</td>
							</tr>

						</tbody>
					</table>






				</div><!-- .entry-content -->

				<footer class="entry-footer mt-4">

					<h5>Footnotes</h5>
					
					<ol class="smalltext"><li id="footnote1">Fuels that are not commercially available have been authorised previously and continued to be authorised if manufactured before dates specified in the relevant Statutory instruments.</li>
						<li id="footnote2">Previously authorised by The Smoke Control Areas (Authorised Fuels) (England) (No. 2) Regulations 2014 (SI 2014/2366), no longer in force as of 1 October 2015.  Now authorised by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
						<li id="footnote3">Authorised for use in England by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015</li>
						<li id="footnote4">Previously authorised by The Smoke Control Areas (Authorised Fuels) (Scotland) Regulations 2014 (SI 2014/317), no longer in force as of 30th June 2014.  Now authorised by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
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
