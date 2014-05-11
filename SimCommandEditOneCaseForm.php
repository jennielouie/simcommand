
<?php
include_once('SimCommandTemplates.php');

if(isset($_GET["case_id"])){
  $specificCaseID = $_GET["case_id"];
}

$url = "http://private-1c15-scapi.apiary-mock.com/cases/$specificCaseID";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("SCAPI_AUTH_TOKEN: 659d9194f1467c20d7a3a1fd6bbc6540e8ccf85498fad89f4988d85e8a718020"));
$httpresponse = curl_exec($ch);
curl_close($ch);


$json = json_decode($httpresponse, true);
$case=$json["body"];


// *****************
// //Iterate through each key:value pair in the json response object for a particular case ID.  All keys should exist in the form, but I use an if statement to be safe.  Iterate to grab the corresponding template object from the form, and add case-specific data in that template object's attributes.  So, these attributes will be associated with the template object when it is rendered.


// create form array

$form = array();
$form['header'] = $editCaseHeader;
$editCaseHeader->caseID = $specificCaseID;

//CASE INFO TAB
$form['startTab'] = $caseInfoTab;
$form['title'] = $title;
$form['id']=$caseID;
$form['case_number'] = $caseNumber;
$form['published_date']=$publishedDate;
$form['categories'] = $library_categories;
$form['addCategory']= $addAnotherCategory;
$form['overview'] = $overview;
$form['participants'] = $participants;
$form['addParticipant']=$addAnotherParticipant;
$form['institutions'] = $institutions;
$form['authors'] = $authors;
$form['resources'] = $resources;
$form['action_scale']=$actionScale;
$form['global_rating_scale'] = $globalRatingScale;
$form['assessment_item_scale'] = $assessmentItemScale;

//INSTRUCTIONAL FOUNDATION TAB
$form['ddd'] = $instructionalTab;
$form['instructional_goals'] = $instGoals;
$form['obj1_medical_knowledge'] = $obj1;
$form['obj2_patient_care'] = $obj2;
$form['obj3_safety_risk_management'] = $obj3;
$form['obj4_interpersonal'] = $obj4;
$form['obj5_professionalism'] = $obj5;
$form['obj6_systems_based_practice'] = $obj6;
$form['study_questions'] = $studyQs;
$form['briefing'] = $briefing;
$form['debriefing'] = $debriefing;

//ASSESSMENT TAB
$form['assessmentTab'] = $assessmentTab;
$form['assessment_items'] = $allAssessments;

// PREPARATION TAB
$form['prepTab'] = $preparationTab;
$form['simulators'] = $simulators;
$form['simulator_programs'] = $simulatorPrograms;
$form['medical_equipment'] = $medEqmt;
$form['medications'] = $medications;
$form['moulage'] = $moulage;
$form['supplies'] = $supplies;
$form ['fsdfsdf'] = $expectedActionsTab;

//CASE DETAILS TAB
$form['caseDetailsTab'] = $caseDetailsTab;
$form['background']=$background;
$form['gender']=$gender;
$form['age']=$age;

// Initial Patient Examinations
//id
$form['ipe_id']=$hiddenIPEid;
$form['general']=$generalIPE;
$form['heent']=$heent;
$form['neck']=$neck;
$form['lungs']=$lungs;
$form['heart']=$heart;
$form['abdomen']=$abdomen;
$form['extremeties']=$extremities;
$form['neurological']=$neurological;
$form['other']=$otherIPE;
//end of IPE fields

$form['states'] = $allStates;

$form['end tab'] = $endTabs;
$form['closing'] = $closing;


//Iterate through each key:value pair in the json response object for a particular case ID.  Iterate to grab the corresponding template object from the form, and add case-specific data in that template object's attributes.  So, these attributes will be associated with the template object when it is rendered.

foreach($case as $jkey => $jvalue) {


//IPE fields are nested under 'initial_patient_examination' key, so this if statement checks for that key and loops through the key's value array
if ($jkey == 'initial_patient_examination')
{

  foreach($jvalue as $ipekey => $ipevalue) {


    if($ipekey=="id")
    {
      $spec_form_template = $form['ipe_id'];
    }
    else
    {
      $spec_form_template = $form[$ipekey];
    }
      $spec_form_template->addsingletext($ipevalue);
    };
}
//The rest of the fields are accessible directly from key
else
{
    if (array_key_exists($jkey, $form)) {
      $spec_form_template = $form[$jkey];
//e.g. $spec_form_template = $form['authors'];
      switch ($spec_form_template->type) {
        case "checkbox":
          foreach($jvalue as $isacheckedvalue) {
            $spec_form_template->addselected($isacheckedvalue, 'checked');
          };
        break;

        case "textarray":
          $spec_form_template->addtextarray($jvalue);
        break;
          // need to check that only one value specified for the parameters below

        case "singletext":
          $spec_form_template->addsingletext($jvalue);
        break;
        case "dropdown":
          $spec_form_template->addselected($jvalue, 'selected');
        break;


        case "allStates":
          $statesArray = [];
          //$jvalue is an array of states, so loop through all states in json response
          foreach($jvalue as $stateIndex=>$state) {
            $actions = array();
            //loop though actions and add to the state's "actions" array
            foreach($state['actions'] as $actionIndex=>$action) {
              $actions[] = new Template('mkOneAction.php', array(
                'action_id'=>$action['id'],
                'is_critical_item'=>$action['is_critical_item'],
                'name'=>$action['name'],
                'results'=>$action['results'],
                'critical_item_label'=>'Critical Item?',
                'critical_item_tooltip'=>'',
                'critical_item_values'=>array('True'=>'','False'=>''),
                'timer_tooltip'=>'',
                'timer_label'=>'Include Timer?',
                'timer_values'=>array('True'=>'','False'=>'')
              ));
            }
            //create state object
            $oneState = new Template('mkOneStateObject.php', array(
              'state_id'=>$state['id'],
              'notes'=>$state['notes'],
              'general'=>$state['general'],
              'temp_celcius'=>$state['temp_celcius'],
              'resp_rate'=>$state['resp_rate'],
              'heart_rate'=>$state['heart_rate'],
              'bpSystolic'=>$state['bp_systolic'],
              'bpDiastolic'=>$state['bp_diastolic'],
              'spo2'=>$state['spo2'],
              'weight'=>$state['weight'],
              'pain_score'=>$state['pain_score'],
              'other'=>$state['other'],
              'discussion_items'=>$state['discussion_items'],
              'type'=>'oneState',
              'actions'=>$actions
            ));

            //add states to array of states
            $statesArray[] = $oneState;
          }

          //update the form's $allStates 'statesArray' array
          //$spec_form_template['statesArray'] = $statesArray;
          $allStates = new Template('mkAllStates.php', array('type'=>'allStates','statesArray'=>$statesArray,'is_critical_item'=>'','critical_item_label'=>'','critical_item_tooltip'=>'','critical_item_values'=>array('True'=>'','False'=>''),'timer_tooltip'=>'','timer_label'=>'Include Timer?','timer_values'=>array('True'=>'','False'=>'')));
          $form['states'] = $allStates;
        break;

        case "allAssessments":
        $assessmentsArray = [];

          foreach($jvalue as $assessmentIndex=>$assessment) {
            // create a new assessment, and then add to assessment array
            $newAssessment = new Template('mkOneAssessmentObject.php', array(
              'assessment_id'=>$assessment['id'],
              'name'=>$assessment['name'],
              'is_critical_item'=>$assessment['is_critical_item'],
              'type'=>'oneAssessment',
              'name_tooltip'=>'',
              'scale_tooltip'=>'',
              'scale_label'=>'Scale',
              'namePrefix'=>'assessment_items',
              'values' => array('2'=>'', '3'=>'', '4'=>'', '5'=>'', '6'=>''),
              'critical_tooltip'=>'',
              'critical_label'=>'Critical Item?',
              'label'=>'Scale',
              'scale_values'=> array('2'=>'', '3'=>'', '4'=>'', '5'=>'', '6'=>''),
              'critical_values'=> array('True'=>'','False'=>'')
            ));

            $assessmentsArray[] = $newAssessment;
          };

        $allAssessments = new Template('mkAllAssessments.php', array('type'=>'allAssessments','assessmentsArray'=>$assessmentsArray));
        $form['assessment_items'] = $allAssessments;
        break;
      }
    }
  }
};

// Finally, render form with case-specific data pre-loaded in fields.
render_formarray($form);



?>