@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.promoCodes'))}}
@endsection
@section('css')
    <style>
        .countries-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .country-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 5px;
            width: 100%;
        }
        .badge {
            flex: 1;
            min-width: 0;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: center;
            box-sizing: border-box;
            padding: 6px 12px;
        }
        .country-row.single .badge {
            flex: 0 0 auto;
            max-width: 200px;
        }
    </style>
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.promoCodes'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <button type="button" class="btn btn-secondary" href="#activation" role="button"  data-toggle="modal">
                            <i class="icon-xl la la-check"></i>
                            <span>{{__('cp.active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#cancel_activation" role="button"  data-toggle="modal">
                            <i class="icon-xl la la-ban"></i>
                            <span>{{__('cp.not_active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button" data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>
                    </div>

                    <a href="{{route('admins.promoCodes.create')}}" class="btn btn-secondary  mr-2 btn-success">
                        <i class="icon-xl la la-plus"></i>
                        <span>{{__('cp.add')}} </span>
                    </a>
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
                <div class="gutter-b example example-compact">

                    <div class="contentTabel">
                        <button  type="button" class="btn btn-secondar btn--filter mr-2"><i class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                        <div class="container box-filter-collapse" >
                            <div class="card" >
                                <form class="form-horizontal" method="get" action="{{route('admins.promoCodes.index')}}">
                                  <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.id')}}</label>
                                            <input type="text" class="form-control" name="id" placeholder="{{__('cp.id')}}"
                                                value="{{request('id')?request('id'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.code')}}</label>
                                            <input type="text" class="form-control" name="code" placeholder="{{__('cp.code')}}"
                                                value="{{request('code')?request('code'):''}}">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.value')}}</label>
                                            <input type="text" class="form-control" name="percent" placeholder="{{__('cp.value')}}"
                                                value="{{request('percent')?request('percent'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.number_remaining_uses')}}</label>
                                            <input type="text" class="form-control" name="number_remaining_uses"
                                                placeholder="{{__('cp.number_remaining_uses')}}"
                                                value="{{request('number_remaining_uses')?request('number_remaining_uses'):''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.start_date')}}</label>
                                            <input type="date" class="form-control pull-right"
                                                value="{{request('start_date')?request('start_date'):''}}" name="start_date" id="from_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.end_date')}}</label>
                                            <input type="date" class="form-control pull-right" value="{{request('end_date')?request('end_date'):''}}"
                                                name="end_date" id="to_date">
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label class="control-label">{{__('cp.country')}}</label>
                                              <select class="select2 form-control" name="countries[]" multiple>
                                                  <option disabled>{{__('cp.select')}}</option>
                                                  @foreach($countries as $oneCoun)
                                                      <option value="{{ $oneCoun->id }}"
                                                          {{ in_array($oneCoun->id, request('countries', [])) ? 'selected' : '' }}>
                                                          {{@$oneCoun->name}}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.status')}}</label>
                                            <select id="multiple2" class="form-control" name="status">
                                                <option value="">{{__('cp.all')}}</option>
                                                <option value="active" {{request('status')=='active' ?'selected':''}}>
                                                    {{__('cp.active')}}
                                                </option>
                                                <option value="not_active" {{request('status')=='not_active' ?'selected':''}}>
                                                    {{__('cp.not_active')}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url(app()->getLocale().'/admin/promoCodes')}}" type="submit"
                                            class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                            <div>


                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                <thead>
                                <tr>
                                    <th class="wd-1p no-sort">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="checkAll" /> <span></span></label>
                                        </div>
                                    </th>
                                    <th> {{ucwords(__('cp.id'))}}</th>
                                    <th> {{ucwords(__('cp.code'))}}</th>
                                    <th> {{ucwords(__('cp.value'))}}</th>
                                    <th> {{ucwords(__('cp.number_remaining_uses'))}}</th>
                                    <th> {{ucwords(__('cp.frequency_of_use'))}}</th>
                                    <th> {{ucwords(__('cp.start_date'))}}</th>
                                    <th> {{ucwords(__('cp.end_date'))}}</th>
                                    <th>{{ucwords(__('cp.countries'))}}</th>
                                    <th> {{ucwords(__('cp.status'))}}</th>
                                    <th> {{ucwords(__('cp.created'))}}</th>
                                    <th> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $one)
                                    <tr class="odd gradeX" id="tr-{{@$one->id}}">
                                        <td class="v-align-middle wd-5p">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{@$one->id}}"  class="checkboxes" name="chkBox" />
                                                    <span></span></label>
                                            </div>
                                        </td>

                                        <td class="v-align-middle wd-25p">{{@$one->id}}</td>
                                        <td class="v-align-middle wd-25p">{{@$one->code}}</td>
                                        <td class="v-align-middle wd-25p">{{@$one->discount_percentage}} %</td>
                                        <td class="v-align-middle wd-25p">{{@$one->number_remaining_uses}} </td>
                                        <td class="v-align-middle wd-25p">{{@$one->maximum_usage - $one->number_remaining_uses}} </td>
                                        <td class="v-align-middle wd-25p">{{@$one->start_date}}</td>
                                        <td class="v-align-middle wd-25p">{{@$one->end_date}}</td>
                                        <td class="v-align-middle wd-25p">
                                            @if($one->all_countries == 1)
                                                <div class="countries-container">
                                                    <div class="country-row single">
                                                        <span class="badge badge-pill badge-primary">{{__('cp.all')}}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="countries-container">
                                                    @forelse($one->promoCodeCountries->chunk(2) as $countryChunk)
                                                        <div class="country-row {{ $countryChunk->count() == 1 ? 'single' : '' }}">
                                                            @foreach($countryChunk as $promoCountry)
                                                                <span class="badge badge-pill badge-info">{{@$promoCountry->country->name}}</span>
                                                            @endforeach
                                                        </div>
                                                    @empty
                                                        <div class="country-row single">
                                                            <span class="badge badge-pill badge-warning">{{__('cp.no_countries')}}</span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            @endif
                                        </td>
                                        <td class="v-align-middle wd-10p" > <span id="label-{{$one->id}}" class="badge badge-pill badge-{{($one->status == "active")
                                            ? "info" : "danger"}}" id="label-{{$one->id}}">

                                            {{__('cp.'.$one->status)}}
                                        </span>
                                        </td>

                                        <td class="v-align-middle wd-10p">{{@$one->created_at->format('Y-m-d')}}</td>

                                        <td class="v-align-middle wd-15p optionAddHours">

                                            <a href="{{route('admins.promoCodes.edit' , @$one->id)}}"
                                               class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <div style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;">
                                       @lang('cp.no_data')
                                    </div>
                                @endforelse

                                </tbody>
                            </table>
                            {{$items->appends($_GET)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
