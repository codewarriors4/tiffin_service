  function block_request(id)
    {
      var result = confirm("Are you sure you want to block this user?");
        if(result==true)
          {
            window.location = "block/"+id;
          }
    }

    function delete_request(id)
    {
      var result = confirm("Are you sure you want to block this user?");
        if(result==true)
          {
            window.location = "delete/"+id;
          }
    }

    function unblock_request(id)
    {
       var result = confirm("Are you sure you want to Unblock this user?");
        if(result==true)
          {
            window.location = "unblock/"+id;
          }
    }

    function clear_search_box()
    {
     // var boxid = document.getElementById('search_box');
      alert("hello");
    }

    function modify_request(id){

      var domain = "http://52.14.64.177/";

      if(window.location.hostname == "localhost"){

        domain = "http://localhost/tiffin_service/web/public/";
      }
      
    //  var domain = window.location.hostname
      var url = domain+"/approve";
      alert(url);
      var formData = {id:id};

      $.get( url+'/'+id, function( data ) {
      
         
      
}).done(function() {
     window.location = "manageusers";
  });

    
    }