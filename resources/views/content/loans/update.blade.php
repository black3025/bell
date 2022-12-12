<form class="modal-content needs-validation" onsubmit="return inform();">
    @csrf   
    <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bx-user-plus' ></i> Edit Loans</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
        <input type="text" id="id" required name="id" class="form-control">
        <div class="row mb-2">
            <label for="principle_amount" class="col-sm-2 col-form-label">Principal Amount</label>
            <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-credit-card' ></i></span>
                    <input type="text" id="principle_amount" required name="principle_amount" class="form-control" placeholder="Principal Amount">
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <label for="rel_date" class="col-sm-2 col-form-label">Release Date</label>
            <div class="col-sm-10">
                <input class="form-control" required type="date" id="rel_date" name="rel_date"/>
            </div>
        </div>
        <div class="row mb-2">
            <label for="cycle" class="col-sm-2 col-form-label">Cycle</label>
            <div class="col-sm-10">
                <input disabled type="number" class="form-control" id="cycle" name="cycle" required value="">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdClose">Close</button>
        <button type="submit" class="btn btn-primary" value="submit">Update</button>
    </div>
</form>

<script>
    function inform(){
        $('#mdClose').click();
         var form = {
            _token: $('input[name=_token]').val(),
            id: $('#id').val(),
            principle_amount : $('#principle_amount').val(),
            rel_date : $('#rel_date').val(),
            cycle : $('#cycle').val(),
         }

         $.ajax({
	         url : "{{url('/loans/updateLoan')}}",
	         data :  form,
	         type : "POST",
	         success : function(msg){
                console.log(msg['success']);
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


