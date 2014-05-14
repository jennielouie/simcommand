<!doctype html>
<?php
include_once('SimCommandConstants.php');
header('Content-Type: application/json');
$jsondata = json_encode($_POST);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$urlroot/cases");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaderArray);
$jsonresponse = curl_exec($ch);
$response = json_decode($jsonresponse, true);

//Grab id of new case from response body
$body = $response->body;
$thisCaseID = $body->id;
curl_close($ch);

?>

<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="stylesheet" href="foundationSimCommand.css" />
    <script src="modernizrSimCommand.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="simCommand.js"></script>
    <script src="http://cdn.foundation5.zurb.com/foundation.js"></script>
  </head>

  <body>
    <div class="row">
      <div class="small-12 columns">
        <div class="sticky">
          <nav class="top-bar" data-topbar>
            <ul class="title-area">
              <li class="name">
                <h1><a class="alwaysShow" href="#">SimCommand HTTP Response: Post New Case</a></h1>
              </li>
            </ul>
          </nav>

        </div>
      </div>
    </div>

    <div class="row requestbox">
      <h3>Request</h3>
      <p><?php print_r($jsondata); ?></p>
    </div>

    <div class="row responsebox">
      <h3>Response to POST request</h3>
      <p><?php print_r($response->result); ?></p>
      <p>Case ID: <?php echo $thisCaseID; ?></p>
    </div>

    <div class="row">
      <a class="alwaysShow button tiny" href="SimCommandEditOneCaseForm.php?case_id=<?php echo $thisCaseID; ?>">Continue to Edit this Case</a>
      <a class="alwaysShow button tiny" href="SimCommandGetAllCases.php">Back to All Cases</a>
      <a class="alwaysShow button tiny" href="SimCommandNewCaseForm.php">Create New Case</a>
    </div>

  </body>
</html>