<div class="card-body">
    <div class="row">
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('cp.subject_' . $locale->lang) }}</label>
                <input type="text" class="form-control" {{ ($locale->lang == 'ar') ? 'dir=rtl' : '' }}
                name="subject_{{ $locale->lang }}"
                value="{{ isset($item->translate($locale->lang)->subject) ? old('subject_' . $locale->lang,
                $item->translate($locale->lang)->subject) : old('subject_' . $locale->lang) }}"
                required />
                @error('subject_' . $locale->lang)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @endforeach

        @foreach($locales as $locale)
        <div class="col-md-12">
            <div class="form-group">
                <label for="content_{{ $locale->lang }}">{{ __('cp.content_' . $locale->lang) }}</label>
                <textarea class="form-control kt-ckeditor ckEditor-y" id="kt-ckeditor-{{ $loop->index+4 }}" {{
                    ($locale->lang == 'ar') ? 'dir=rtl' : '' }}
                          name="content_{{ $locale->lang }}"
                          rows="4" required>{!! old('content_' . $locale->lang, @$item->translate($locale->lang)->content) !!}</textarea>
                @error('content_' . $locale->lang)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @endforeach

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('cp.status') }}</label>
                <select class="select2 form-control" name="status" required>
                    <option value="">{{ __('cp.select') }}</option>
                    <option value="scheduled" {{ old('status', @$item->status) === 'scheduled' ? 'selected' : '' }}>{{
                        __('cp.scheduled') }}</option>
                    <option value="delivered" {{ old('status', @$item->status) === 'delivered' ? 'selected' : '' }}>{{
                        __('cp.sendNow') }}</option>
                    <option value="draft" {{ old('status', @$item->status) === 'draft' ? 'selected' : '' }}>{{
                        __('cp.draft') }}</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3 schedule-field"
            style="display: {{ old('status', @$item->status) === 'scheduled' ? 'block' : 'none' }};">
            <div class="form-group">
                <label>{{ __('cp.date') }}</label>
                <input type="date" class="form-control" name="date"
                    value="{{ old('date', @$item->date ?? '') }}" {{
                    old('status', @$item->status) === 'scheduled' ? 'required' : '' }} />
                @error('date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-3 schedule-field"
            style="display: {{ old('status', @$item->status) === 'scheduled' ? 'block' : 'none' }};">
            <div class="form-group">
                <label>{{ __('cp.time') }}</label>
                <input type="time" class="form-control" name="time"
                    value="{{ old('time', @$item->time ?? '') }}" {{
                    old('status', @$item->status) === 'scheduled' ? 'required' : '' }} />
                @error('time')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/super-build/ckeditor.js"></script>
    @include('adminCpanel.settings.editor_script')
    <script src="{{ asset('/admin_assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script src="{{ asset('/admin_assets/js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/custom/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/jquery/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {

            $('select[name="status"]').on('change', function() {
                if ($(this).val() === 'scheduled') {
                    $('.schedule-field').show();
                    $('input[name="schedule_date"]').prop('required', true);
                    $('input[name="schedule_time"]').prop('required', true);
                } else {
                    $('.schedule-field').hide();
                    $('input[name="schedule_date"]').prop('required', false);
                    $('input[name="schedule_time"]').prop('required', false);
                }
            });

            if ($('select[name="status"]').val() === 'scheduled') {
                $('.schedule-field').show();
                $('input[name="schedule_date"]').prop('required', true);
                $('input[name="schedule_time"]').prop('required', true);
            }
        });
</script>
@endsection
