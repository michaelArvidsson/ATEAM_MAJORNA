<html lang="sv">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Majorna vårdcentral</title>
  <style>
    body {
      background-color: #1fa6a1;
    }

    h1 {
      text-align: center;
      padding: 15px;
      text-transform: uppercase;
      letter-spacing: 5;
      font-size: 50px;
    }
  </style>
</head>

<body>
  <h1>välkommen till Majornas Vårdcentral</h1>
  <pre>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $cookiepath = "/tmp/cookies.txt";
  $tmeout = 3600; // (3600=1hr)

  // här sätter ni er domän
  $baseurl = 'https://ateam.erpnext.com/api/resource/';

  try {
    $ch = curl_init($baseurl . 'api/method/login');
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }

  curl_setopt($ch, CURLOPT_POST, true);

  // Här sätter ni era login-data
  curl_setopt($ch, CURLOPT_POSTFIELDS, '{"usr":"michael.arvidsson@gmail.com", "pwd":"Erpnext4044!"}');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
  curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  $response = json_decode($response, true);


  $error_no = curl_errno($ch);
  $error = curl_error($ch);
  curl_close($ch);

  if (!empty($error_no)) {
    echo "<div style='background-color:red'>";
    echo '$error_no<br>';
    var_dump($error_no);
    echo "<hr>";

    echo '$error<br>';
    var_dump($error);
    echo "<hr>";
    echo "</div>";
  }

  echo "<div style='background-color:lightgray; border:1px solid black'>";
  echo '$response<br><pre>';
  echo print_r($response) . "</pre><br>";
  echo "</div>";

  $ch = curl_init($baseurl . 'Patient%20Encounter');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
  curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  $response = json_decode($response, true);


  $error_no = curl_errno($ch);
  $error = curl_error($ch);
  curl_close($ch);


  //create an array of encounter names
  // --- TO DO ---- Fix count length array
  $arr_encounter = array();
  for ($i = 0; $i < 5; $i++) {
    echo $response["data"][$i]["name"];
    array_push($arr_encounter, $response["data"][$i]["name"]);
  }
  echo print_r($arr_encounter);

  $encounter = $arr_encounter[1];

  // assign variable url to pull out each encounter
  $ch = curl_init($baseurl . 'Patient%20Encounter/' . $encounter);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
  curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  $response = json_decode($response, true);


  $error_no = curl_errno($ch);
  $error = curl_error($ch);
  curl_close($ch);

  echo "<div style='background-color:yellow; border:1px solid black'>";
  echo 'Result<br><pre>';
  //echo print_r($response) . "</pre><br>";
  echo print_r($response['data']['drug_prescription']['0']['drug_name']);
  // ---- TO DO ------ if loop to check patient
  // ---- TO DO ------ Create array of all meds use arrayunique then put in dropdown
  // ---- TO DO ------ create hidden input for sending patient to prescription
  // Dropdown prescription
  echo '<form action="Get PRescriptionlist.php" method="POST">';
  echo '<select name="drug">';
  // --- TO DO --- Count the length of array drug_prescription set i less than length of array
  for ($i = 0; $i < 2; $i++) {
    echo '<option value=' . $response['data']['drug_prescription'][$i]['drug_name'] . ' >' . $response['data']['drug_prescription'][$i]['drug_name'] . '</option>';
  }
  /*     foreach ($value as $valuekey => $valuevalue) {
      echo $valuekey . " " . $valuevalue . "<br>";
      //echo '<option value=' . $valuevalue['drug_name'] . ' >' . $valuevalue['drug_name'] . '</option>';
    } */

  //echo '<option value=' . $response['data']['drug_prescription']['0']['drug_name'] . ' >' . $response['data']['drug_prescription']['0']['drug_name'] . '</option>';
  echo '</select>';
  echo '</form>';
  echo "</div>";


  if (!empty($error_no)) {
    echo "<div style='background-color:red'>";
    echo '$error_no<br>';
    var_dump($error_no);
    echo "<hr>";

    echo '$error<br>';
    var_dump($error);
    echo "<hr>";
    echo "</div>";
  }

  echo "<div style='background-color:lightgray; border:1px solid black'>";
  echo '$response<br><pre>';
  echo print_r($response) . "</pre><br>";
  echo "</div>";
  ?>
</pre>


</body>

</html>