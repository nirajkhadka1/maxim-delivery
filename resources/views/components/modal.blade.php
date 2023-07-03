<div class="modal" id="myModal"tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Enable/Disable Date</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modificationForm">
                    <input type="text" class="edit_id" name="id" value="" hidden/>
                    <input type="text" class="status" name="status" value="" hidden/>
                    <input type="text" class="dates" name="dates" value="" hidden/>
                    <input type="text" class="is_delete" value="" hidden/>

                    <div class="form-group mt-2">
                        <label for="exampleFormControlTextarea1">Remarks <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="remarks" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary changeStatusBtn">Edit</button>
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
