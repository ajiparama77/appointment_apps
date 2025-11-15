@extends('layouts_global.master')
@section('title') @lang('translation.datatables') @endsection
@section('css')
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Application @endslot
@slot('title')List Application @endslot
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
				<h5 class="card-title mb-0">List Data</h5>
				</div> 
				<div class="col-md-6" align="right">
				<a href="{{url('app_add')}}" class="btn btn-sm btn-primary"><i class="ri-add-line"></i>
 Add Data</a>
				</div>
				</div>
            </div>
            <div class="card-body">
			
			@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-box">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-box">
        {{ session('error') }}
    </div>
@endif

                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            
                            <th><center>No</center></th>
                            <th><center>Icon</center></th>
                            <th><center>Application Name</center></th>
                            <th><center>Code</center></th>
                            <th><center>Order</center></th>
                            <th><center>Url</center></th>
                            <th><center>New Tab</center></th>
                            <th><center>Internal</center></th>
                            <th><center>Active</center></th>
                            <th><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php $no=1; foreach($list_app as $list){ ?>
						

                        <tr>
                            
                            <td><center><?php echo $no++; ?></center></td>
                            <td>
							<?php if($list->icon == "" || $list->icon == null){ ?>
							<img src="{{url('images/icon/no-image-icon-0.jpg')}}" width="30px" height="30px">
							<?php }else{ ?>
							<img src="{{url(''.$list->icon)}}" width="30px" height="30px">
							<?php } ?>
							</td>
                            <td><?php echo $list->name; ?></td>
                            <td><?php echo $list->code; ?></td>
							<td><center><?php echo $list->urutan; ?></center></td>
                            <td><?php echo $list->url; ?></td>
                            <td><center><?php if($list->is_newtab == 0){ echo "No"; }else{ echo "Yes"; } ?></center></td>
                            <td><center><?php if($list->is_internal == 0){ echo "No"; }else{ echo "Yes"; } ?></center></td>
                            <td><center><?php if($list->is_active == 0){ echo "No"; }else{ echo "Yes"; } ?></center></td>
                            
                            <td>
                                <center>
								<a class="btn btn-sm btn-success" href="{{url('app_edit?id='.$list->id)}}"><i class="ri-pencil-fill"></i></a>
								
										<a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="AlertDLT({{ $list->id }})">
											<i class="ri-delete-bin-fill"></i>
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
 setTimeout(function() {
        let alertBox = document.getElementById('alert-box');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);
	
function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus template ini?")) {
        window.location.href = "{{ url('app_delete') }}?id=" + id;
    }
} 

function AlertDLT(id) {
	var myModal = new bootstrap.Modal(document.getElementById('firstmodal'));
	myModal.show();	
	xhref = "{{ url('app_delete') }}?id=" + id;
	$("#alche").html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>&nbsp;<a href="'+xhref+'" class="btn btn-success">Delete</a>')
}

</script>


@endsection
