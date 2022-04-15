jQuery(document).ready(function () {

  // add post 
  jQuery("#addexpertpost").on('submit', (function (e) {
    e.preventDefault();

    var expert_title = jQuery("#expert_title").val();
    var nonce = jQuery("#nonce").val();

    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    if (expert_title == "") {
      jQuery("#expert_title").addClass("error");

    } else {
      jQuery("#expert_title").removeClass("error");

      jQuery.ajax({
        type: "POST",
        url: myAjax.ajaxurl,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          var stringified = JSON.stringify(response);
          var obj = JSON.parse(stringified);
          location.reload();

          // if (obj.postadd == true) {
          //   jQuery('#sucess_box').html("<span style='color:green;'>" + obj.message + "</span>");
          //   setTimeout(function () { window.location = " "; }, 3000);
          // }
          // else {
          //   jQuery('#sucess_box').html("<span style='color:red;'>" + obj.message + "</span>");

          // }
        }
      });




    }


  }));

 /// edit post 

 jQuery("#editexpost").on('submit', (function (e) {
  e.preventDefault();

  var expert_title = jQuery("#expert_title").val();

  var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

  if (expert_title == "") {
    jQuery("#expert_title").addClass("error");

  } else {
    jQuery("#expert_title").removeClass("error");

    jQuery.ajax({
      type: "POST",
      url: myAjax.ajaxurl,
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (response) {
        var stringified = JSON.stringify(response);
        var obj = JSON.parse(stringified);
        //
        location.reload();
     
        // if (obj.postedit) {
        
        //   jQuery('#sucess_box').html("<span style='color:green;'>" + obj.message + "</span>");
        //   setTimeout(function () { window.location =" "; }, 3000);
        // }
        // else {
        //   jQuery('#sucess_box').html("<span style='color:red;'>" + obj.message + "</span>");

        // }
      }
    });




  }


}));



 // delete post
  jQuery(".expert-front-post-id").on('click', (function (e) {

    var did = jQuery(this).attr("data-did");
    var nonce = jQuery(this).attr("data-nonce");


    if (confirm('Are you sure delete this post.')) {

      jQuery.ajax({
        type: 'POST',
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "expert_add_delete_posts", nonce: nonce, did: did },
        success: function (response) {
          var stringified = JSON.stringify(response);
          var obj = JSON.parse(stringified);
          //  console.log(obj);
          if (obj.postdelete == true) {
            location.reload();
          }

        }
      });

    }

  }));


});
