<div class="col-md-12">
	<div class="shadow-box" style="padding: 20px;">
		<form class="frm" onsubmit="return checkbox(this)" method="post" action="#">
		  <div class="form-group">
		    <label>Question</label>
		    <input required="" type="text" class="form-control" placeholder="Start a topic over here" style="font-weight: bold;">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Content</label>
		    <textarea placeholder="Provide us an explaintation, we don't understand" class="form-control"></textarea>
		  </div>
		  <div class="form-check">
		    <label class="form-check-label">
		      <input type="checkbox" name="chkbox" class="form-check-input">
		      <small id="notif-ask">I swear my topic is respect each other</small>
		    </label>
		  </div>
		  <button type="submit" class="btn btn-primary" >Post</button>
		</form>
	</div>
</div>

<script type="text/javascript">
	function checkbox(form){
		var not = document.getElementById('notif-ask');
		if(!form.chkbox.checked){
        not.style.color = 'red';
	        return false;
	    } else {    
	        return true;
	    }
	}
</script>