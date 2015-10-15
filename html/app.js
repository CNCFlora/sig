window.onload = function() {

  var logged =true;

  if(!test) {
    logged=false;

    $("#logout-bt").hide();
    $("#app").hide();

    Connect({
        onlogin: function(user) {
          for(var i =0;i<user.roles.length;i++) {
            var context = user.roles[i];
            for(var j=0;j<context.roles.length;j++) {
              var role = context.roles[j];
              var role_name = role.role;
              if(role_name == 'admin') {
                logged=true;
              }
            }
          }
          if(logged) {
            $("#login-bt").hide();
            $("#logout-bt").show();
            $("#app").show();
          }
        },
        onlogout: function() {
          if(logged) {
            $("#login-bt").show();
            $("#logout-bt").hide();
            $("#app").hide();
          }
        }
    });

    $("#login").submit(function(){
        return false;
    });
    $("#logout-bt").click(function(){
        Connect.logout();
    });
    $("#login-bt").click(function(){
        Connect.login();
    });
  }

  $("#app .form-group").hide();
  $("#src").parent().show();

  function get(url,fn) {
    $.ajax({
      url: url,
      method: 'GET',
      success: function(d) { fn(d); },
      error: function(a,b) { console.log(a,b); }
    });
  }

  $("#src").html("<option>--</option>");
  get('dbs.php',
      function(dbs) {
        for(var d=0;d<dbs.length;d++) {
          $("#src").append("<option value='"+dbs[d]+"'>"+dbs[d].toUpperCase().replace("_"," ")+"</option>");
        }
      }
    );

  $("#src").change(function(){
      $("#family").parent().show();
      $("#family").html("<option>--</option>");
      get('families.php?db='+$("#src").val(),
        function(families) {
            console.log(families);
          for(var i=0;i<families.length;i++) {
            $("#family").append("<option value='"+families[i]+"'>"+families[i]+"</option>");
          }
        }
      );
  });

  $("#family").change(function(){
      $("#spp").parent().show();
      $("#download").parent().show();
      get('species.php?db='+$("#src").val()+'&family='+$("#family").val(),
        function(species) {
            $("#spp").html("<option value='"+JSON.stringify(species)+"'>--</option>");
          for(var i=0;i<species.length;i++) {
            $("#spp").append("<option value='"+species[i]+"'>"+species[i]+"</option>");
          }
        }
      );
  });

  $('#app').submit(function(){
      $(".msg").hide();
  });
};
