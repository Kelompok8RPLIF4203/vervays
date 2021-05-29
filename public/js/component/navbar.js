$(document).ready(function() {
  $("#collapsedSection").hide();
  var width = $(window).width();
  if (width < 992) {
    $(".navbar").hide();
  }
  else {
    $(".responsive-navbar").hide();
  }

  $('.linkLogout').click(function(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin ingin logout?',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya',
      cancelButtonText : 'Tidak'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url : "/logout",
          method : "POST",
        }).done(function() {
          window.location.href = "/";
        });
      }
    });
  });

  $('.linkMenjadiPublisher').click(function(event) {
    event.preventDefault();
    $.ajax({
      url : "/bepublisher",
      method : "POST"
    }).done(function() {
      window.location.href = "/publisher/dashboard";
    });
  });
});

function NavbarWindowChangeListener() {
  var width = $(window).width();
  if (width < 992) {
    $(".responsive-navbar").show();
    $(".navbar").hide();
  }
  else {
    $(".responsive-navbar").hide();
    $(".navbar").show();
  }
}

$(window).on('resize', NavbarWindowChangeListener);

$("#nav-toggler").click(function() {
  if ($("#nav-toggler").attr("isCollapsed") == "1") {
    $("#collapsedSection").show(1000);
    $("#nav-toggler").attr("isCollapsed", 0);
  }
  else {
    $("#collapsedSection").hide(1000);
    $("#nav-toggler").attr("isCollapsed", 1);
  }
});

document.getElementById("defaultSearchBar").addEventListener("keypress", searchBarOnKeypressListener);
function searchBarOnKeypressListener(event) {
  if ( event.key == "Enter" ) {
    if ($('#defaultSearchBar').val() === "") {
      console.log('kosong');
    }
    else {
      var keyword = $('#defaultSearchBar').val();
      keyword = string_to_slug(keyword);
      console.log(keyword);
      window.location.href = "/search?keyword="+keyword;
    }
  }
}

document.getElementById("responsiveSearchBar").addEventListener("keypress", responsiveSearchBarOnKeypressListener);
function responsiveSearchBarOnKeypressListener(event) {
  if ( event.key == "Enter" ) {
    if ($('#responsiveSearchBar').val() === "") {
      console.log('kosong');
    }
    else {
      var keyword = $('#responsiveSearchBar').val();
      keyword = string_to_slug(keyword);
      console.log(keyword);
      window.location.href = "/search?keyword="+keyword;
    }
  }
}
