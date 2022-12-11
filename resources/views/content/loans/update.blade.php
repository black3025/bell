    <div class="modal fade" id="editLoan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form class="modal-content needs-validation" onsubmit="return newLoan();">
                    @csrf   
                    <div class="modal-header">
                        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bxs-message-square-add'></i> Update Loan</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="divider">
                            <div class="divider-text">
                                Loan Details
                            </div>
                        </div>
                        <input type="text" id="Uid" name="Uid">
                        <div class="row mb-2">
                            <label for="principle_amount" class="col-sm-2 col-form-label">Principal Amount</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-credit-card' ></i></span>
                                    <input type="text" id="Uprinciple_amount" required name="Uprinciple_amount" class="form-control" placeholder="Principal Amount">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="rel_date" class="col-sm-2 col-form-label">Release Date</label>
                            <div class="col-sm-10">
                                <input class="form-control" required type="date" id="Urel_date" name="Urel_date"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cycle" class="col-sm-2 col-form-label">Cycle</label>
                            <div class="col-sm-10">
                                <input disabled type="number" class="form-control" id="Ucycle" name="Ucycle" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdCloseEdit">Cancel</button>
                        <button type="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                </form>
            </div>
    </div>

    <script>
        function newLoan(){
                $('#mdCloseEdit').click();
                var form = {
                    _token: $('input[name=_token]').val(),
                    id: $('#Uid').val(),
                    principle_amount: $('#Uprinciple_amount').val(),
                    rel_date: $('#Urel_date').val(),
                    cycle: $('#Ucycle').val(),
                    ajax: 1
                }
                $.ajax({
                    url : "{{url('loans/updater')}}",
                    data :  form,
                    type : "POST",
                    success : function(msg){
                         $('#mdClose').click();
                        console.log(msg['message']);
                        if(msg['success']){
                            success(msg['message']);
                            //setTimeout(function(){window.location.reload();},1500);
                        }else{
                            warning(msg['message']);
                        }
                    }
                })
                return false;
        }
    </script>