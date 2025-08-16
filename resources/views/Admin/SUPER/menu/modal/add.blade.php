    {{-- Modal Tambah Menu --}}
    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Add Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormMenu()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formaddMenu">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_type" class="col-form-label">Menu Type:</label>
                                    <select class="form-control" id="menu_type">
                                        <option value="-1" selected>--Pilih Menu Type--</option>
                                        @foreach ($menu_types as $menu_type)                            
                                            <option value="{{ $menu_type->id }}">{{ $menu_type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Menu Name:</label>
                                    <input type="text" class="form-control" id="name" value="">
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Menu Description:</label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ingredient" class="col-form-label">Menu Ingredient:</label>
                                    <textarea name="ingredient" class="form-control" id="ingredient" cols="30" rows="3"></textarea>
        
                                </div>
                                <div class="form-group">
                                    <label for="price" class="col-form-label">Menu Price:</label>
                                    <input type="number" class="form-control" id="price" value="">
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-form-label">Status:</label>
                                    <select class="form-control" id="status">
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
                                    <label for="picture" class="col-form-label">Picture:</label>
                                    <input type="file" class="form-control" id="picture" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img id="preview-picture" src="{{ asset('img/empty.jpg') }}" alt="" width="50%" accept="image/*">
                            </div>
                        </div>
                        

                        <input type="hidden" id="linked1" name="linked1" value="{{url('master/menu')}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="clearFormMenu()">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="saveMenu()">Save</button>
                </div>
            </div>
        </div>
    </div>