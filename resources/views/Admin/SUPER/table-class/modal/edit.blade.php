    {{-- Modal Ubah TableClass --}}
    <div class="modal fade" id="editTableClassModal" tabindex="-1" role="dialog" aria-labelledby="editTableClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTableClassModalLabel">Edit Table Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearEditFormTableClass()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddTableClass">
                        <div class="form-group">
                            <label for="e_name" class="col-form-label">Table Class Name:</label>
                            <input type="text" class="form-control" id="e_name" value="">
                        </div>
                        <input type="hidden" name="e_id" id="e_id">
                        <input type="hidden" id="linked2" name="linked2" value="{{url('master/table-class/update')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearEditFormTableClass()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="updateTableClass()">Update</button>
                </div>
            </div>
        </div>
    </div>