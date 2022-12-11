<form class="modal-content needs-validation" id="roleCreate" onsubmit="return informUpdate();">
    @csrf   
    <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bx-user-plus' ></i> Update Role</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
            <div class="row mb-2">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" hidden id="Uid" name="Uid" value="" class="form-control">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="Uname" name="Uname" value="" class="form-control" placeholder="Role Name" required autofocus>
                    </div>                    
                </div>
            </div>   
            <div class="row mb-2">                   
                <label class="col-sm-2 col-form-label" for="role">restriction</label>
                <div class="col-sm-10">
                    <select class="form-select" id="Urestriction" name="Urestriction" required>
                        <option selected value="">Choose...</option>
                        <option value="2">Secretary</option>
                        <option value="3">User</option>
                    </select>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdCloseUpdate">Close</button>
        <button type="submit" class="btn btn-primary" value="submit">Save</button>
    </div>
</form>

<script>
    function informUpdate(){
        $('#mdCloseUpdate').click();
         var form = {
            _token: $('input[name=_token]').val(),
            id: $('#Uid').val(),
            name: $('#Uname').val(),
            restriction: $('#Urestriction').val(),
            is_active : 1,
            ajax: 1
         }
         var id = $('#Uid').val();

         $.ajax({
	         url : "{{ url( 'roles/update') }}/"+ id,
	         data :  form,
	         type : "POST",
	         success : function(msg){
                //console.log(msg['message']);
                if(msg['success']){
                    success(msg['message']);
                    setTimeout(function(){window.location.reload();},1500);
                }else{
                    error(msg['message']);
                }
             }
        })
        return false;
    }
</script>


