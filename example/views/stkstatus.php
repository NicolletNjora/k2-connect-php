<?php
    include 'layout.php';
?>
<div class="container">
    <form id="bulkSmsForm"(action="/stkstatus", method="post")>    
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" (for="location")> Resource Location </label>
            <div class="col-sm-7">
                <input class="form-control" name="location"  type='text' placeholder='Enter Resource Location' required/>
                <div class="small form-text text-muted">
                    Enter the  Resource Location
                </div>
            </div>
        </div>
        <br/>
        <div class="form-group.row">
            <div class="col-sm-7">
                <button class="btn btn-success"(type='submit')> Get STK Status
            </div>
        </div>
    </form>
</div>