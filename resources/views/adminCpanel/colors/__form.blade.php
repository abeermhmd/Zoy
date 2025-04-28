<div class="card-body">
    <div class="row">
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.name_'.$locale->lang)}}</label>
                <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                name="name_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->name) ? old('name_'.$locale->lang , @$item->translate($locale->lang)->name) : old('name_'.$locale->lang ) }}" required/>
            </div>
        </div>
        @endforeach
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.color')}}</label>
                <input type="color" class="form-control" name="hex_code" value="{{old('hex_code',@$item->hex_code)}}" required />
            </div>
        </div>
        @if(request()->is('*edit*'))
        <div class="col-md-6">
            <div class="form-group">
                <label>Hex Code</label>
                <input type="text" class="form-control" value="{{old('hex_code',@$item->hex_code)}}" disabled />
            </div>
        </div>
        @endif
    </div>
</div>
