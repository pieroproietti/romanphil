l<?php
require '.auth.php';

// Need to require these files
if (!function_exists('media_handle_upload')) {
    require_once 'wp-admin'.'/includes/image.php';
    require_once 'wp-admin'.'/includes/file.php';
    require_once 'wp-admin'.'/includes/media.php';
    //require_once '../wp-content/plugins/woocommerce/includes/wc-product-functions.php';
}

function addImage($productId, $urlImg, $description, $codice)
{
    $found = false;
    $pathUrl="http://". htmlentities(parse_url($urlImg, PHP_URL_PATH));
    //echo "PATH_URL:". $pathUrl . "\n";

    $description=strtolower($description);

    $fileExt=substr(basename($urlImg), strrpos(basename($urlImg), "."), 4);
    $product=wc_get_product($productId);


    $fileImg=postSlug("img-".$codice);
    $fileImg.=$fileExt;
    $fileImgFullPath="/var/www/html/kiri-uploads/" . $fileImg;

    $urlOriginal=$urlImg;
    $urlPath=dirname($urlImg);
    $basename = trim(basename($urlImg));
    $urlImg=$urlPath."/".rawurlencode($basename);

    //$description=htmlentities($description);
    //$description = str_replace('°', '', $description);
    echo "\nURL: $urlImg\nProduct id: $productId\nDescription: $description\n";

    $len=strlen($basename);
    if (len<=0) {
        if (copy($urlImg, $fileImgFullPath)) {
            $found= true;


            $html = addMediaLibrary($productId, $fileImg, $description);
            $images = get_attached_media('image', $productId);
            foreach ($images as $image) {
                $thumbnailId=$image->ID;
                break;
            }
            array_map('unlink', glob('/var/www/html/kiri-uploads/*.*'));
        //echo "productId =  $productId, thumbnailId= $thumbnailId, image: ".$fileImg." description: $description\n\r";
        update_post_meta($productId, '_thumbnail_id', $image->ID);
        // postInsertMetaRow($thumbnailId,'_wp_attachment_image_alt',$fileImg);
        // postInsertMetaRow($thumbnailId,'_wp_attached_file','2016/11/'.$fileImg);
        }
    } else {
        echo "ERRORE nome file nullo! $urlOriginal\n";
        echo "basename=$basename\n";
        echo "len: ". strlen($basename) ."\n";
        exit;
    }
    return $found;
}

function splitFilename($filename)
{
    $pos = strrpos($filename, '.');
    if ($pos === false) { // dot is not found in the filename
        return array($filename, ''); // no extension
    } else {
        $basename = substr($filename, 0, $pos);
        $extension = substr($filename, $pos+1);
        //echo "\nfile name: $basename\n";
        //echo "extension: $extension\n";
        return array($basename, $extension);
    }
}


function addMediaLibrary($productId, $filename, $description)
{
    $file = '/var/www/html/kiri-uploads/'.$filename;
    if (!file_exists($file) || 0 === strlen(trim($filename))) {
        error_log('The file you are attempting to upload, '.$file.', does not exist.');
        return;
    }
    $uploads = wp_upload_dir();
    $uploads_dir = $uploads['path'];
    $uploads_url = $uploads['url'];

    if (copy($file, trailingslashit($uploads_dir).$filename)) {
        $url = trailingslashit($uploads_url).$filename;
        $html = media_sideload_image($url, $productId, $description);
        if (is_wp_error($html)) {
            error_log(print_r($productId, true));
            return "Errore!!!\m";
        } else {
            echo $html . "\n";
        }
    } else {
        echo "\nNON RIESCO A COPIARE $file\n";
    };
    return $html;
}
