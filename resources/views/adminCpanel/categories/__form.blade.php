<div class="card-body">
    <div class="row">
        @foreach($locales as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__('cp.name_'.$locale->lang)}}</label>
                    <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                    name="name_{{$locale->lang}}"
                           value="{{ isset($item->translate($locale->lang)->name) ? old('name_'.$locale->lang , $item->translate($locale->lang)->name) : old('name_'.$locale->lang ) }}"
                           required/>
                </div>
            </div>
        @endforeach
        @foreach($locales as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__('cp.key_words_'.$locale->lang) . ' ('.__('cp.optional') .')'}} </label>
                    <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                    name="key_words_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->key_words) ?
                old('key_words_'.$locale->lang , $item->translate($locale->lang)->key_words) : old('key_words_'.$locale->lang ) }}"
                    />
                </div>
            </div>
        @endforeach
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label"> {{__('cp.department')}}</label>
                <select class="select2 form-control" name="department" required>
                    <option value="">
                        {{__('cp.select')}}
                    </option>
                    <option
                        value="women" {{ old('department', @$item->department) == 'women' ? 'selected' : '' }}>{{__('cp.women')}}</option>
                    <option
                        value="man" {{ old('department', @$item->department) == 'man' ? 'selected' : '' }}>{{__('cp.man')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.bulk_discount_percentage')}} ( {{__('cp.optional')}} )</label>
                <input type="number" class="form-control" name="discount"
                       value="{{ old('discount', @$item->discount) }}"
                       step="0.01" min="0" max="100"/>
            </div>
        </div>
        @if(request()->routeIs('admins.categories.create') || (request()->routeIs('admins.categories.edit') && @$item->subcategories->isEmpty()))
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-6 col-form-label">{{__('cp.is_featured')}}  </label>
                    <div class="col-6">
                    <span class="switch">
                        <label>
                            <input type="checkbox" {{@$item->is_featured == 'yes' ? "checked" : ""}}
                            name="is_featured"/>
                            <span></span>
                        </label>
                    </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="fileinputForm">
                <label>{{__('cp.image')}} <span
                        style="display: inline-block; color: #2c3e50; background: linear-gradient(to right, #ecf0f1, #bdc3c7); padding: 3px 8px; border-radius: 4px; font-size: 0.9em; box-shadow: 1px 1px 3px rgba(0,0,0,0.1);">( 10:13 Ratio , 500px X 650px)</span></label>
                <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image').click()"
                     style="cursor:pointer">
                    <img src="{{ @$item->image }}" alt="Image" id="editImage">
                </div>
                <div class="btn btn-change-img red" onclick="document.getElementById('edit_image').click()">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <input type="file" class="form-control" name="image" id="edit_image" style="display:none"
                       accept="image/*" @if(request()->routeIs('admins.categories.create')) required @endif >
            </div>
        </div>
    </div>
</div>
