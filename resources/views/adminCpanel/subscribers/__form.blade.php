<div class="card-body">
    <div class="row">
       <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.email')}}</label>
                <input type="text" class="form-control" name="email" value="{{ old('email',@$item->email) }}" required />
            </div>
        </div>
    </div>
</div>
