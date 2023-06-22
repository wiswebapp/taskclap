<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralFunctions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    use GeneralFunctions;

    public function create(): View
    {
        return view('auth.login');
    }

    public function create_v1(): View
    {
        return view('auth.login_v1');
    }

    public function validateNumber(Request $request)
    {
        $response['success'] = true;
        $response['msg'] = "Number Validate success !";
        $requestData = $request->all();
        if (empty($requestData['g-recaptcha-response'])) {
            $response['success'] = false;
            $response['msg'] = "Please fill reCAPTCHA";
            $response['extras'] = json_encode($requestData);
            return json_encode($response);
        }

        $phone = trim($request->phone);
        $phone = str_replace('+91', '', $phone);
        $number = preg_replace('/[^0-9]/', '', $phone);
        if (! preg_match('/^(?:\+91|0)?[6-9]\d{9}$/', $number)) {
            $response['success'] = false;
            $response['msg'] = "Please Enter Valid Mobile number";
            return json_encode($response);
        }

        return json_encode($response);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function storeWithOtp(Request $request): string
    {
        $this->validate($request, [
            'phone' => [
                'required','int','digits:10',
            ],
        ]);

        $phone =  trim(str_replace('+91', '', $request->get('phone')));
        $user = User::where('phone', $phone)->first();
        if (! $user) {
            $user = User::create([
                'name' => "Verified User",
                'email' => "",
                'phone' => $request->phone,
                'password' => Hash::make($this->generateStrongPassword()),
                'country_id' => 1,
                'state_id' => 1,
                'city_id' => 1,
                'area_id' => 1,
                'address' => 'Dev Aurum Commercial Complex Prahlad Nagar, Ahmedabad, Gujarat 380015',
            ]);
        }

        Auth::login($user);

        $returnArr['success'] = true;
        $returnArr['loginLink'] = route('homepage');
        if (Session::get('cartProcced')) {
            $returnArr['loginLink'] = route('homepage') . Session::get('cartLink');
        }

        return json_encode($returnArr);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
