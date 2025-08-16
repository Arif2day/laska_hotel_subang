    {{-- Modal Ubah Table --}}
    <div class="modal fade" id="editTableModal" tabindex="-1" role="dialog" aria-labelledby="editTableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTableModalLabel">Edit Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearEditFormTable()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddTable">
                        <div class="form-group">
                            <label for="e_table_class" class="col-form-label">Table Class:</label>
                            <select class="form-control" id="e_table_class">
                                <option value="-1" selected>--Pilih Table Class--</option>
                                @foreach ($table_classes as $table_class)                            
                                    <option value="{{ $table_class->id }}">{{ $table_class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_name" class="col-form-label">Table Name:</label>
                            <input type="text" class="form-control" id="e_name" value="">
                        </div>
                        <input type="hidden" name="e_id" id="e_id">
                        <input type="hidden" id="linked2" name="linked2" value="{{url('master/table/update')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearEditFormTable()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="updateTable()">Update</button>
                </div>
            </div>
        </div>
    </div>