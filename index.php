<?php
    include 'login.php';
    require_once 'api/client.php';
    require_once 'api/domainuser.php';
    require_once 'api/xmlfile.php';
    require_once 'api/domainread.php';
    require_once 'api/domainoperations.php';
  
    $domaingroups = getDomainGroups();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Miquel A. Cabot">
  <title><?php echo APPLICATION_NAME;?></title>
  <!-- Bootstrap core CSS-->
  <link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="libraries/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="index.php"><?php echo APPLICATION_NAME;?></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Inici">
        <a class="nav-link" id="homelink">
          <i class="fa fa-fw fa-home"></i>
          <span class="nav-link-text">Inici</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuaris del domini">
        <a class="nav-link" id="usuarisdominilink">
          <i class="fa fa-fw fa-users"></i>
          <span class="nav-link-text">Usuaris del domini</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Exportar a un full de càlcul">
        <a class="nav-link" id="fullcalcullink">
          <i class="fa fa-fw fa-table"></i>
          <span class="nav-link-text">Exportar a un full de càlcul</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Importar XML">
        <a class="nav-link" id="xmllink">
          <i class="fa fa-fw fa-file"></i>
          <span class="nav-link-text">Importar XML</span>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
          <i class="fa fa-fw fa-sign-out"></i>Sortir</a>
      </li>
    </ul>
  </div>
</nav>
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Importar fitxer XML de GestIB -->
    <div id="importarxml" style="display: none;">
      <div class="card mb-3" >
        <div class="card-header">
          <i class="fa fa-file"></i> Importar fitxer XML de GestIB</div>
        <div class="card-body">
          <form action="importgestib.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="xmlfile">Fitxer XML de GestIB</label>
              <input class="form-control" id="xmlfile" name="xmlfile" type="file" placeholder="File" required="required">
            </div>
           <!-- <div class="form-group">
              <label for="domain">Domini</label>
              <input class="form-control" id="domain" name="domain" type="text" placeholder="Domini" value="iesemilidarder.com">
            </div>
            <div class="form-group">
              <label for="tutorsgroup">Nom del grup de tutors</label>
              <input class="form-control" id="tutorsgroup" name="tutorsgroup" type="text" placeholder="Grup tutors" value="tutors">
            </div>
            <div class="form-group">
              <label for="teachersgroup">Prefix dels grups de professors</label>
              <input class="form-control" id="teachersgroup" name="teachersgroup" type="text" placeholder="Prefix" value="ee.">
            </div>
            <div class="form-group">
              <label for="studentsgroup">Prefix dels grups d'alumnes</label>
              <input class="form-control" id="studentsgroup" name="studentsgroup" type="text" placeholder="Prefix" value="alumnat.">
            </div> -->
            <div class="form-group">
              <label for="groupstaulausuaris" class="col-sm-2 col-form-label">Grups</label>
              <div class="col-sm-10">
                <select class="form-control" id="groupstaulausuaris" name="group">
                  <option value="">Tots</option>
    <?php
        foreach ($domaingroups as $group) {
          if (strpos($group['email'], STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group['email'], STUDENTS_GROUP_PREFIX.'bat') == 0) {
            echo('<option value="'.$group['email'].'">'.str_replace("Alumnat ","",$group['name']).'</option>');
          }
        }
    ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label"> 
                <input class="form-check-input" id="onlyteachers" name="onlyteachers" type="checkbox"> Només professorat</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label"> 
                <input class="form-check-input" id="apply" name="apply" type="checkbox"> Aplicar canvis</label>
              </div>
            </div>
            <input type="submit" value="Importar">
          </form>
        </div>
      </div>
    </div>
    <!-- Fi importar fitxer XML de GestIB -->

<!-- Mostrar usuaris del domini -->
<div id="usuarisdomini" style="display: none;">
      <div class="card mb-3" >
        <div class="card-header">
          <i class="fa fa-users"></i> Mostrar usuaris del domini</div>
        <div class="card-body">
          <form action="showusers.php" method="GET">
          <div class="form-group">
            <label for="groupsusuarisdomini" class="col-sm-2 col-form-label">Grups</label>
            <div class="col-sm-10">
              <select class="form-control" id="groupsusuarisdomini" name="group">
                <option value="">Tots</option>
  <?php
      foreach ($domaingroups as $group) {
        if (strpos($group['email'], STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group['email'], STUDENTS_GROUP_PREFIX.'bat') == 0) {
          echo('<option value="'.$group['email'].'">'.str_replace("Alumnat ","",$group['name']).'</option>');
        }
      }
  ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
              <div class="form-check">
                <label class="form-check-label"> 
                <input class="form-check-input" id="onlyteachers" name="onlyteachers" type="checkbox"> Només professorat</label>
              </div>
          </div>
          <div class="form-group">
              <div class="form-check">
                <label class="form-check-label"> 
                <input class="form-check-input" id="onlyactive" name="onlyactive" type="checkbox"> Només usuaris actius</label>
              </div>
          </div>
          <div class="form-group">
              <div class="form-check">
                <label class="form-check-label"> 
                  <input class="form-check-input" id="onlywithoutcode" name="onlywithoutcode" type="checkbox"> Només els usuaris sense ID
                </label>
              </div>
          </div>
          <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" id="onlynotsession" name="onlynotsession" type="checkbox"> Només els usuaris que no han iniciat mai sessió
                </label>
              </div>
          </div>  
          <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" id="onlywithoutorgunit" name="onlywithoutorgunit" type="checkbox"> Només els usuaris de la Unitat Organitzativa principal (/)
                </label>
              </div>
            </div>
          <div class="form-group">
            <input type="submit" value="Mostrar">
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Fi Mostrar usuaris del domini-->
        
    <!-- Exportar a full de càlcul -->
    <div id="fullcalcul" style="display: none;">
      <div class="card mb-3" >
        <div class="card-header">
          <i class="fa fa-table"></i> Exportar a un full de càlcul</div>
        <div class="card-body">
          <form action="spreadsheet.php" method="GET">
          
          <div class="form-group">
            <input type="submit" value="Exportar">
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Fi Exportar a full de càlcul-->

    <!-- Inici -->
    <div id="taulainici" class="card mb-3">
      <div class="card-header">
        <i class="fa fa-home"></i> Inici</div>
      <div class="card-body">
        <p>Benvingut al programa d'importació de dades del GestIB al domini de Google.</p>
        <p>El fitxer XML amb les dades del professorat/alumnat s'ha de descarregar del <a href="https://www3.caib.es/xestib/">GestIB</a>, de l'opció de menú "Alumnat --> Exportació dades SGD".</p>
        <p>S'actualitzaran les dades del professorat i l'alumnat del domini Google <strong><?php echo DOMAIN?></strong>.</p>
        <p>Només s'actualitzaran els usuaris del domini que estiguin a les unitats organitzatives <strong>"/"</strong>, <strong>"<?php echo TEACHERS_ORGANIZATIONAL_UNIT?>"</strong> i <strong>"<?php echo STUDENTS_ORGANIZATIONAL_UNIT?>"</strong> i tenguin un Employee_ID.</p>
        <p>Els nous usuaris es crearan amb el password per defecte <strong>"<?php echo DEFAULT_PASSWORD?>"</strong> i l'hauran de canviar el primer pic que entrin.</p>
      </div>
    </div>
  </div>
  <!-- End inici -->
  
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright © Miquel A. Cabot 2017</small>
      </div>
    </div>
  </footer>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Realment vol sortir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pitgi "Sortir" si vol finalitzar la sessió actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel·lar</button>
          <a class="btn btn-primary" href="logout.php">Sortir</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="libraries/jquery/jquery.min.js"></script>
  <script src="libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="libraries/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="libraries/datatables/jquery.dataTables.js"></script>
  <script src="libraries/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.js"></script>
  <!-- Custom scripts for this page-->
  <!-- <script src="js/sb-admin-datatables.js"></script> -->
  <script>
    $(document).ready(function(){
        $("#homelink").click(function(){
          $("#taulainici").show();
          $("#usuarisdomini").hide();
          $("#fullcalcul").hide();
          $("#importarxml").hide();
        });
        $("#usuarisdominilink").click(function(){
          $("#taulainici").hide();
          $("#usuarisdomini").show();
          $("#fullcalcul").hide();
          $("#importarxml").hide();
        });
        $("#fullcalcullink").click(function(){
          $("#taulainici").hide();
          $("#usuarisdomini").hide();
          $("#fullcalcul").show();
          $("#importarxml").hide();
        });
        $("#xmllink").click(function(){
          $("#taulainici").hide();
          $("#usuarisdomini").hide();
          $("#fullcalcul").hide();
          $("#importarxml").show();
        });
    });
  </script>
</div>
</body>

</html>
