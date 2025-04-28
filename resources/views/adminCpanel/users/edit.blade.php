@extends('adminCpanel.users.sideMenu')
@section('companyContent')
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <form method="post" action="{{url(app()->getLocale().'/admin/users/'.$item->id)}}"
                  enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                {{ csrf_field() }}
                <div class="card-header">
                    <h3 class="card-title">{{__('cp.edit')}} {{__('cp.main_data')}}</h3>
                    <br>
                </div>

                <div class="row col-sm-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('cp.name')}}</label>
                            <input type="text" class="form-control  "
                                   name="name" value="{{@$item->name}}" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('cp.email')}}</label>
                            <input type="text" class="form-control  " name="email"
                                   value="{{@$item->email}}" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('cp.date_of_birth')}}</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth', @$item->date_of_birth ? @$item->date_of_birth : '') }}" required />
                        </div>
                    </div>
                       <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('cp.introduction')}}</label>
                            <select class="form-control" name="introduction" required>
                                <option value="965" {{substr($item->mobile, 0, 3) == '965' ? 'selected' : ''}}>+965</option>
                                <option value="966" {{substr($item->mobile, 0, 3) == '966' ? 'selected' : ''}}>+966</option>
                                <option value="968" {{substr($item->mobile, 0, 3) == '968' ? 'selected' : ''}}>+968</option>
                                <option value="971" {{substr($item->mobile, 0, 3) == '971' ? 'selected' : ''}}>+971</option>
                                <option value="973" {{substr($item->mobile, 0, 3) == '973' ? 'selected' : ''}}>+973</option>
                                <option value="974" {{substr($item->mobile, 0, 3) == '974' ? 'selected' : ''}}>+974</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('cp.mobile')}}</label>
                            <input type="text" class="form-control"
                                   onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                   name="mobile"
                                   value="{{
                                       (substr($item->mobile, 0, 1) == '1')
                                           ? substr($item->mobile, 1)
                                           : ( (substr($item->mobile, 0, 2) == '20' || substr($item->mobile, 0, 2) == '90')
                                               ? substr($item->mobile, 2)
                                               : substr($item->mobile, 3) )
                                   }}" />
                        </div>
                    </div>



                </div>
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/users')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
                </div>
                <!--end::Toolbar-->
                <button type="submit" id="submitForm" style="display:none"></button>
            </form>
        </div>
        <!--end::Card-->
    </div>
    </div>
    <!--end::Entry-->
    </div>

@endsection
