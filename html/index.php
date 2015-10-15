<?php include 'config.php' ?><!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Validação SIG</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="<?php echo CONNECT_URL ?>/js/connect.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    var test = <?php echo (getenv('PHP_ENV')=='test'?'true':'false') ?>;
  </script>
  <script src="app.js" type="text/javascript"></script>
  <style type="text/css">
    .container {
      margin-top: 50px;
    }
    .form-group.required .control-label:after {
        content:"*";
        color:red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Validação SIG</h2>
      <!--<p class="msg alert alert-success" id="success" style="display:none">Download realizado com sucesso!</p>-->
    <?php if( isset($_GET["msg_alerta"])  && $_GET["msg_alerta"] != ""): ?>
      <p class="msg alert alert-danger"><?php echo $_GET["msg_alerta"] ;?></p>
    <?php endif;?>
    <?php if( isset($_GET["msg_warning"]) && $_GET["msg_warning"] != ""): ?>
      <p class="msg alert alert-warning"><?php echo $_GET["msg_warning"] ;?></p>
    <?php endif;?>
    <form id="login">
      <div class='form-group'>
        <button id="login-bt" class='btn btn-primary'>Login</button>
        <button id="logout-bt" class='btn btn-primary'>Logout</button>
      </div>
    </form>
    <form action="download.php" method="POST" id="app">
      <fieldset class=''>
        <div class="form-group required">
          <label for="src" class="control-label">Recorte</label>
          <select id="src" name="src" class='form-control'></select>
        </div>
        <div class="form-group required">
          <label for="family" class="control-label">Família</label>
          <select id="family" name="family" class='form-control'></select>
        </div>
        <div class="form-group">
          <label for="spp">Espécie (deixe em branco para todas as espécies)</label>
          <select id="spp" name="spp" class='form-control'></select>
        </div>
        <div class="form-group">
          <button id="download" type='submit' class='btn btn-primary'>Download CSV</button>
        </div>
      </fieldset>
    </form>
  </div>
</body>
</html>
