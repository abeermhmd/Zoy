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
    </div>
</div>
