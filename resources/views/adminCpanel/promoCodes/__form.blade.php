<div class="card-body">
    <div class="row">
       <div class="col-md-6">
        <div class="form-group">
            <label>{{__('cp.code')}}</label>
            <input type="text" class="form-control" name="code" value="{{ old('code',@$item->code) }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{__('cp.value')}}</label>
            <input type="number" class="form-control" name="discount_percentage" value="{{ old('discount_percentage',@$item->discount_percentage) }}"  min="1" max="100" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{__('cp.maximum_usage')}}</label>
           <input type="number" class="form-control" name="maximum_usage" min="1"
            value="{{ old('maximum_usage',@$item->maximum_usage ?? 1) }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-12 control-label">{{__('cp.countries')}}</label>
            <select class="form-control select2 countries" aria-required="true" name="countries[]" multiple
                required>
                <option value="" disabled>{{__('cp.select')}}</option>
                <option value="0" id="allOption" @if(@$item->all_countries == 1) selected @endif>{{__('cp.all')}}
                </option>
                @foreach ($countries as $oneCountry)
                <option value="{{ $oneCountry->id }}" class="optionEligibleSubjects" @if(in_array($oneCountry->id,
                    @$item->promoCodeCountries->pluck('country_id')->toArray())) selected @endif>{{$oneCountry->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{__('cp.start_date')}}</label>
           <input type="date" class="form-control" name="start_date"
            value="{{ old('start_date', @$item->start_date ? @$item->start_date : '') }}" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{__('cp.end_date')}}</label>
            <input type="date" class="form-control" name="end_date"
                value="{{ old('end_date', @$item->end_date ? @$item->end_date : '') }}" required />
        </div>
    </div>
    </div>
</div>
