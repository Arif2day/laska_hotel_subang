    {{-- Modal Tambah MenuType --}}
    <div class="modal fade" id="addMenuTypeModal" tabindex="-1" role="dialog" aria-labelledby="addMenuTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuTypeModalLabel">Add Menu Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormMenuType()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddMenuType">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Type:</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/menu-type')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormMenuType()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="saveMenuType()">Save</button>
                </div>
            </div>
        </div>
    </div>