@extends('layouts_global.master')
@section('title') @lang('translation.input-masks') @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Global @endslot
        @slot('title') Change Password @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Change Password</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ url('save-change-password') }}" enctype="multipart/form-data">
					  @csrf
                        <div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">New Password</label>
										<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <div class="input-group">
											<input type="password" onkeyup="checkPasswordMatch()" class="form-control" id="password" name="password" placeholder="············" required>
											<button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" style="background-color: #0b0b0b2b;">
												<i class="mdi mdi-eye fs-16 align-middle"></i>
											</button>
										</div>
                                    </div>

                                </div><!-- end col -->

                                
                            </div><!-- end row -->
							 <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="cleave-date" class="form-label">Confirm New Password</label>
                                        <div class="input-group">
											<input type="password" onkeyup="checkPasswordMatch()" class="form-control" id="cpassword" name="cpassword" placeholder="············" required>
											<button type="button" class="btn btn-outline-secondary" onclick="togglePassword2()" style="background-color: #0b0b0b2b;">
												<i class="mdi mdi-eye fs-16 align-middle"></i>
											</button>
										</div>
                                    </div>

                                </div><!-- end col -->

                                
                            </div>
							
							
							<div class="border mt-3 border-dashed"></div>
							<br>
							<div class="row">
								<div class="col-xl-12" align="right">
									<button type="submit" id="justbutton" class="btn btn-success" disabled>Change Password</button>
								</div>
							</div>
                        </div>


                        
                    </form><!-- end form -->
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

    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }
	
	function togglePassword2() {
        const input = document.getElementById('cpassword');
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
	
	
	function checkPasswordMatch() {
		const password = document.getElementById('password').value;
		const cpassword = document.getElementById('cpassword').value;
		const submitBtn = document.getElementById('justbutton');

		if (password !== '' && cpassword !== '' && password === cpassword) {
			submitBtn.disabled = false;
		} else {
			submitBtn.disabled = true;
		}
	}

</script>
@endsection
