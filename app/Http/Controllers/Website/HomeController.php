<?php

namespace App\Http\Controllers\Website;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\SubscriberRequest;
use App\Models\{City, Setting, Language, Page, Banner, Faq, Subscriber, Category, Product};
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Session;

class HomeController extends Controller
{
    public function __construct(ContactService $contactService)
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        $this->contactService = $contactService;
        view()->share(['locales' => $this->locales,'settings' => $this->settings,]);
    }
    public function index()
    {
        $data['banners'] = Banner::active()->orderByDesc('id')->take(5)->get();
        $data['categories'] = Category::active()->where('is_featured', 'yes')->orderByDesc('id')->get();
        $data['products'] = Product::active()->where('most_selling', 1)->orderByDesc('id')->get();
        $data['newArrival'] = Product::active()->where('new_arrival', 1)->orderByDesc('id')->take(6)->get();

        return view('website.index' ,compact('data'));
    }
   public function subscribe(Request $request)
   {
       if ($this->settings->is_alowed_subscription == 0) {
           return response()->json([
               'code' => 201,
               'error' => __('website.subscribeStoped')]);
       }
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'recaptcha_token' => 'required'
        ],
        [
            'email.unique' => app()->getLocale() === 'ar'
                ? 'لقد اشتركت بالفعل.'
                : 'You already subscribe.',
        ]);
       $recaptchaSecret = env('RECAPTCHA_SECRET_KEY', '6LeqtR0rAAAAAMwnJo5WxGsNXStxuLYPsQVLSgLF');
       $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
           'secret' => $recaptchaSecret,
           'response' => $request->recaptcha_token,
           'remoteip' => $request->ip()
       ])->json();
       if (!isset($recaptchaResponse['success']) || !$recaptchaResponse['success'] ||
           (isset($recaptchaResponse['score']) && $recaptchaResponse['score'] < 0.5)) {
           return response()->json([
               'success' => false,
               'code' => 201,
               'error' => __('website.recaptcha_verification_failed', 'فشل التحقق الأمني، يرجى تحديث الصفحة والمحاولة مرة أخرى')
           ]);
       }
        Subscriber::create(['email' => $request->email]);
        return response()->json(['success' => true, 'message' => 'تم الاشتراك بنجاح!']);

   }
    public function contactUs()
    {
      return view('website.contactUs');
    }
    public function contactUsPost(ContactRequest $request)
    {
        try {
            $recaptchaSecret = env('RECAPTCHA_SECRET_KEY', '6LeqtR0rAAAAAMwnJo5WxGsNXStxuLYPsQVLSgLF');
            $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $request->recaptcha_token,
                'remoteip' => $request->ip()
            ])->json();
            if (!isset($recaptchaResponse['success']) || !$recaptchaResponse['success'] ||
                (isset($recaptchaResponse['score']) && $recaptchaResponse['score'] < 0.5)) {
                return response()->json([
                    'success' => false,
                    'code' => 201,
                    'error' => __('website.recaptcha_verification_failed', 'فشل التحقق الأمني، يرجى تحديث الصفحة والمحاولة مرة أخرى')
                ]);
            }
            $contact = $this->contactService->createContact($request);

            if ($contact) {
                $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 300, 'message' => $message]);
            } else {
                $message = __('api.whoops');
                return response()->json(['status' => false, 'code' => 500, 'message' => $message]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function pages($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('website.pages',['page'=>$page]);
    }
    public function faqs()
    {
        $faqs = Faq::active()->orderByDesc('id')->get();
        return view('website.faqs',['faqs'=>$faqs]);
    }
    public function changeCurrency($currency){
        Session::put('currency', $currency);
        return redirect()->back();
    }
    public function getCities(Request $request)
    {
        $countryId = $request->input('country_id');
        $cities = City::where('country_id', $countryId)->get(); // جلب المدن بناءً على معرف الدولة
        return response()->json(['cities' => $cities]); // إرجاع المدن بصيغة JSON

    }
}

