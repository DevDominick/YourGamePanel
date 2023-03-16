<?php
// Handle theme upload
if(isset($_POST['uploadTheme'])) {
    // Validate file type
    $allowedTypes = array('zip'); // Allow only zip files
    $fileType = pathinfo($_FILES['theme']['name'], PATHINFO_EXTENSION);
    if(!in_array($fileType, $allowedTypes)) {
      echo "Invalid file type. Please select a zip file.";
      exit;
    }
  
    // Validate file size
    $maxSize = 1000000; // Maximum file size in bytes
    if($_FILES['theme']['size'] > $maxSize) {
      echo "File size exceeds limit. Please select a smaller file.";
      exit;
    }
  
    // Move file to custom theme directory
    $targetDir = "themes/";
    $targetFile = $targetDir . basename($_FILES['theme']['name']);
    if(move_uploaded_file($_FILES['theme']['tmp_name'], $targetFile)) {
      // Update database with theme information
      $themeName = $_POST['themeName'];
      $themeVersion = $_POST['themeVersion'];
      $themeFile = $targetFile;
      // Use PDO to insert data into the database
      $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      $stmt = $pdo->prepare("INSERT INTO themes (name, version, file) VALUES (:name, :version, :file)");
      $stmt->bindParam(':name', $themeName);
      $stmt->bindParam(':version', $themeVersion);
      $stmt->bindParam(':file', $themeFile);
      $stmt->execute();
      // Success message
      echo "Theme uploaded successfully!";
    } else {
      // Error message
      echo "Failed to upload theme. Please try again.";
    }
  }
  
?>
