@extends('adminCpanel.users.sideMenu')
@section('companyContent')

    <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">{{__('cp.addresses')}} </span>

            </h3>
            <div class="card-toolbar">
                <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link py-2 px-4 active"-->
                    <!--       href="{{url(getLocal().'/admin/users/'.$item->id.'/createAddress')}}">{{__('cp.add')}}</a>-->
                    <!--</li>-->
                </ul>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-2">
            <!--begin::Table-->
            <div class="table-responsive">
                <button type="button" class="btn btn-secondar btn--filter mr-2"><i
                        class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                <div class="container box-filter-collapse">
                    <div class="card">
                        <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/users/'.$item->id.'/addresses')}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">{{__('cp.address_name')}}</label>
                                        <input type="text" class="form-control" name="title"  placeholder="{{__('cp.address_name')}}"
                                               value="{{request('title')?request('title'):''}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                        <i class="fa fa-search"></i>
                                    </button>

                                    <a href="{{url(getLocal().'/admin/users/'.$item->id.'/addresses')}}" type="submit" class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between"></div>
                    <table class="table table-borderless table-vertical-center">
                        <thead>
						<tr>
							<th class="p-0" style="min-width: 110px">{{__('cp.address_name')}}</th>
							<th class="p-0" style="min-width: 100px">{{__('cp.country')}}</th>
							<th class="p-0" style="min-width: 100px">{{__('cp.city')}}</th>
							<th class="p-0" style="min-width: 150px">{{__('website.address_line_one')}}</th>
							<th class="p-0" style="min-width: 150px">{{__('website.address_line_two')}}</th>
							<th class="p-0" style="min-width: 150px">{{__('website.Extra Directions')}}</th>
							<th class="p-0" style="min-width: 100px">{{__('website.Postal Code')}}</th>
						</tr>
					</thead>
					<tbody>
					     @foreach($addresses as $one)
						<tr>
							<td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->title}}</span>
								</div>
							</td>
							<td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->country->name}}</span>
								</div>
							</td>
							<td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->city->name }}</span>
								</div>
							</td>
							<td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->address_line_one}}</span>
								</div>
							</td>
							<td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->address_line_two}}</span>
								</div>
							</td>
                            <td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{@$one->extra_directions}}</span>
								</div>
							</td>
                            <td class="pl-0">
								<div>
									<span class="font-weight-bolder">{{$one->country_id != 1 ? @$one->postal_code : "--"}}</span>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				  {{$addresses->appends($_GET)->links("pagination::bootstrap-4") }}
			</div>
			<!--end::Table-->
		</div>
		<!--end::Body-->
	</div>
	<!--end::Advance Table Widget 7-->
	   </div>
        <!--end::Entry-->
    </div
@endsection
