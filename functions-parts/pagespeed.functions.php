<?php
function add_expires_headers_to_assets($headers, $file) {
    $path_info = pathinfo($file);
    $ext = isset($path_info['extension']) ? $path_info['extension'] : '';

    switch ($ext) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':
        case 'webp':
        case 'svg':
        case 'ico':
            $expires_offset = 31536000; // 1 year
            break;
        case 'css':
            $expires_offset = 2592000; // 1 month
            break;
        case 'js':
            $expires_offset = 2592000; // 1 month
            break;
        case 'pdf':
        case 'swf':
            $expires_offset = 2592000; // 1 month
            break;
        default:
            $expires_offset = 604800; // 1 week
            break;
    }

    $headers['Expires'] = gmdate("D, d M Y H:i:s", time() + $expires_offset) . " GMT";
    $headers['Cache-Control'] = 'public, max-age=' . $expires_offset;

    return $headers;
}

#('wp_headers', 'add_expires_headers_to_assets', 10, 2);