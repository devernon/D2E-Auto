<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="myModalLabel">Contact Us</h4>
</div>
<div class="modal-body">
  <table id="contactForm" class="table" style="background-color: #FFFFFF;">
    <thead><tr>
      <th>Please feel free to call us during business hours at (602) 761-7730.<br>If you'd like contact us via email please fill out this form and someone will get back to as soon as possible.</th>
    </tr></thead>
    <tbody>
    <tr><td>
      <div class="form-group">
          <label for="inputName" class="col-lg-2 control-label">Your Name</label>
          <div class="col-lg-10">
              <input class="form-control" id="inputName" placeholder="Your Name" type="text">
          </div>
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">E-Mail</label>
          <div class="col-lg-10">
              <input class="form-control" id="inputEmail" placeholder="Your E-Mail Address" type="text">
          </div>
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
          <label for="inputPhone" class="col-lg-2 control-label">Phone</label>
          <div class="col-lg-10">
              <input class="form-control" id="inputPhone" placeholder="Your Phone Number" type="text">
          </div>
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
          <label for="inputSubject" class="col-lg-2 control-label">Subject</label>
          <div class="col-lg-10">
              <input class="form-control" id="inputSubject" placeholder="Subject" type="text">
          </div>
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
          <label for="inputMessage" class="col-lg-2 control-label">Message</label>
          <div class="col-lg-10">
              <textarea class="form-control" id="inputMessage" rows="3"></textarea>
          </div>
      </div>
    </td></tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button id="saveButton" type="button" class="btn btn-success">Send</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
  $('#saveButton').on('click', function() {
	  $('#saveButton').hide();
	  $.ajax({
			url: 'sender.php',
			type: 'post',
			data: {'name': $('#inputName').val(), 'phone': $('#inputPhone').val(), 'email': $('#inputEmail').val(), 'subject': $('#inputSubject').val(), 'message': $('#inputMessage').val() },
			success: function(data, status) {
				console.log(data);
				if (data.substring(0, 6) == "FAILED") {
					if (data == "FAILED: No Name") {
						$('#inputName').parent().parent().addClass('has-error');
					} else {
						$('#inputName').parent().parent().removeClass('has-error');
					}
					if (data == "FAILED: Invalid Email") {
						$('#inputEmail').parent().parent().addClass('has-error');
					} else {
						$('#inputEmail').parent().parent().removeClass('has-error');
					}
					if (data == "FAILED: No Message") {
						$('#inputMessage').parent().parent().addClass('has-error');
					} else {
						$('#inputMessage').parent().parent().removeClass('has-error');
					}
					$('#saveButton').show();
				} else {
					$('#contactForm').remove();
					$('.modal-body').append(data);
				}
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
				alert("Details: " + desc + "\nError:" + err);
			}
		});	
		$(this).closest('#removeModal').modal('hide');
  });
</script>