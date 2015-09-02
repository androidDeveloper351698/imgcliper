<?php


// Result object
$r = new stdClass();
// no-cache (important for mobile safari)
header('cache-control: no-cache');
// Result content type
header('content-type: application/json');
header('Access-Control-Allow-Origin: *');


 if (preg_match('/image/i', $_POST['type'])) {
    $filename = './' . uniqid() . '.' . (isset($_POST['ext']) ? $_POST['ext'] : 'jpg');
} else {

    $r->error = "Error: Only image files";
}

// Supporting image file types
$types = Array('image/png', 'image/gif', 'image/jpeg');
// File type control
// if (in_array($_FILES['photo']['type'], $types)) {
if (in_array($_POST['type'], $types)) {
    // Create an unique file name    

    $imgData = $_POST['file'];
    $dataurl = str_replace('data:image/png;base64,', '', $imgData);
    $dataurl = str_replace('data:image/jpeg;base64,', '', $dataurl);
    $source = base64_decode($dataurl);

    file_put_contents($filename, $source);
} else {
    // If the file is not an image
    $r->error = "Error: this is not an image file";
    return false;
}

// File path
$path = str_replace('upload.php', '', $_SERVER['SCRIPT_NAME']);

// Result data
$r->filename = $filename;
$r->path = $path;
$r->img = '<img src="' . $r->path . $r->filename . '" alt="image" />';

// Return to JSON
echo json_encode($r);

?>
