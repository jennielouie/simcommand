<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $this->tabTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $this->stylesheet; ?>" />

    <?php foreach($this->javascript as $script) {?>
    <script src="<?php echo $script; ?>"></script>
    <?php } ?>
<script src="/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>



<script type="text/javascript">

function loadTinyMCEEditor() {
  tinyMCE.init({
    selector: "textarea.textareaMCE",
    entity_encoding : "named+numeric",

    toolbar: "undo redo | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link "
  });
}
loadTinyMCEEditor();

</script>
  </head>

  <body>

    <div class="row">
      <form id="simCommandForm" action="<?php echo $this->formAction;?>" method="post" novalidate>


<!-- NAV -->
<div class="row">
  <div class="small-12 columns">
    <div class="sticky">
      <!-- <div class="contain-to-grid"> -->
      <nav class="top-bar" data-topbar>
        <ul class="title-area">
          <!-- Title Area -->
          <li class="name">
            <h1><a href="#">SimCommand</a></h1>
          </li>
          <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
          <!-- <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li> -->
        </ul>

        <!-- <section class="top-bar-section"> -->

          <!-- Right Nav Section -->
          <!--           <ul class="right">
                      <li class="divider hide-for-small"></li>
                      <li><a href="#">Main Item 1</a></li>
                    </ul>
                  </section> -->

        <dl class="tabs" data-tab data-options="deep_linking: true">
          <dd class="active"><a href="#caseInfo">Case Info</a></dd>
          <dd><a href="#instructionalFoundation">Instructions</a></dd>
          <dd><a href="#assessment">Assessment</a></dd>
          <dd><a href="#preparation">Preparation</a></dd>
          <dd><a href="#caseDetails">Case Details</a></dd>
          <!-- <dd><a href="#expectedActions">States and Expected Actions</a></dd> -->
        </dl>

      </nav>
<!-- </div> -->
    </div>
  </div>
</div>

