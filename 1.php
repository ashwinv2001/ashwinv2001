<?php
// Specify the path to the text file database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$file_path = "database.txt";

// Check if the user has submitted the form to delete or add data
if (isset($_POST['action'])) {
  // Delete all data in the file
  if ($_POST['action'] == 'delete') {
    $ret = file_put_contents($file_path, '');
    echo "All data deleted from the file.";
  }
  // Add new data to the file
  elseif ($_POST['action'] == 'add') {
    $data = $_POST['data'];
    if (!empty($data)) {
      if (file_put_contents($file_path, $data . "\n", FILE_APPEND) !== false) {
        echo "Data added to the file.";
      } else {
        echo "Error writing data to file.";
      }
    } else {
      echo "Data is empty.";
    }
  }
}

// Open the file in read-only mode
$file = fopen($file_path, "a+");

// Read the contents of the file into an array
$data = file($file_path);

// Close the file handle
fclose($file);

// Display the data in an HTML table
echo "<table>";
foreach ($data as $line) {
  $fields = explode(",", $line);
  echo "<tr>";
  foreach ($fields as $field) {
    echo "<td>" . htmlspecialchars($field) . "</td>";
  }
  echo "</tr>";
}
echo "</table>";

// Display the form for deleting or adding data
echo "<form method='post'>";
echo "<p><input type='radio' name='action' value='delete' /> Delete all data in the file</p>";
echo "<p><input type='radio' name='action' value='add' /> Add new data to the file:</p>";
echo "<p><textarea name='data'></textarea></p>";
echo "<p><input type='submit' value='Submit' /></p>";
echo "</form>";
?>

