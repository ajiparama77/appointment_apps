@extends('layouts_global.master')
@section('title') @lang('translation.input-masks') @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Application @endslot
        @slot('title') Edit Application @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Data</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ url('app_update') }}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="id" value="{{ $master->id }}">
					<div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Application Name <font color="red">*</font></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{$master->name}}" required>
                                    </div>

                                </div>
								<div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Code <font color="red">*</font></label>
                                        <input type="text" class="form-control" id="code" name="code" value="{{$master->code}}" required>
                                    </div>

                                </div>
							</div>
							<div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Url <font color="red">*</font></label>
                                        <input type="text" class="form-control" id="url" name="url" value="{{$master->url}}" required>
                                    </div>

                                </div>
								<div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Order <font color="red">*</font></label>
                                        <input type="number" class="form-control" id="urutan" name="urutan" value="{{$master->urutan}}" required>
                                    </div>

                                </div>
								<div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Icon&nbsp;&nbsp;&nbsp; 
										<?php if($master->icon != null || $master->icon != "") { echo "<a target='_blank' href=".url('')."/".$master->icon."><span class='badge bg-warning text-dark'>Icon Sebelumnya</span></a>"; }?>
										</label>
                                        <input type="file" class="form-control" id="icon" name="icon"> 
                                    </div>

                                </div>
								
							</div>
							<div class="row">
								
								
							</div>
							<div class="row">
								<div class="col-xl-4">
									<div class="mb-3">
										<label class="form-label">New Tab</label><br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_newtab" id="defaultYes" value="1" <?php if($master->is_newtab == 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultYes">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_newtab" id="defaultNo" value="0" <?php if($master->is_newtab != 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultNo">No</label>
										</div>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="mb-3">
										<label class="form-label">Internal <font color="red">*</font></label><br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_internal" id="defaultYes" value="1" <?php if($master->is_internal == 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultYes">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_internal" id="defaultNo" value="0" <?php if($master->is_internal != 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultNo">No</label>
										</div>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="mb-3">
										<label class="form-label">Active <font color="red">*</font></label><br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_active" id="defaultYes" value="1" <?php if($master->is_active == 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultYes">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_active" id="defaultNo" value="0" <?php if($master->is_active != 1){ ?> checked <?php } ?>>
											<label class="form-check-label" for="defaultNo">No</label>
										</div>
									</div>
								</div>
							</div>
							
							
							<div class="border mt-3 border-dashed"></div>
							<br>
							<div class="row">
								<div class="col-xl-12" align="right">
									<a href="{{url('app_list')}}" type="submit" class="btn btn-danger">Back</a>
									<button type="submit" class="btn btn-success">Update</button>
								</div>
							</div>
                        </div>

</form>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
	<script>
function tambahHari() {
    const wrapper = document.getElementById("hari-wrapper");
    const div = document.createElement("div");
    div.classList.add("input-group", "mb-2");

    div.innerHTML = `
        <input type="number" name="hari_expired[]" class="form-control" placeholder="Contoh: 7">
        <button type="button" class="btn btn-outline-danger" onclick="hapusHari(this)">−</button>
    `;

    wrapper.appendChild(div);
}

function hapusHari(btn) {
    btn.parentElement.remove();
}
</script>
@endsection
