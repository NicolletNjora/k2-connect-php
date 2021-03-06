<?php
    include 'layout.php';
?>
<div class="container">
    <h3> Add Pay Recipient</h3>
    <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#home">Bank Account</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#wallet">Mobile Wallet</a></li>
    </ul>
    <br/>

    <div class="tab-content">
        <div id="home" class="tab-pane active">
            <h3>Bank Account</h3>    
            <form id="bulkSmsForm"(action="/pay/recipients", method="post")>
                <input class="form-control" name="type"  type='hidden' value='bank_account' required/>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="firstName")> First Name </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="firstName"  type='text' placeholder='Enter First Name' required/>
                        <div class="small form-text text-muted">
                            Enter First Name
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="lastName")> Last Name </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="lastName"  type='text' placeholder='Enter Last Name' required/>
                        <div class="small form-text text-muted">
                            Enter Last Name
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="email")> Email </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="email"  type='text' placeholder='Enter Email Address'/>
                        <div class="small form-text text-muted">
                            Enter Email Address
                        </div>
                    </div>
                </div>        
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="phone")> Phone Number </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="phone"  type='text' placeholder='Enter Phone Number'/>
                        <div class="small form-text text-muted">
                            Enter Phone Number
                        </div>
                    </div>
                </div>
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
            <h3>Mobile Wallet</h3>
            <form id="bulkSmsForm"(action="/pay/recipients", method="post")>
                <input class="form-control" name="type"  type='hidden' value='mobile_wallet' required/>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="firstName")> First Name </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="firstName"  type='text' placeholder='Enter First Name' required/>
                        <div class="small form-text text-muted">
                            Enter First Name
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="lastName")> Last Name </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="lastName"  type='text' placeholder='Enter Last Name' required/>
                        <div class="small form-text text-muted">
                            Enter Last Name
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" (for="email")> Email </label>
                    <div class="col-sm-7">
                        <input class="form-control" name="email"  type='text' placeholder='Enter Email Address' required/>
                        <div class="small form-text text-muted">
                            Enter Email Address
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
                        <button class="btn btn-success"(type='submit')> Add Pay Recipient
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>