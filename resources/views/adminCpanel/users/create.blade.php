@extends('layout.adminLayout')
@section('title')
    {{__('cp.users')}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3> {{__('cp.users')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/users')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <form class="form" method="post" action="{{url(app()->getLocale().'/admin/users')}}"
                          enctype="multipart/form-data" role="form" id="form">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.add')}}  {{__('cp.users')}}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.name')}}</label>
                                        <input type="text" class="form-control  "
                                               name="name" value="{{ old('name')}}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.email')}}</label>
                                        <input type="email" class="form-control" name="email"
                                               value="{{ old('email')}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.date_of_birth')}}</label>
                                        <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" required />
                                    </div>
                                </div>
                              <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('cp.introduction')}}</label>
                                        <select class="form-control" name="introduction" required>
                                            <option value="965" {{old('introduction') == '965' ? 'selected' : ''}}>+965</option>
                                            <option value="966" {{old('introduction')  == '966' ? 'selected' : ''}}>+966</option>
                                            <option value="968" {{old('introduction')  == '968' ? 'selected' : ''}}>+968</option>
                                            <option value="971" {{old('introduction')  == '971' ? 'selected' : ''}}>+971</option>
                                            <option value="973" {{old('introduction')  == '973' ? 'selected' : ''}}>+973</option>
                                            <option value="974" {{old('introduction')  == '974' ? 'selected' : ''}}>+974</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('cp.mobile')}}</label>
                                        <input type="text" class="form-control  " onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                               name="mobile" value="{{old('mobile')}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.password')}}</label>
                                        <input type="password" class="form-control" name="password"
                                               value="{{ old('password') }}"
                                               placeholder="{{__('cp.password')}} " required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.confirm_password')}}</label>
                                        <input type="password" class="form-control" name="confirm_password"
                                               value="{{ old('confirm_password') }}"
                                               placeholder="{{__('cp.confirm_password')}} " required>
                                    </div>
                                </div>

                            </div>
                        </div>

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
