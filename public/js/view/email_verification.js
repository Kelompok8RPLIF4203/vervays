console.log('ready2');
$(document).ready(function() {
	console.log('ready');
  $('#btnLogout').click(function(event) {
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
});