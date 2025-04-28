@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.products'))}}
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.products')}} </h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{ route('admins.products.index') }}" class="btn btn-secondary mr-2">{{__('cp.cancel')}}</a>
                <button id="updateQuantitiesBtn" class="btn btn-success">{{__('cp.edit')}}</button>
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
                <form class="form" method="post" action="{{ route('admins.products.update.quantites', $item->id) }}"
                      enctype="multipart/form-data" id="updateQuantitiesForm">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.editQuantities')}}</h3>
                    </div>
                    <div class="card-body">
                        @if(@$item->has_variants && @$item->type_variants ==  1 && $item->productColorSizes->isNotEmpty())

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('cp.color')}}</th>
                                        <th>{{__('cp.size')}}</th>
                                        <th>{{__('cp.quantity')}}</th>
                                        <th>SKU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->productColorSizes as $colorSize)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="{{ $colorSize->color->name }}" disabled />

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $colorSize->size->name }}"
                                                disabled />
                                            <input type="hidden" name="ids[]" value="{{ $colorSize->id }}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="quantities[]"
                                                value="{{ $colorSize->quantity }}" min="0" step="1" required/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="skus[]"
                                                value="{{ $colorSize->sku }}" required/>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @elseif(@$item->has_variants && @$item->type_variants == 2 && $item->productColorSizes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('cp.color')}}</th>
                                        <th>{{__('cp.quantity')}}</th>
                                        <th>SKU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->productColorSizes as $oneColor)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" value="{{ @$oneColor->color->name }}" disabled />
                                            <input type="hidden" name="ids[]" value="{{ @$oneColor->id }}" />
                                        </td>

                                        <td>
                                            <input type="number" class="form-control"
                                                name="quantities[]"
                                                value="{{ @$oneColor->quantity }}" min="0" step="1" required/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="skus[]"
                                                value="{{ @$oneColor->sku }}" required/>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @elseif(@$item->has_variants && @$item->type_variants == 3 && $item->productColorSizes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('cp.size')}}</th>
                                        <th>{{__('cp.quantity')}}</th>
                                        <th>SKU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->productColorSizes as $oneSize)

                                    <tr>

                                        <td>
                                            <input type="text" class="form-control" value="{{ $oneSize->size->name }}" disabled />
                                            <input type="hidden" name="ids[]" value="{{ $oneSize->id }}" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="quantities[]"
                                                value="{{ @$oneSize->quantity }}" min="0" step="1" required/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                   name="skus[]"
                                                   value="{{ @$oneSize->sku }}" required/>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;">
                            @lang('cp.no_data')
                        </div>
                        @endif
                    </div>
                    <button type="submit" id="submitForm" style="display:none"></button>
                </form>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
</div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('input[name="quantities[]"], input[name="skus[]"]').on('input focus', function () {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            $('#updateQuantitiesBtn').on('click', function (e) {
                e.preventDefault();

                let valid = true;
                let errorMsg = "{{ __('cp.this_field_is_required') }}";

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $('input[name="quantities[]"]').each(function () {
                    if ($(this).val().trim() === '' || isNaN($(this).val()) || parseInt($(this).val()) < 0) {
                        $(this).addClass('is-invalid');
                        $(this).after('<div class="invalid-feedback d-block">'+ errorMsg +'</div>');
                        valid = false;
                    }
                });

                $('input[name="skus[]"]').each(function () {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        $(this).after('<div class="invalid-feedback d-block">'+ errorMsg +'</div>');
                        valid = false;
                    }
                });

                if (valid) {
                    $('#updateQuantitiesForm')[0].submit();
                }
            });
        });
    </script>
@endsection
