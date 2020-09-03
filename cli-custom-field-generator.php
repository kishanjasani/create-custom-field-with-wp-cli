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

			$foo = $args[0];
			$bar = $args[1];

			$amount = $assoc_args['amount'];

			WP_CLI::line( $foo );
			WP_CLI::line( $bar );
			WP_CLI::line( $amount );
		}
	}

	WP_CLI::add_command( 'wpc', 'CLI_Custom_Field_Generator' );

	// wp wpc generate_florplans foo bar --amount=10
}
