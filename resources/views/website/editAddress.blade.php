<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="address_id" value="{{ @$data['item']->id }}">
<div class="form-group">
    <input type="text" class="form-control" placeholder="@lang('website.Address Title')" name="address_title"
        value="{{ @$data['item']->title }}" required />
</div>
<div class="form-group">
    <select class="form-control form-select country_id" name="country_id" id="country_id" required>
        @foreach($data['countries'] as $oneCountry)
        <option value="{{$oneCountry->id}}" {{ @$data['item']->country_id == $oneCountry->id ? 'selected' : '' }}>
            {{$oneCountry->name}}
        </option>
        @endforeach
    </select>
    <span id="shipping_content_kuwait">{{ @$setting->shipping_content_kuwait }}</span>
    <span id="shipping_content_outside_kuwait">{{ @$setting->shipping_content_outside_kuwait}}</span>
</div>
<div class="form-group">
    <select class="form-control form-select city_id" name="city_id" id="city_id"
        data-selected="{{ @$data['item']->city_id }}" required>
        <option value="">@lang('website.Select City')</option>
    </select>
</div>
<div class="form-group">
    <input type="text" class="form-control" id="address_line_one" placeholder="@lang('website.Block, Street Avenue')"
        name="address_line_one" value="{{ @$data['item']->address_line_one }}" required />
</div>
<div class="form-group">
    <input type="text" class="form-control" id="address_line_two"
        placeholder="@lang('website.Apartment, suite, etc') (@lang('website.Optional'))" name="address_line_two"
        value="{{ @$data['item']->address_line_two }}" />
</div>
<div class="form-group">
    <input type="text" class="form-control" id="postalCode"
        placeholder="@lang('website.Postal Code') (@lang('website.Optional'))" name="postal_code"
        value="{{ @$data['item']->postal_code }}" />
</div>
<div class="form-group">
    <textarea class="form-control" id="extra_directions"
        placeholder="@lang('website.Extra Directions') (@lang('website.Optional'))"
        name="extra_directions">{{ @$data['item']->extra_directions }}</textarea>
</div>
<div class="form-group">
    <button class="btn-site editAddress"  data-address_id="{{ @$data['item']->id }}"><span>@lang('website.Update')</span></button>
</div>
