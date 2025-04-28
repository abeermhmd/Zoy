<div class="card-body">
    <div class="row">
        <!-- Name Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.name')}}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', @$item->name) }}" required />
            </div>
        </div>

        <!-- Email Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.email')}}</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', @$item->email) }}"
                    required />
            </div>
        </div>

        <!-- Mobile Field -->
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.mobile')}}</label>
                <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text"
                    class="form-control" name="mobile" value="{{ old('mobile', @$item->mobile) }}" required />
            </div>
        </div>

        @if(@$item->id != 1)
        <div class="col-md-6">
            <div class="form-group">
                <label> {{__('cp.role')}}</label>
                <select class="form-control select2" id="permissions" name="permissions[]" multiple="multiple" required>
                    @if (isset($role) && $role != '')
                    @foreach($role as $roleItem)
                    <option value="{{ $roleItem->roleSlug }}" @if(Route::is('admins.admins.edit') &&
                        in_array($roleItem->roleSlug, @$userRoleItem))
                        selected
                        @endif
                        >{{ $roleItem->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        @endif

        @if(Route::is('admins.admins.create'))
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.password')}}</label>
                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                    placeholder="{{__('cp.password')}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.confirm_password')}}</label>
                <input type="password" class="form-control" name="confirm_password"
                    value="{{ old('confirm_password') }}" placeholder="{{__('cp.confirm_password')}}" required>
            </div>
        </div>
        @endif
    </div>
</div>
