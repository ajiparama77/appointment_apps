@extends('layouts_global.master')
@section('title') @lang('translation.datatables') @endsection
@section('css')
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
#example td {
    vertical-align: top !important;
}
</style>
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Global @endslot
@slot('title')Notification History @endslot
@endcomponent

<!--<div class="alert alert-danger" role="alert">
    This is <strong>Datatable</strong> page in wihch we have used <b>jQuery</b> with cnd link!
</div> -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col-md-6">
				<h5 class="card-title mb-0">List Notification History</h5>
				</div> 
				<div class="col-md-6" align="right">
				
				</div>
				</div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            
                            <th><center>No</center></th>
                            <th><center>App</center></th>
                            <th><center>Time</center></th>
                            <th><center>Send To</center></th>
                            <th><center>Status</center></th>
                            <th><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php $no=1; foreach($list_notif as $list){ ?>
						

                        <tr>
                            
                            <td><center><?php echo $no++; ?></center></td>
                            <td><?php echo $list->app; ?></td>
                            <td><?php echo $list->created_at; ?></td>
                            <td><?php echo $list->send_to; ?></td>
                            <td><center><?php 
							if($list->status == "success"){ echo '<span class="badge bg-success-subtle text-success">Success</span>'; }
							else if($list->status == "failed"){ echo '<span class="badge bg-danger-subtle text-danger">Failed</span>'; }
							else if($list->status == "exception"){ echo '<span class="badge bg-warning-subtle text-warning">Exception</span>'; }
							else{ echo ''; }
							
							?></center></td>
                            
                            <td>
                                <center>
								<a href="javascript:void(0);" class="btn btn-sm btn-info" onclick="AlertDetail({{ $list->id }},'{{ $list->app }}','{{ $list->created_at }}','{{ $list->send_to }}','{{ $list->status }}','{{ $list->message }}')">
											<i class="ri-information-line"></i>
										</a>	
								</center>
                            </td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->


<!-- First modal dialog -->
<div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <lord-icon
                    src="https://cdn.lordicon.com/tdrtiskw.json"
                    trigger="loop"
                    colors="primary:#f7b84b,secondary:#405189"
                    style="width:130px;height:130px">
                </lord-icon>
                <div class="mt-4 pt-4">
                    <h4>Delete Data</h4>
                    <p class="text-muted"> Are you sure want delete this data ?</p>
                    <!-- Toogle to second dialog -->
					<br>
					<div align="right" id="alche">
                     
					 </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <div class="modal fade" id="varyingcontentdetail" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      
      <div class="modal-header bg-light" style="padding-bottom: 20px!important;">
        <h5 class="modal-title" id="varyingcontentModalLabel">
          <i class="ri-notification-3-line me-2 text-primary"></i> Notification Detail
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		<br>
      </div>
      
      <form class="form-horizontal" action="#">
        @csrf
        <div class="modal-body px-4">
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label text-muted">App Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-light border-0" id="nama2" disabled>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label text-muted">Send To</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-light border-0" id="tgl2" disabled>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label text-muted">Status</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-light border-0" id="tgl22" disabled>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label text-muted">Message</label>
            <div class="col-sm-9">
              <textarea class="form-control bg-light border-0" id="template2" rows="4" disabled></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="ri-close-line me-1"></i> Close
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!--end row-->

@endsection
@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus template ini?")) {
        window.location.href = "{{ url('users_delete') }}?id=" + id;
    }
} 

function AlertDLT(id) {
	var myModal = new bootstrap.Modal(document.getElementById('firstmodal'));
	myModal.show();	
	xhref = "{{ url('users_delete') }}?id=" + id;
	$("#alche").html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>&nbsp;<a href="'+xhref+'" class="btn btn-success">Hapus</a>')
}

function AlertDetail(id,id2,id3,id4,id5,id6) {
		var myModal = new bootstrap.Modal(document.getElementById('varyingcontentdetail'));
		myModal.show();
		var isi = id6.replace(/<br\s*\/?>/gi, "\n")
		$('#id_approve').val(id);
		$('#template2').val(isi);
		$('#nama2').val(id2);
		//$('#pic2').val(id3);
		$('#tgl2').val(id4);
		$('#tgl22').val(id5);
	}

</script>


@endsection
