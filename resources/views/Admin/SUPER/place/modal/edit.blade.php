    {{-- Modal Ubah Place --}}
    <div class="modal fade" id="editPlaceModal" tabindex="-1" role="dialog" aria-labelledby="editPlaceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlaceModalLabel">Edit Place</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearEditFormPlace()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddPlace">
                        <div class="form-group">
                            <label for="e_place_category" class="col-form-label">Place Category:</label>
                            <select class="form-control" id="e_place_category">
                                <option value="-1" selected>--Pilih Place Category--</option>
                                @foreach ($place_categories as $place_category)                            
                                    <option value="{{ $place_category->id }}">{{ $place_category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_name" class="col-form-label">Place Name:</label>
                            <input type="text" class="form-control" id="e_name" value="">
                        </div>
                        <input type="hidden" name="e_id" id="e_id">
                        <input type="hidden" id="linked2" name="linked2" value="{{url('master/place/update')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearEditFormPlace()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="updatePlace()">Update</button>
                </div>
            </div>
        </div>
    </div>