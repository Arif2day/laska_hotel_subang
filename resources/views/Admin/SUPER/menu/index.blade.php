@extends('Admin.main')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Menu</h1>
    </div>

    {{-- Filter --}}
    <div class="card border-bottom-primary shadow h-100 py-2 mb-4">
        <div class="d-flex justify-content-between mx-3 align-items-center" id="accordion">
            <div class="">
                Filter
            </div>
            <div class="">
                <a class="font-weight-bold btn btn-link btn-sm" id="toogFil" data-toggle="collapse"
                    data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                    -
                </a>
            </div>
        </div>
        <div id="collapseFilter" class="collapse show" aria-labelledby="headingFilter" data-parent="#accordion">
            <div class="row m-2">
                {{-- <div class="col-xl-4 mb-2">
                    <label class="small mb-1">Jenis Role</label>
                    <select id="role" class="form-select" aria-label="role">
                        <option value="all" selected>Semua</option>
                        @foreach ($roles as $role)                            
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- <div class="col-xl-4 mb-2">
                    <label class="small mb-1">Status</label> --}}
                    {{-- <select id="status_mhs" class="form-select" aria-label="Status">
                        <option value="all" selected>Semua</option>
                        @foreach($status_mhs as $index => $v)
                        <option value="{{$v}}" {{$v=="AKTIF" ?"Selected":""}}>{{ucfirst(strtolower($v))}}</option>
                        @endforeach
                    </select> --}}
                    {{--
                </div> --}}
                {{-- <div class="col-xl-4 mt-xl-3" style="align-self: center;">
                    <button class="btn btn-sm btn-primary" onclick="execFil()">
                        <i class="fa fa-search"></i> Tampilkan Data</button>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Detail Profil --}}
        <div class="col-xl-12 col-md-12 col-lg-12 mb-1">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Menu</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row float-right mr-0 mb-2">
                        {{-- <button class="btn btn-sm btn-primary mr-2" disabled>
                            <i class="fas fa-fw fa-print"></i> Cetak Laporan</button> --}}
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addMenuModal">
                            <i class="fas fa-fw fa-plus-circle"></i> Add Menu</button>
                    </div>
                    <div class="text-xs">
                        <table class="table menu-datatable display" style="width:100%;">
                            <thead class="text-center">
                                <th style="width: 20px">NO</th>
                                <th>TYPE</th>
                                <th>NAME</th>
                                <th>STATUS</th>
                                <th>PRICE</th>
                                <th>THUMBNAIL</th>
                                <th style="width: 100px">ACTION</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <input type="hidden" id="urllist" name="urllist" value="{{url('master/menu/list')}}">
                        <input type="hidden" id="urldel" name="urldel" value="{{url('master/menu')}}">                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Admin.SUPER.menu.modal.add')
    @include('Admin.SUPER.menu.modal.edit')

</div>
@endsection
@section('script')
<script>
    const pictureInput = document.getElementById('picture');
    const ePictureInput = document.getElementById('e_picture');
    const previewImage = document.getElementById('preview-picture');
    const ePreviewImage = document.getElementById('e-preview-picture');
    const defaultImage = "{{ asset('img/empty.jpg') }}";
    
    // Filter Sort Function
    $('#toogFil').click(function(){ //you can give id or class name here for $('button')
        $(this).text(function(i,old){
            return old=='+' ?  '-' : '+';
        });
    });
    
    // Data Sort Function
    $(document).ajaxComplete(function(){
        if($('#DataTables_Table_0_length').length != 0) {
            $('#DataTables_Table_0_length').css('margin-right', '17px');
        }
    });

    var table = $('.menu-datatable').DataTable({   
        pageLength : 25,
        dom: 'lfrtip',        
        processing: true,
        serverSide: true,
        ordering: true,    
        "scrollX":true,
        rowId:  'id',
        ajax: {
            url:$('#urllist').val(),
            type:"POST",
            data:function(d){
                d._token = $('._token').data('token')
                d.role = $('#role option:selected').val()
            }}, 
        createdRow: function(row, data, dataIndex, cells) {
            // console.log( data.FeederAKM );
            $(row).addClass('transparentClass') 
            $(cells[0]).addClass('text-center text-sm')
            $(cells[1]).addClass('text-sm')                 
            $(cells[2]).addClass('text-center text-sm')                   
            $(cells[3]).addClass('text-center text-sm')                   
            $(cells[4]).addClass('text-center text-sm')                   
            $(cells[5]).addClass('text-center text-sm')                   
            $(cells[6]).addClass('text-center text-sm')                   
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'menu_type.type', name: 'menu_type.type'},
            {data: 'menu_name', name: 'menu_name'},
            {data: 'status', name: 'status'},
            {data: 'price', name: 'price'},
            {data: 'thumbnail', name: 'thumbnail'},
            {data: 'action', name:'action'},               
        ]       
    });

    function execFil() {    
        table.ajax.reload();
    }

    function deleteMenu(params) {
        Swal.fire({
            title: 'Yakin?',
            text: "Anda akan menghapus Data Menu.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus sekarang!'
            }).then((result) => {
            if (result.isConfirmed) {
                let datar = {};
                datar['_method']='DELETE';
                datar['_token']=$('._token').data('token');
                datar['id']=params;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'delete',
                    url: $("#urldel").val(),
                    data:datar,
                    success: function(data) {
                        if (data.error==false) {
                            table.ajax.reload();
                            Swal.fire({icon: 'success', title: 'Deleted!',text: data.message});
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            });
                        }
                    },
                });                
            }
        });
    }   

    // Form Sort Function
    function clearFormMenu() {
        previewImage.src = defaultImage;
        document.getElementById('formaddMenu').reset();
    } 

    function clearEditFormMenu() {
        ePreviewImage.src = defaultImage;
        document.getElementById('formeditMenu').reset();
    } 

    function saveMenu() {
        validateAddMenuForm("save").then(rdata => {
            if (!rdata) return;
            
            $('.containerr').show();
            let datar = {};
            datar['_method']='POST';
            datar['_token']=$('._token').data('token');
            datar['menu_type_id']=rdata.menu_type;
            datar['description']=rdata.description;
            datar['ingredients']=rdata.ingredient;
            datar['menu_name']=rdata.name;
            datar['picture']=rdata.picture_base64;
            datar['price']=rdata.price;
            datar['status']=rdata.status;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: $("#linked1").val(),
                data:datar,
            success: function(data) {
                if (data.error==false) {
                    table.ajax.reload();
                    clearFormMenu();
                    $('#addMenuModal').modal('hide');
                    $('.containerr').hide();
                    Swal.fire({icon: 'success', title: 'Horray...',text: data.message});
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    });
                    $('.containerr').hide();
                }
            },
            });   
        }).catch(err => {
            Swal.fire({icon: 'error', title: 'Oops...', text: err});
            $('.containerr').hide();
        });             
    } 

    function updateMenu() {
        validateAddMenuForm("update").then(rdata => {
            if (!rdata) return;
            let id = $('input[id=e_id').val();

            $('.containerr').show();
            let datar = {};
            datar['_method']='POST';
            datar['_token']=$('._token').data('token');
            datar['id']=id;
            datar['menu_type_id']=rdata.menu_type;
            datar['description']=rdata.description;
            datar['ingredients']=rdata.ingredient;
            datar['menu_name']=rdata.name;
            datar['picture']=rdata.picture_base64;
            datar['price']=rdata.price;
            datar['status']=rdata.status;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            type: 'post',
            url: $("#linked2").val(),
            data:datar,
            success: function(data) {
                if (data.error==false) {
                    table.ajax.reload();
                    clearEditFormMenu();
                    $('#editMenuModal').modal('hide');
                    $('.containerr').hide();
                    Swal.fire({icon: 'success', title: 'Horray...',text: data.message});
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    });
                    $('.containerr').hide();
                }
            },
            });            
        }).catch(err => {
            Swal.fire({icon: 'error', title: 'Oops...', text: err});
            $('.containerr').hide();
        });      
    } 

    $(document).on('click', '.editMenuBtn', function () {
        // Ambil data dari atribut tombol
        var id = $(this).data('id');
        var menu_type_id = $(this).data('menu_type_id');
        var menu_name = $(this).data('menu_name');
        var description = $(this).data('description');
        var ingredient = $(this).data('ingredients');
        var status = $(this).data('status');
        var price = $(this).data('price');
        var picture_path = $(this).data('picture_path');

        // Set data ke form dalam modal
        $('#editMenuModal input[id="e_id"]').val(id);
        $('#editMenuModal input[id="e_name"]').val(menu_name);
        $('#editMenuModal input[id="e_price"]').val(parseInt(price));
        
        $('#editMenuModal textarea#e_description').val(description);
        $('#editMenuModal textarea#e_ingredient').val(ingredient);
        $('#editMenuModal select[id="e_menu_type"]').val(menu_type_id);   
        $('#editMenuModal select[id="e_status"]').val(status);  
        $('#e-preview-picture').attr('src', picture_path);
    });
</script>
<script>
function validateAddMenuForm($mode) {
    const menuType = document.getElementById($mode=="save"?'menu_type':'e_menu_type').value;
    const name = document.getElementById($mode=="save"?'name':'e_name').value.trim();
    const price = document.getElementById($mode=="save"?'price':'e_price').value.trim();
    const status = document.getElementById($mode=="save"?'status':'e_status').value;
    const picture = document.getElementById($mode=="save"?'picture':'e_picture').files[0];
    const description = document.getElementById($mode=="save"?'description':'e_description').value.trim();
    const ingredient = document.getElementById($mode=="save"?'ingredient':'e_ingredient').value.trim();

    // Cek menu type
    if (menuType == -1) {
        Swal.fire({icon: 'error',title: 'Oops...',
            text: "Silakan pilih Menu Type.",});
        return false;
    }

    // Cek nama menu
    if (name === "") {
        Swal.fire({icon: 'error',title: 'Oops...',
            text: "Menu Name tidak boleh kosong.",});
        return false;
    }

    // Cek harga
    if (price === "" || isNaN(price) || parseFloat(price) <= 0) {        
        Swal.fire({icon: 'error',title: 'Oops...',
            text: "Menu Price harus diisi dengan angka lebih dari 0.",});
        return false;
    }

    // Cek status
    if (status == -1) {
        Swal.fire({icon: 'error',title: 'Oops...',
            text: "Silakan pilih Status.",});
        return false;
    }

    if($mode=="save")
    {
        // Cek gambar
        if (!picture) {
            Swal.fire({icon: 'error',title: 'Oops...',
                text: "Silakan pilih gambar menu.",});
            return false;
        }
    }
    
    if(picture){
        if (!picture.type.startsWith("image/")) {
            Swal.fire({icon: 'error',title: 'Oops...',
                text: "File yang dipilih harus berupa gambar.",});
            return false;
        }
    
        // Maksimal 2MB
        const maxSize = 3 * 1024 * 1024;
        if (picture.size > maxSize) {
            Swal.fire({icon: 'error',title: 'Oops...',
                text: "Ukuran gambar maksimal 2MB.",});
            return false;
        }
    }

    return new Promise((resolve, reject) => {
        // Jika tidak ada file, langsung return tanpa FileReader
        if (!picture) {
            resolve({
                menu_type: menuType,
                name: name,
                description: description,
                ingredient: ingredient,
                price: parseFloat(price),
                status: status,
                picture: null,         // null artinya tidak update gambar
                picture_base64: null   // null juga
            });
            return;
        }

        // Jika ada file → baru proses pakai FileReader
        const reader = new FileReader();
        reader.onload = function (e) {
            resolve({
                menu_type: menuType,
                name: name,
                description: description,
                ingredient: ingredient,
                price: parseFloat(price),
                status: status,
                picture: picture,            // file asli
                picture_base64: e.target.result // base64 string
            });
        };
        reader.onerror = function () {
            reject("Gagal membaca file sebagai Base64");
        };   
        reader.readAsDataURL(picture);
    });

}

pictureInput.addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
        // Validasi tipe file
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hanya file gambar yang diperbolehkan.',
                            });
            pictureInput.value = '';
            previewImage.src = defaultImage;
            return;
        }

        // Preview gambar
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        previewImage.src = defaultImage;
    }
});

ePictureInput.addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
        // Validasi tipe file
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hanya file gambar yang diperbolehkan.',
                            });
            ePictureInput.value = '';
            ePreviewImage.src = defaultImage;
            return;
        }

        // Preview gambar
        const reader = new FileReader();
        reader.onload = function (e) {
            ePreviewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        ePreviewImage.src = defaultImage;
    }
});
</script>
@endsection