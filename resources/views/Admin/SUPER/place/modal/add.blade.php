    {{-- Modal Tambah Place --}}
    <div class="modal fade" id="addPlaceModal" tabindex="-1" role="dialog" aria-labelledby="addPlaceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlaceModalLabel">Add Place</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormPlace()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddPlace">
                        <div class="form-group">
                            <label for="place_category" class="col-form-label">Place Category:</label>
                            <select class="form-control" id="place_category">
                                <option value="-1" selected>--Pilih Place Category--</option>
                                @foreach ($place_categories as $place_category)                            
                                    <option value="{{ $place_category->id }}">{{ $place_category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Place Name:</label>
                            <input type="text" class="form-control" id="name" value="">
                        </div>

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/place')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormPlace()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="savePlace()">Save</button>
                </div>
            </div>
        </div>
    </div>