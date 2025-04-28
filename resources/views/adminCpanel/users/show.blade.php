@extends('adminCpanel.users.sideMenu')

@section('companyContent')
<div class="flex-row-fluid ml-lg-8">
    <!--begin::Row-->
    <div class="row">
        <div class="col-lg-6 col-xl-6 mb-5">
            <!--begin::Card-->
            <div class="card card-custom card-shadow-lg">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                            style="width: 80px; height: 80px;">
                            <i class="flaticon2-user font-size-h2"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bolder text-dark-75 mb-4"> @lang('cp.welcomInProfile') {{ @$item->name }}
                    </h2>

                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Row-->
</div>
<!--end::Content-->
</div>
<!--end::Profile Overview-->
</div>
<!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
</div>
<!--end::Wrapper-->

<!--end::Chat Panel-->
@endsection
