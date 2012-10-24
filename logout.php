<? 
  if (session_id() == '') {
    session_destroy();
  }

  header("Location: index.php");
?>

