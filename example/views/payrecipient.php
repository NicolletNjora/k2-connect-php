<?php
    include 'layout.php';
?>
<div class="container">
    <h3> Add Pay Recipient</h3>
    <form id="bulkSmsForm"(action="/pay/recipients", method="post")>
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