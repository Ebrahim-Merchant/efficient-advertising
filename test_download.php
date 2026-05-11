<?php
require_once('wp-load.php');
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/image.php' );

$url = "https://drive.google.com/file/d/1-QvC5BqOoFrJvdNvJ-hQirXrWczqHDO0/view?usp=sharing";
preg_match('/d\/(.*?)\//', $url, $match);
if(isset($match[1])) {
    $id = $match[1];
    $download_url = "https://drive.google.com/uc?export=download&id=" . $id;

    // Get headers to find original filename
    $headers = get_headers($download_url, 1);
    $filename = "unknown-sku.jpg";
    if (isset($headers['Content-Disposition'])) {
        $cd = is_array($headers['Content-Disposition']) ? end($headers['Content-Disposition']) : $headers['Content-Disposition'];
        if (preg_match('/filename\*=UTF-8\'\'(.+)|filename="(.+?)"/i', $cd, $m)) {
            $filename = urldecode(!empty($m[1]) ? $m[1] : $m[2]);
        }
    } else {
        // sometimes redirect headers have it
        if(isset($headers['Location'])) {
            $loc = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            $headers2 = get_headers($loc, 1);
            if (isset($headers2['Content-Disposition'])) {
                $cd = is_array($headers2['Content-Disposition']) ? end($headers2['Content-Disposition']) : $headers2['Content-Disposition'];
                if (preg_match('/filename="(.+?)"/i', $cd, $m)) {
                    $filename = $m[1];
                }
            }
        }
    }

    echo "Found filename: " . $filename . "\n";
    
    // Clean filename for SKU
    $info = pathinfo($filename);
    $sku = sanitize_title($info['filename']);
    $title = ucwords(str_replace(['-', '_'], ' ', $info['filename']));

    echo "Downloading...\n";
    $tmp = download_url( $download_url );
    if ( is_wp_error( $tmp ) ) {
        echo "Error: " . $tmp->get_error_message();
    } else {
        $file_array = array(
            'name'     => $filename,
            'tmp_name' => $tmp
        );
        $attachment_id = media_handle_sideload( $file_array, 0 );
        if( is_wp_error($attachment_id) ) {
            echo "Error attaching: " . $attachment_id->get_error_message();
            @unlink($tmp);
        } else {
            echo "Successfully attached Image ID: $attachment_id\n";
            // Create a test product
            $post_id = wp_insert_post([
                'post_title'   => $title,
                'post_status'  => 'publish',
                'post_type'    => 'product',
            ]);
            update_post_meta($post_id, '_sku', $sku);
            set_post_thumbnail($post_id, $attachment_id);
            echo "Created Product ID $post_id with title '$title' and SKU '$sku'\n";
        }
    }
}
