    <div class="modal fade" id="addLoan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form class="modal-content needs-validation" onsubmit="return newLoan();">
                    @csrf   
                    <div class="modal-header">
                        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bxs-message-square-add'></i> New Loan</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="divider">
                            <div class="divider-text">
                                Loan Details
                            </div>
                        </div>
                        <div class="row mb-2">
                            <input type="text" id="client_id2" required name="client_id2" hidden>
                            <label for="principle_amount2" class="col-sm-2 col-form-label">Principal Amount</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-credit-card' ></i></span>
                                    <input type="text" id="principle_amount2" required name="principle_amount2" class="form-control" placeholder="Principal Amount">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="rel_date2" class="col-sm-2 col-form-label">Release Date</label>
                            <div class="col-sm-10">
                                <input class="form-control" required type="date" id="rel_date2" name="rel_date2" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cycle2" class="col-sm-2 col-form-label">Cycle</label>
                            <div class="col-sm-10">
                                <input disabled type="text" class="form-control" id="cycle2" name="cycle2" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdLClose">Cancel</button>
                        <button type="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                </form>
            </div>
    </div>

    <script>
        function setForm(id, cycle){
            $('#cycle2').val(cycle);
            $('#client_id2').val(id);
        }
        function newLoan(){
                $('#mdLClose').click();
                var form = {
                    _token: $('input[name=_token]').val(),
                    client_id: $('#client_id2').val(),
                    principle_amount: $('#principle_amount2').val(),
                    rel_date: $('#rel_date2').val(),
                    cycle: $('#cycle2').val(),
                    ajax: 1
                }
                $.ajax({
                    url : "{{route('loans.store')}}",
                    data :  form,
                    type : "POST",
                    success : function(msg){
                        console.log(msg['message']);
                        if(msg['success']){
                            success(msg['message']);
                            setTimeout(function(){window.location.reload();},1500);
                        }else{
                            warning(msg['message']);
                        }
                    }
                })
                return false;
        }
    </script>