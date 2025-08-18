<!-- Modal: Detail Order -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Order</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="detailContent">
          Loading...
        </div>
        <div class="modal-footer">
            <div class="container">
                <div class="row">
                <div class="col-8 font-weight-bold">Grand Total</div>
                <div class="col-4 font-weight-bold text-right" id="footerDetailContent">...</div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal: Invoice -->
  <div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tagihan</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="invoiceContent">
          Loading...
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal: Bayar -->
  <div class="modal fade" id="payModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin memproses pembayaran order ini?</p>
          <form id="payForm">
            @csrf
            <input type="hidden" name="order_id" id="pay_order_id">
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Cancel -->
  <div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pembatalan Order</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin memproses pembatalan order ini?</p>
          <form id="cancelForm">
            @csrf
            <input type="hidden" name="order_id" id="cancel_order_id">
            <button type="submit" class="btn btn-danger">Batalkan</button>
          </form>
        </div>
      </div>
    </div>
  </div>