    {{-- Modal Ubah PlaceCategory --}}
    <div class="modal fade" id="editPlaceCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editPlaceCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlaceCategoryModalLabel">Edit Place Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearEditFormPlaceCategory()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddPlaceCategory">
                        <div class="form-group">
                            <label for="e_name" class="col-form-label">Place Category Name:</label>
                            <input type="text" class="form-control" id="e_name" value="">
                        </div>
                        <input type="hidden" name="e_id" id="e_id">
                        <input type="hidden" id="linked2" name="linked2" value="{{url('master/place-category/update')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearEditFormPlaceCategory()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="updatePlaceCategory()">Update</button>
                </div>
            </div>
        </div>
    </div>