    {{-- Modal Tambah PlaceCategory --}}
    <div class="modal fade" id="addPlaceCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addPlaceCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlaceCategoryModalLabel">Add Place Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormPlaceCategory()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddPlaceCategory">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Place Category Name:</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/place-category')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormPlaceCategory()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="savePlaceCategory()">Save</button>
                </div>
            </div>
        </div>
    </div>