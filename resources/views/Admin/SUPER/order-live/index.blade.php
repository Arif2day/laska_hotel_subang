@extends('Admin.main')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Live Order</h1>
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
                <div class="col-xl-4 mb-2">
                    <label class="small mb-1">Jenis Table</label>
                    <select id="table_class" class="form-select" aria-label="role">
                        <option value="all" selected>Semua</option>
                        @foreach ($table_classes as $table_class)                            
                            <option value="{{ $table_class->id }}">{{ $table_class->class_name }}</option>
                        @endforeach
                    </select>
                </div>
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
                <div class="col-xl-4 mt-xl-3" style="align-self: center;">
                    <button class="btn btn-sm btn-primary" onclick="execFil()">
                        <i class="fa fa-search"></i> Tampilkan Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Detail Profil --}}
        <div class="col-xl-12 col-md-12 col-lg-12 mb-1">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Live Order</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row float-right mr-0 mb-2">
                        {{-- <button class="btn btn-sm btn-primary mr-2" disabled>
                            <i class="fas fa-fw fa-print"></i> Cetak Laporan</button> --}}
                        {{-- <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addUserModal">
                            <i class="fas fa-fw fa-plus-circle"></i> Add Users</button> --}}
                    </div>
                    <div class="text-xs">
                        <table class="table live-order-datatable display" style="width:100%;">
                            <thead class="text-center">
                                <th>NO</th>
                                <th>RESERVATOR</th>
                                <th>TABLE</th>
                                <th>TOTAL ITEM</th>
                                <th>TOTAL TAGIHAN</th>
                                <th>PAYMENT</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <input type="hidden" id="urllist" name="urllist" value="{{url('order/live/list')}}">
                        <input type="hidden" id="urldel" name="urldel" value="{{url('order/live')}}">                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Admin.SUPER.order-live.modal.detail-tagihan-bayar')
</div>
@endsection
@section('script')
<script>
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

    var table = $('.live-order-datatable').DataTable({   
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
                d.table_class = $('#table_class option:selected').val()
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
            {data: 'reservator_name', name: 'reservator_name'},
            {data: 'table.table_name', name: 'table.table_name'},
            {data: 'total_item', name: 'total_item'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'payment_status', name: 'payment_status'},
            {data: 'status', name: 'status'},
            {data: 'action', name:'action'},               
        ]       
    });

    function execFil() {    
        table.ajax.reload();
    }

    setInterval(function(){
        execFil();
    }, 10000); 

    function thousand(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).ready(function(){
        // Modal Detail
        $(document).on("click", ".btn-detail", function(){
                let id = $(this).data('id');
                $.get("{{ url('order/live') }}/"+id+"/detail", function(data){
                    let html = `<p><strong>Reservator:</strong> ${data.reservator_name}</p>
                                <p><strong>Meja:</strong> ${data.table.table_name}</p>
                                <table class="table"><tr><th>Menu</th><th>Qty</th><th>Harga</th><th>Sub</th><th>Note</th></tr>`;
                    data.details.forEach(d => {
                        html += `<tr><td>${d.menu.menu_name}</td><td>${d.quantity}</td><td>Rp.${thousand(d.price)}</td><td>Rp.${thousand(d.price*d.quantity)}</td><td>${d.note}</td></tr>`;
                    });
                    html += `</table>`;
                    $("#detailContent").html(html);
                    let htm = 'Rp.'+thousand(data.total_amount);
                    $("#footerDetailContent").html(htm);
                    $("#detailModal").modal('show');
                });
            });

            // Modal Invoice
            $(document).on("click", ".btn-invoice", function(){
                let id = $(this).data('id');
                $.get("{{ url('order/live') }}/"+id+"/invoice", function(data){
                    let total = data.total_amount;
                    let html = `<h5>Tagihan untuk ${data.reservator_name}</h5>
                                <p>Meja: ${data.table.table_name}</p>
                                <ul>`;
                    data.details.forEach(d => {
                        html += `<li>${d.menu.menu_name} x ${d.quantity} = ${d.quantity * d.price}</li>`;
                    });
                    html += `</ul><h4>Total: ${total}</h4>`;
                    $("#invoiceContent").html(html);
                    $("#invoiceModal").modal('show');
                });
            });

            // Modal Bayar
            $(document).on("click", ".btn-pay", function(){
                let id = $(this).data('id');
                $("#pay_order_id").val(id);
                $("#payModal").modal('show');
            });
            
            // Modal Cancel
            $(document).on("click", ".btn-cancel", function(){
                let id = $(this).data('id');
                $("#cancel_order_id").val(id);
                $("#cancelModal").modal('show');
            });

            // Modal ready to serve
            $(document).on("click", ".btn-ready-to-serve", function(){
                let id = $(this).data('id');
                $("#ready_order_id").val(id);
                $("#readyModal").modal('show');
            });

            // Modal mark as done
            $(document).on("click", ".btn-done", function(){
                let id = $(this).data('id');
                $("#done_order_id").val(id);
                $("#doneModal").modal('show');
            });

            // Submit bayar
            $("#payForm").submit(function(e){
                e.preventDefault();
                let id = $("#pay_order_id").val();
                $.post("{{ route('kasir.payment', '') }}/"+id, $(this).serialize(), function(res){
                    Swal.fire({icon: 'success', title: 'Success',text: res.message});
                    $("#payModal").modal('hide');
                    table.ajax.reload();
                });
            });

            // Submit cancel
            $("#cancelForm").submit(function(e){
                e.preventDefault();
                let id = $("#cancel_order_id").val();
                $.post("{{ route('kasir.cancel', '') }}/"+id, $(this).serialize(), function(res){
                    Swal.fire({icon: 'success', title: 'Success',text: res.message});
                    $("#cancelModal").modal('hide');
                    table.ajax.reload();
                });
            });

            // Submit ready
            $("#readyForm").submit(function(e){
                e.preventDefault();
                let id = $("#ready_order_id").val();
                $.post("{{ route('kasir.ready', '') }}/"+id, $(this).serialize(), function(res){
                    Swal.fire({icon: 'success', title: 'Success',text: res.message});
                    $("#readyModal").modal('hide');
                    table.ajax.reload();
                });
            });

            // Submit done
            $("#doneForm").submit(function(e){
                e.preventDefault();
                let id = $("#done_order_id").val();
                $.post("{{ route('kasir.done', '') }}/"+id, $(this).serialize(), function(res){
                    Swal.fire({icon: 'success', title: 'Success',text: res.message});
                    $("#doneModal").modal('hide');
                    table.ajax.reload();
                });
            });
    });
</script>
@endsection