$('#usersReport').change(function(){
  var typeUser = document.getElementById("usersReport").value;

  if(typeUser == "Comprador"){
    window.open('../home/buyersUsersReport', '_blank' );
  } else {
    window.open('../home/sellersUsersReport', '_blank' );
  }

});
