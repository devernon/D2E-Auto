<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="myModalLabel">Sign-up for News Letter</h4>
</div>
<div class="modal-body">
  <table id="contactForm" class="table" style="background-color: #FFFFFF;">
    <tbody>
    <tr><td>
      <div class="form-group">
          <input class="form-control" id="inputName" placeholder="Your Name" type="text">
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
          <input class="form-control" id="inputEmail" placeholder="Your E-Mail Address" type="text">
      </div>
    </td></tr>
    <tr><td>
    	<div id="viewLink"><button id="viewPrivy" type="button" class="btn btn-link">View our Privacy Promise</button></div>
        <div id='privy' class="panel panel-warning hidden">
        	<div class="panel-heading">
            	<h3 class="panel-title">D2E Auto Privacy Promise</h3>
            </div>
            <div class="panel-body">
				We at D2E Auto take your privacy very seriously. We will never give out or sell your email address. We don't overload your email with spam. If you decide to participate in our E-Mail Subscription Services you will receive an occasional Newsletter with news and specials and/or Service Reminders of when its time to return for an oil change or routine maintenance. Please understand that we value our customers and want them returning when you need service on your vehicle. We offer these as a convenience for our customers, not to be annoying advertisement. We are sure that you will return by the quality and low cost service we offer.
           </div>
           <div class="panel-footer"><button id="hidePrivy" type="button" class="btn btn-link">Hide our Privacy Promise</button></div>
        </div>
    </td></tr>
    <tr><td>
      <button id="saveButton" type="button" class="btn btn-success">Sign-Up</button>
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </td></tr>
    </tbody>
  </table>
</div>
<script>
  $('#viewPrivy').on('click', function() {
	  $('#viewLink').addClass('hidden');
	  $('#privy').removeClass('hidden');
  });
  $('#hidePrivy').on('click', function() {
	  $('#privy').addClass('hidden');
	  $('#viewLink').removeClass('hidden');
  });
  $('#saveButton').on('click', function() {
	  $('#saveButton').hide();
	  $.ajax({
			url: 'adder.php',
			type: 'post',
			data: {'name': $('#inputName').val(), 'email': $('#inputEmail').val() },
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