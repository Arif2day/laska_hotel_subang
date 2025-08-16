    {{-- Modal Ubah Menu --}}
    <div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearEditFormMenu()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formeditMenu">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="e_menu_type" class="col-form-label">Menu Type:</label>
                                    <select class="form-control" id="e_menu_type">
                                        <option value="-1" selected>--Pilih Menu Type--</option>
                                        @foreach ($menu_types as $menu_type)                            
                                            <option value="{{ $menu_type->id }}">{{ $menu_type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="e_name" class="col-form-label">Menu Name:</label>
                                    <input type="text" class="form-control" id="e_name" value="">
                                </div>
                                <div class="form-group">
                                    <label for="e_description" class="col-form-label">Menu Description:</label>
                                    <textarea name="e_description" class="form-control" id="e_description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="e_ingredient" class="col-form-label">Menu Ingredient:</label>
                                    <textarea name="e_ingredient" class="form-control" id="e_ingredient" cols="30" rows="3"></textarea>
        
                                </div>
                                <div class="form-group">
                                    <label for="e_price" class="col-form-label">Menu Price:</label>
                                    <input type="number" class="form-control" id="e_price" value="">
                                </div>
                                <div class="form-group">
                                    <label for="e_status" class="col-form-label">Status:</label>
                                    <select class="form-control" id="e_status">
                                        <option value="-1" selected>--Pilih Status--</option>
                                        <option value="1">Tersedia</option>
                                        <option value="0">Tidak Tersedia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="e_picture" class="col-form-label">Picture:</label>
                                    <input type="file" class="form-control" id="e_picture" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img id="e-preview-picture" src="{{ asset('img/empty.jpg') }}" alt="" width="50%" accept="image/*">
                            </div>
                        </div>
                        <input type="hidden" name="e_id" id="e_id">
                        <input type="hidden" id="linked2" name="linked2" value="{{url('master/menu/update')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearEditFormMenu()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="updateMenu()">Update</button>
                </div>
            </div>
        </div>
    </div>