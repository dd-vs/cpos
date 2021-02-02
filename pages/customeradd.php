	 <div class="popup-container">
            <div class="pop-up-title nomargin" style="">Quick Add Customer</div>
            <div class="row" style="padding:10px;"></div>
	        <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Name</span>
                            </span>
                            <input type="text" class="form-control" name="name"  id="AdmtxtName" value=""  placeholder="Customer Name" required tabindex="1"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Mobile</span>
                            </span>
                            <input type="text" class="form-control" name="mobile" id="Adm_txtMob" value="" pattern="^(\+[0-9]{1,5})?([1-9][0-9]{9})$" placeholder="Enter 10 digit mobile number" required tabindex="2"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="req">Opening Balance</span>
                            </span>
                            <input type="number" class="form-control" name="balance"  id="Admtxtbal" value=""  placeholder="Balance" required tabindex="6" />
                        </div>
                    </div>
                </div>
                <div class="row no-screen" id="toggelon">
                    <div class="col-md-6">
                        <div class="col-md-6 -txt"><label>Status</label></div>
                        <input type="hidden" name="isactive" id="isactive" value="1"> 
                        <div class="txt- col-md-4" id="customer-on"><i class="fa fa-toggle-on blue"  aria-hidden="true"></i> Active</div>
                        <div class="txt- col-md-4"  id="customer-off" style="display:none;"><i class="fa fa-toggle-off blue"  aria-hidden="true"></i> InActive</div>
                    </div>
                </div>
                <div class="row -txt-" style="margin-top: 20px; margin-bottom: 20px;"><button id="custadd" class="btn btn-primary" tabindex="10">Save</button></div>
        </div>
<script>
$('#custadd').click(function() {
		$.post('../add/custumersave.php',{name:$('#AdmtxtName').val(),mobile:$('#Adm_txtMob').val(),balance:$('#Admtxtbal').val(),isactive:$('#isactive').val()},function(data) {
			alert('save succesfully');
			$('.closebtn').click();
		});
	});


</script>
