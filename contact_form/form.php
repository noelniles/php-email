<form id="myForm" class="form form-horizontal" method="POST">

    <fieldset>

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <legend>Got an idea for a tattoo? Email me!</legend>
            <div id="formResponse"></div>
        </div>
        <div class="modal-body">

            <div class="control-group">
                <label class="control-label" for="name">Your name: </label>
                <input name="name" type="text" placeholder="John Doe">
            </div>

            <div class="control-group">
                <label class="control-label" for="email">Your email: </label>  
                <input name="email" type="text" placeholder="johndoe@email.com">
            </div>

            <div class="control-group">
                <label class="control-label" for="message">Message: </label>
                <textarea cols="21" rows="6" name="message" placeholder="Write a brief message about your inquiry."></textarea>
            </div>

        </div>

        <div class="modal-footer">
            <div class="btn-group pull-right">
                <button href="#" class="btn" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="submitForm" type="submit" value="Submit Form"><i class="icon-envelope"></i> 
            Send!
        </button>
            </div>
        </div>

    </fieldset>
</form>
