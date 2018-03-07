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
    $inserted=true;
    $description=strtolower($description);
    $product=wc_get_product($productId);

    $html=media_sideload_image($urlImg, $productId, $description);
    if (is_wp_error($html)) {
        $inserted=false;
    } else {
        $images = get_attached_media('image', $productId);
        foreach ($images as $image) {
            $thumbnailId=$image->ID;
            break;
        }
        update_post_meta($productId, '_thumbnail_id', $image->ID);
    }
    return $inserted;
}
