<form class="modal-content needs-validation" id="areaCreate" onsubmit="return inform();">
    @csrf   
    <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bx-user-plus' ></i> Create New Area</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
            <div class="row mb-2">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="name" name="name" value="" class="form-control" placeholder="Area Name" required autofocus>
                    </div>                    
                </div>
            </div>   
            <div class="row mb-2">                   
                <label class="col-sm-2 col-form-label" for="area">Category</label>
                <div class="col-sm-10">
                    <select class="form-select" id="restriction" name="restriction" required>
                        <option selected value="">Choose...</option>                        
                        <option value="1">Regular</option>
                        <option value="2">Special</option>
                    </select>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdCloseAdd">Close</button>
        <button type="submit" class="btn btn-primary" value="submit">Save</button>
    </div>
</form>

<script>
    function inform(){
        $('#mdCloseAdd').click();
         var form = {
            _token: $('input[name=_token]').val(),
            name: $('#name').val(),
            restriction: $('#restriction').val(),
            is_active : 1,
            ajax: 1
         }

         $.ajax({
	         url : "{{route('areas.store')}}",
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


