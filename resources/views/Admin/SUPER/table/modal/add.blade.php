    {{-- Modal Tambah Table --}}
    <div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-labelledby="addTableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTableModalLabel">Add Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormTable()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddTable">
                        <div class="form-group">
                            <label for="table_class" class="col-form-label">Table Class:</label>
                            <select class="form-control" id="table_class">
                                <option value="-1" selected>--Pilih Table Class--</option>
                                @foreach ($table_classes as $table_class)                            
                                    <option value="{{ $table_class->id }}">{{ $table_class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Table Name:</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/table')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormTable()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="saveTable()">Save</button>
                </div>
            </div>
        </div>
    </div>