@extends('adminCpanel.users.sideMenu')
@section('companyContent')
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <form method="post" action="{{url(app()->getLocale().'/admin/users/'.$item->id.'/edit_password')}}"
                  enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                {{ csrf_field() }}
                <div class="card-header">
                    <h3 class="card-title">{{__('cp.Change_Password')}}</h3>
                </div>
                <div class="row col-sm-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('cp.password')}}</label>
                            <input type="password" class="form-control" name="password" required/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('cp.confirm_password')}}</label>
                            <input type="password" class="form-control" name="confirm_password"  required/>
                        </div>
                    </div>
                </div>

                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/users/')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
                </div>
                <!--end::Toolbar-->
                <button type="submit" id="submitForm" style="display:none"></button>
            </form>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
    </div>
    <!--end::Entry-->
    </div>
@endsection
