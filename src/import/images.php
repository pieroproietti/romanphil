l<?php
# Percorso di importazione immagini

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
    $pathUrl="http://". htmlentities(parse_url($urlImg, PHP_URL_PATH));
    //echo "PATH_URL:". $pathUrl . "\n";

    $description=strtolower($description);

    $fileExt=substr(basename($urlImg), strrpos(basename($urlImg), "."), 4);
    $product=wc_get_product($productId);


    $fileImg=postSlug("img-".$codice);
    $fileImg.=$fileExt;
    $fileImgFullPath=PATH_IMPORT_IMAGES . $fileImg;

    $urlOriginal=$urlImg;
    $urlPath=dirname($urlImg);
    $basename = trim(basename($urlImg));
    $urlImg=$urlPath."/".rawurlencode($basename);

    //$description=htmlentities($description);
    //$description = str_replace('°', '', $description);
    echo "\nURL: $urlImg\nProduct id: $productId\nDescription: $description\n";

    $len=strlen($basename);
    if (len<=0) {
            $found= true;

            $html = addMediaLibrary($productId, $urlImg, $description);
            $images = get_attached_media('image', $productId);
            foreach ($images as $image) {
                $thumbnailId=$image->ID;
                break;
            }
            //echo "productId =  $productId, thumbnailId= $thumbnailId, image: ".$fileImg." description: $description\n\r";
            update_post_meta($productId, '_thumbnail_id', $image->ID);
            // postInsertMetaRow($thumbnailId,'_wp_attachment_image_alt',$fileImg);
            // postInsertMetaRow($thumbnailId,'_wp_attached_file','2016/11/'.$fileImg);
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
    // TEST
    $url=$filename;
    $file = PATH_IMPORT_IMAGES.$filename;
    echo "FILE_IMG: $file\n";
        echo "URL: $url \n";
        $html = media_sideload_image($url, $productId, $description);
        if (is_wp_error($html)) {
            error_log(print_r($productId, true));
            echo "ERRORE\n ";
            return "\nErrore!!!\n";
        } else {
            echo "HTML:  $html\n";
        }
}
