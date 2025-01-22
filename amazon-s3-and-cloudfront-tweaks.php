<?php
/*
Plugin Name: WP Offload Media Tweaks For Contabo Only
Plugin URI: https://github.com/cotlaswebhost/contabo-s3-and-cloudfront-tweaks/
Description: Filters and settings for using WP Offload Media with Contabo Object Storage
Author: Vinay Shukla
Version: 0.6.0
Author URI: https://teklog.in/vinay404
Network: True
*/

use DeliciousBrains\WP_Offload_Media\Items\Item;
use DeliciousBrains\WP_Offload_Media\Items\Media_Library_Item;

class Contabo_S3_Tweaks {

    public function __construct() {
        // Custom S3 API Example: Contabo
        add_filter( 'as3cf_aws_s3_client_args', array( $this, 'contabo_s3_client_args' ) );
        add_filter( 'as3cf_aws_get_regions', array( $this, 'contabo_get_regions' ) );
        add_filter( 'as3cf_aws_s3_bucket_in_path', '__return_true' );
        add_filter( 'as3cf_aws_s3_domain', array( $this, 'contabo_domain' ) );
        add_filter( 'as3cf_aws_s3_console_url', array( $this, 'contabo_s3_console_url' ) );

        // Replace URL to reflect Contabo's preferred structure
        add_filter( 'as3cf_get_attachment_url', function ( $url ) {
            $url = str_replace(
                'https://s3.default.usc1.contabostorage.com/',
                'https://usc1.contabostorage.com/',
                $url
            );
            return $url;
        });

        // Set dummy region to bypass errors as Contabo doesn’t require one
        add_filter( 'as3cf_bucket_region', function ( $region, $bucket, $provider ) {
            return 'us-east-1';
        }, 10, 3 );

        add_filter( 'as3cf_get_provider_client', function ( $client, $provider, $args ) {
            $args['region'] = 'us-east-1';
            $client = new \Aws\S3\S3Client( $args );
            return $client;
        }, 10, 3 );

        add_filter( 'as3cf_aws_s3_client_args', function ( $args ) {
            $args['endpoint'] = 'https://usc1.contabostorage.com';
            $args['use_path_style_endpoint'] = true; // Force path-style URLs
            return $args;
        });
    }

    public function contabo_s3_client_args( $args ) {
        $args['endpoint'] = 'https://usc1.contabostorage.com';
        $args['region'] = 'us-central-1'; // Optional region setting
        $args['use_path_style_endpoint'] = true;
        return $args;
    }

    public function contabo_get_regions( $regions ) {
        $regions = array(
            	'us-central-1' => 'Contabo US Central 1',
		'eu-central-1'   => 'Contabo European Union',
		'ap-southeast-1' => 'Contabo Singapore',
            // Add other Contabo regions if necessary
        );
        return $regions;
    }

    public function contabo_domain( $domain ) {
        return 'usc1.contabostorage.com';
    }

    public function contabo_s3_console_url( $url ) {
        return 'https://new.contabo.com/storage/object-storage/';
    }
}

new Contabo_S3_Tweaks();
