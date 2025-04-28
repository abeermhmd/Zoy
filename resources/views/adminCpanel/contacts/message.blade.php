@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.contact'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.contact')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/contact')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                   <button id="submitButton" class="btn btn-success ">{{__('cp.edit')}}</button>
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
                    <form method="post" action="{{ route('admins.contact.update' , @$item->id) }}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                         @csrf
                         @method('PATCH')
                        <div class="row">
                              <div class="col-md-12">
                                   <div class="form-group">
                                   <label >{{__('cp.changeStatus')}}</label>
                                      <select id="status" class="form-control select2" name="status">
                                     <option value="">{{__('cp.select')}}</option>
                                      <option value="0">{{__('cp.pending')}}</option>
                                      <option value="1">{{__('cp.read')}}</option>
                                      </select>
                                   </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('cp.name')}}</label>
                                    <input class="form-control"
                                           name="message" value="{{@$item->name }}" disabled/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('cp.mobile')}}</label>
                                    <input class="form-control" name="mobile" value="{{@$item->mobile }}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('cp.email')}}</label>
                                    <input class="form-control" name="email" value="{{@$item->email }}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('cp.msg')}}</label>
                                    <textarea class="form-control" name="message"  id="order" rows="4" disabled>{{@$item->message}}</textarea>
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
