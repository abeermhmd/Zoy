<div class="card-body">
    <div class="row">
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.question_'.$locale->lang)}}</label>
                <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                name="question_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->question) ? old('question_'.$locale->lang , @$item->translate($locale->lang)->question) : old('question_'.$locale->lang ) }}" required/>
            </div>
        </div>
        @endforeach
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.answer_'.$locale->lang)}}</label>
                <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                name="answer_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->answer) ? old('answer_'.$locale->lang , @$item->translate($locale->lang)->answer) : old('answer_'.$locale->lang ) }}" required/>
            </div>
        </div>
        @endforeach

    </div>
</div>
