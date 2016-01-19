<?php include 'config.php';
session_start(); ?><!DOCTYPE HTML>
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
 .panel-heading .accordion-toggle:after {
    /* symbol for "opening" panels */
    font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
    content: "\e114";    /* adjust as needed, taken from bootstrap.css */
    float: right;        /* adjust as needed */
    color: grey;         /* adjust as needed */
}
.panel-heading .accordion-toggle.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\e080";    /* adjust as needed, taken from bootstrap.css */
} </style>
</head>
<body>
  <div class="container">
    <h2>Validação SIG</h2>
    <?php if (!(( isset($_SESSION["msg_alerta"])  && $_SESSION["msg_alerta"] != "" ) || (isset($_SESSION["msg_warning"]) && $_SESSION["msg_warning"] != ""))): ?>
    <p class="alert alert-info" align="justify"> <span class="glyphicon glyphicon-info-sign">
</span>&nbsp;&nbsp;Esta ferramenta foi criada para gerar os arquivos no formato
CSV das ocorrências necessárias para a elaboração dos mapas. Ela faz uma
verificação e só exporta os dados se todas as ocorrências da espécie tiverem
sido validadas pelos especialistas. Caso contrário, a ferramenta não permite o
download do arquivo CSV e aparece uma mensagem com o tipo de erro. Essa
ferramenta também faz o download e a conferência das ocorrências para uma família.</p>
    <?php endif;?>

    <?php if(( isset($_SESSION["msg_alerta"])  && $_SESSION["msg_alerta"] != "") || ( isset($_SESSION["msg_warning"]) && $_SESSION["msg_warning"] != "")): ?>
        <div class="panel-group msg" id="accordion">
    <?php endif;?>
    <?php if( isset($_SESSION["msg_alerta"])  && $_SESSION["msg_alerta"] != ""): ?>
            <div class="panel alert alert-danger">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Alertas impeditivos para download</a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body msg">
                        <p id="alerta"><?php echo $_SESSION["msg_alerta"] ;?></p>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['msg_alerta']); $set_div = true;?>
    <?php endif;?>
    <?php if( isset($_SESSION["msg_warning"]) && $_SESSION["msg_warning"] != ""): ?>
            <div class="panel alert alert-warning">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Alertas</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="panel-body msg">
                        <p id="warning"><?php echo $_SESSION["msg_warning"] ;?></p>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['msg_warning']); $set_div=true;?>
    <?php endif;?>
    <?php if (isset($set_div) && $set_div == true):?>
        </div>
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
        <div class="form-group">
          <label for="family" class="control-label">Família (deixe em branco para todas as famílias)</label>
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
