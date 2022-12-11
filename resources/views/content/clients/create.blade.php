<form class="modal-content needs-validation" onsubmit="return inform();">
    @csrf   
    <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bx-user-plus' ></i> Create New Client</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
            <div class="row mb-2" >
                <input hidden tabindex="-1"  class="form-control" id="account_name" name="account_name" autocomplete="off" value="" required>
            </div>
            <div class="row mb-2">
                <label for="first_name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="first_name" name="first_name" value="" class="form-control" placeholder="Enter Given Name" required autofocus>
                    </div>
                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                </div>
            </div>
            <div class="row mb-2">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="middle_name" onchange="acctname()"  name="middle_name" value="" class="form-control" placeholder="Enter Middle Name">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="last_name" name="last_name" value="" class="form-control" placeholder="Enter SurName" required>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="business" class="col-sm-2 col-form-label">Business</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                        <input type="text" id="business" name="business" class="form-control" placeholder="Business">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="income" class="col-sm-2 col-form-label">Income Source</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-money"></i></span>
                        <input type="text" id="income" name="income" class="form-control" placeholder="Other Source of Income">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="contact_number" class="col-sm-2 col-form-label">Mobile #</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-phone"></i></span>
                        <input type="number" id="contact_number" name="contact_number" class="form-control" placeholder="09XXXXXXXX">
                    </div>
                </div>
            </div>
            <div class="row mb-2">                   
                <label class="col-sm-2 col-form-label" for="area">Area</label>
                <div class="col-sm-10">
                    <select class="form-select" id="area" name="area" required>
                        <option selected value="">Choose...</option>
                        @foreach($areas as $area)
                            <option value="{{$area['id']}}">{{$area['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-home"></i></span>
                        <input type="text" id="address" required name="address" class="form-control" placeholder="Complete address">
                    </div>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">
                    Loan Details
                </div>
            </div>
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
                    <input class="form-control" required type="date" id="rel_date" name="rel_date" value="{{date('Y-m-d')}}"/>
                </div>
            </div>
            <div class="row mb-2">
                <label for="cycle" class="col-sm-2 col-form-label">Cycle</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" min="1"; id="cycle" name="cycle" required value="1">
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdClose">Close</button>
        <button type="submit" class="btn btn-primary" value="submit">Save</button>
    </div>
</form>

<script>
    function inform(){
        $('#mdClose').click();
         var form = {
            _token: $('input[name=_token]').val(),
            account_name: $('#account_name').val(),
            first_name : $('#first_name').val(),
            middle_name : $('#middle_name').val(),
            last_name : $('#last_name').val(),
            address : $('#address').val(),
            business : $('#business').val(),
            area_id : $('#area').val(),
            income : $('#income').val(),
            contact_number : $('#contact_number').val(),
            is_active : 1,
            principle_amount: $('#principle_amount').val(),
            rel_date: $('#rel_date').val(),
            cycle: $('#cycle').val(),
            ajax: 1
         }

         $.ajax({
	         url : "{{route('clients.store')}}",
	         data :  form,
	         type : "POST",
	         success : function(msg){
                //console.log(msg['success']);
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


