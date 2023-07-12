<?php
// Set the content type to CSV
header('Content-Type: text/csv; charset=utf-8');

// Set the response header to specify that the file should be downloaded as an attachment
header('Content-Disposition: attachment; filename=data.csv');

$array_keys = array_keys($data);
$array_values = array_values($data);
$data = array(
    $array_keys,
    $array_values
);

// Open a file handle for writing
$fp = fopen('php://output', 'w');

// Write the data to the file
foreach ($data as $row) {
  fputcsv($fp, $row);
}

// Close the file handle
fclose($fp);?>

