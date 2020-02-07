<?php
    include 'layout.php';
?>
<div class="container">
    <h3> Add Settlement Account</h3>
    <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#home">Bank Account</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#wallet">Mobile Wallet</a></li>
    </ul>
    <br/>

    <div class="tab-content">
        <div id="home" class="tab-pane active">
            <h3>Bank Account</h3>    
            <form id="bulkSmsForm"(action="/transfer/accounts", method="post")>
                <input class="form-control" name="type"  type='hidden' value='bank' required/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="accountName")> Account Name </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="accountName"  type='text' placeholder='Enter Account Name' required/>
                        <div class="small form-text text-muted">
                            Enter Account Name
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="bankId")> Bank ID </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="bankId"  type='text' placeholder='Enter Bank ID' required/>
                        <div class="small form-text text-muted">
                            Enter Bank ID
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="branchId")> Bank Branch ID </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="branchId"  type='text' placeholder='Enter Bank Branch ID' required/>
                        <div class="small form-text text-muted">
                            Enter Bank Branch ID
                        </div>
                    </div>
                </div>        
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="accountNumber")> Account Number </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="accountNumber"  type='text' placeholder='Enter Account Number' required/>
                        <div class="small form-text text-muted">
                            Enter Account Number
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group.row">
                    <div class="col-sm-7">
                        <button class="btn btn-success"(type='submit')> Add Settlement Account
                    </div>
                </div>
            </form>
        </div>
        <div id="wallet" class="tab-pane fade">
            <h3>Mobile Wallet Account </h3>
            <form id="bulkSmsForm"(action="/transfer/accounts", method="post")>
                <input class="form-control" name="type"  type='hidden' value='mobile' required/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="network")> Network </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="network"  type='text' placeholder='Enter Network' required/>
                        <div class="small form-text text-muted">
                            Enter Network
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="phone")> Phone Number </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="phone"  type='text' placeholder='Enter Phone Number' required/>
                        <div class="small form-text text-muted">
                            Enter Phone Number
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group.row">
                    <div class="col-sm-7">
                        <button class="btn btn-success"(type='submit')> Add Settlement Account
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>