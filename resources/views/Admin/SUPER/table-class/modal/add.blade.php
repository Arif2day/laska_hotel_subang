    {{-- Modal Tambah TableClass --}}
    <div class="modal fade" id="addTableClassModal" tabindex="-1" role="dialog" aria-labelledby="addTableClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTableClassModalLabel">Add Table Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormTableClass()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddTableClass">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Table Class Name:</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/table-class')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormTableClass()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="saveTableClass()">Save</button>
                </div>
            </div>
        </div>
    </div>