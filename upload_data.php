<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CSV to JSON</title>
</head>
<body>
  <h1>CSV to JSON</h1>
  <form enctype="multipart/form-data" method="POST">
    <input type="file" name="csvfile">
    <input type="submit" value="Upload">
  </form>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["csvfile"]) && $_FILES["csvfile"]["error"] == 0) {
      $csvFilePath = $_FILES["csvfile"]["tmp_name"];
      $data = array();
      if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        // Get the header row and use it as property names in the JSON
        $headerRow = fgetcsv($handle, 1000, ";");
        $jsonData = array();
        while (($row = fgetcsv($handle, 1000, ";")) !== FALSE) {
          $dataRow = array();
          foreach ($row as $key => $value) {
            $dataRow[$headerRow[$key]] = $value;
          }
          $jsonData[] = $dataRow;
          $data[] = $row;
        }
        fclose($handle);
        
        $jsonString = json_encode($jsonData);
        file_put_contents('output.json', $jsonString);
        
        echo '<h2>Data in HTML table:</h2>';
        echo '<table>';
        echo '<thead><tr>';
        foreach ($headerRow as $cell) {
          echo '<th>' . htmlspecialchars($cell) . '</th>';
        }
        echo '</tr></thead><tbody>';
        foreach ($data as $row) {
          echo '<tr>';
          foreach ($row as $cell) {
            echo '<td>' . htmlspecialchars($cell) . '</td>';
          }
          echo '</tr>';
        }
        echo '</tbody></table>';
      }
    } else {
      echo '<p>Error uploading file.</p>';
    }
  }
  ?>
</body>
</html>

