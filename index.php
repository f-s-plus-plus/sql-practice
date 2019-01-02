<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel='stylesheet' href="public/style.css" type='text/css'>
    <link rel='icon' href="https://cdn.onlinewebfonts.com/svg/img_54095.png?">
    <title>
      SQL Practice
    </title>
  </head>
  <body>
    <div class="pos-f-t">
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
          <h4 class="text-white">Collapsed content</h4>
          <span class="text-muted">Toggleable via the navbar brand.</span>
        </div>
      </div>
      <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </div>
    <?php
      $db_server = 'localhost:3308';
      $db_username = 'root';
      $db_password = '';
      $db_name = "sql_practice";

      $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
      if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $sql = $_POST['sql-table'];

        if(strtoupper(trim($sql))[0] === 'S') {
          $result = $conn->query($sql);
          if($result->num_rows > 0) {
            echo '<br> <table>';
            $flag = true;
            while($row = $result->fetch_assoc()) {
              if($flag) {
                echo "<tr class='row-name'>";
                $columns = array_keys($row);
                foreach($columns as $entry) {
                  echo "<th> $entry </th>";
                }
                echo "</tr>";
                $flag = false;
              }
              $row_echo = "<tr>";
              foreach($row as $entry) {
                $row_echo = $row_echo . '<th>' . $entry . '</th>';
              }
              echo $row_echo . "<tr>";
            }
            echo '</table>';
          }
        }

        $error_msg;

        if($conn->query($sql)) {
        }
        else {
          $error_msg = mysqli_error($conn);
        }
      }
    ?>
    <form method="post" enctype="application/x-www-form-urlencoded">
      <div class="textarea-container">
        <textarea class='form-control' name='sql-table' > </textarea>
        <?php
          if(isset($error_msg)) {
            echo '<br> <div class="alert alert-danger" role="alert"><strong>SQL ERROR</strong> '. $error_msg . ' </div>';
          }
          if(isset($sql)) {
            echo '<div class="alert alert-primary" role="alert">' . $sql .' </div>';
          }
        ?>
      </div>
      <button class="btn btn-primary" type='submit'> Submit </button>
    </form>
    <h5> Tables </h5>
    <div class="table-title-container">
      <?php
        $show = "SHOW TABLES FROM $db_name";
        $result = $conn->query($show);
        if($result) {
          while($row = $result->fetch_assoc()) {
            foreach($row as $entry) {
              echo '<span class="badge badge-secondary">' . $entry . '</span>';
            }
          }
        }
      ?>
    </div>
  </body>
</html>
