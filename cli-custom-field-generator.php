<?php
/**
 * Plugin Name: CLI Custom Field Generator
 * Plugin URL: https://profiles.wordpress.org/kishanjasani/
 * Description: Custom WP-CLI Command
 * Author: Kishan Jasani
 * Version: 1.0.0
 * Author URI: https://github.com/kishanjasani/kishanjasani
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once plugin_dir_path( __FILE__ ) . '/vendor/fzaninotto/faker/src/autoload.php';

	class CLI_Custom_Field_Generator {

		/**
		 * Generate Floor plans metadata.
		 *
		 * @param Array $args       foo and bar will be in args.
		 * @param Array $assoc_args --amount will be in assoc args.
		 * @return void
		 */
		public function generate_florplans( $args, $assoc_args ) {

			$amount = $assoc_args['amount'];

			$home_type_terms = get_terms(
				[
					'taxonomy'   => 'home_types',
					'hide_empty' => false,
				]
			);

			$home_type_ids = array_map(
				function( $home_type ) {
					return $home_type->term_id;
				},
				$home_type_terms
			);

			$home_feature_terms = get_terms(
				[
					'taxonomy'   => 'home_features',
					'hide_empty' => false,
				]
			);

			$home_feature_ids = array_map(
				function( $home_feature ) {
					return $home_feature->term_id;
				},
				$home_feature_terms
			);

			$facker = Faker\Factory::create();

			$progress = \WP_CLI\Utils\make_progress_bar( 'Generating Floorplans', $amount );

			for ( $i = 0; $i < $amount; $i++ ) {

				$floorplan = wp_insert_post(
					[
						'post_title'  => 'The ' . $facker->firstName,
						'post_status' => 'publish',
						'post_type'   => 'floorplan',
					]
				);

				wp_set_object_terms( $floorplan, array_rand( array_flip( $home_type_ids ), 1 ), 'home_types' );
				wp_set_object_terms( $floorplan, array_rand( array_flip( $home_feature_ids ), 3 ), 'home_features' );

				$possible_images = [ 48, 47, 34, 50, 30 ];

				$image_keys = [
					'featured_image', // 'featured_image',
					'interior_1', // 'interior_1',
					'interior_2', // 'interior_2',
					'interior_3', // 'interior_3',
					'interior_4', // 'interior_4',
				];

				foreach ( $image_keys as $key ) {
					update_field( $key, array_rand( array_flip( $possible_images ), 1 ), $floorplan );
				}

				// Beds
				update_field( 'field_5f50d8f4c4399', $facker->numberBetween( 2, 5 ), $floorplan );

				// Bathroom
				update_field( 'field_5f50d8e4c4398', $facker->numberBetween( 1, 5 ), $floorplan );

				// square footage
				update_field( 'field_5f50da0414601', $facker->numberBetween( 1500, 3000 ), $floorplan );

				// Starting price
				update_field( 'field_5f50d93a14600', $facker->numberBetween( 250000, 400000 ), $floorplan );

				$progress->tick();
			}

			$progress->finish();
			WP_CLI::success( $amount . ' Floorplans Generated!' );

		}
	}

	WP_CLI::add_command( 'wpc', 'CLI_Custom_Field_Generator' );

	// wp wpc generate_florplans foo bar --amount=10
}
