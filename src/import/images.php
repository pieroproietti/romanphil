<?php
require '.auth.php';

// Need to require these files
if (!function_exists('media_handle_upload')) {
    require_once 'wp-admin'.'/includes/image.php';
    require_once 'wp-admin'.'/includes/file.php';
    require_once 'wp-admin'.'/includes/media.php';
}

function addImage($productId, $urlImg, $description, $codice)
{
    $found = false;

    $description=strtolower($description);
    $product=wc_get_product($productId);

    $len=strlen($basename);
    if (len<=0) {
        $found= true;
        $html = addMediaLibrary($productId, $urlImg, $description);
        $images = get_attached_media('image', $productId);
        foreach ($images as $image) {
            $thumbnailId=$image->ID;
            break;
        }
        update_post_meta($productId, '_thumbnail_id', $image->ID);
    } else {
        echo "ERRORE nome file nullo! $urlImg\n";
        exit;
    }
    return $found;
}

function addMediaLibrary($productId, $url, $description)
{
    $html = media_sideload_image($url, $productId, $description);
    if (is_wp_error($html)) {
        error_log(print_r($productId, true));
        return "\nErrore!!!\n";
    }
}
