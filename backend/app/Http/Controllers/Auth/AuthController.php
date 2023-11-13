<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use App\Models\EditRecord;
use App\Http\Controllers\Controller;
use App\Models\LoginRecord;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Job;
use App\Models\Article;
use App\Models\Portofolio;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient as BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange as DateRange;
use Google\Analytics\Data\V1beta\Dimension as Dimension;
use Google\Analytics\Data\V1beta\Metric as Metric;
use Google\Analytics\Data\V1beta\RunReportRequest as RunReportRequest;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function loginpage()
    {
        return view('login.login');
    }

    public function postlogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Buat atau perbarui token personal access untuk pengguna yang berhasil login
            $token = $user->createToken('auth_token')->plainTextToken;
            LoginRecord::create([
                'action'=>'Log In',
                'user_id'=>$user['id'],
                'role_id'=>$user['role_id']
            ]);
            return redirect('/adminpanel')->with('auth_token', $token)->with('success', 'Welcome ' . $user->firstname . ' ' . $user->lastname);
        }
        return redirect('/login')->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        // Mengambil data user untuk dimasukkan ke login record
        $user = Auth::user();
        // Revoke (mencabut) semua token akses pribadi yang dimiliki pengguna saat ini
        Auth::user()->tokens()->delete();

        // Logout pengguna
        Auth::logout();
        LoginRecord::create([
            'action'=>'Log Out',
            'user_id'=>$user['id'],
            'role_id'=>$user['role_id']
        ]);
        // Set pesan flash
        return redirect('/login')->with('success', 'You have successfully logged out.');
    }

    public function refreshToken(Request $request)
    {
        $user = Auth::user();

        // Revoke (mencabut) semua token akses pribadi yang dimiliki pengguna saat ini
        $user->tokens()->delete();

        // Buat token akses baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect('/adminpanel')->with('auth_token', $token);
    }

    public function adminpanel()
    {
        // Periksa apakah token masih berlaku (belum kedaluwarsa)
        $user = Auth::user();
        $tokenIsValid = $user->tokens->isNotEmpty();

        if ($tokenIsValid) {
            // Token masih berlaku, beri akses ke halaman adminpanel
            // Mengambil data untuk halaman adminpanel

            // Mangmbil Google Analytics Credentials
            $GACredentials = base_path('/app/Analytics/'.env('ANALYTICS_CREDENTIALS'));

            // Credentials Authorization
            $analyticsClient = new BetaAnalyticsDataClient([
                'credentials' => $GACredentials
            ]);

            // Configurasi Permintaan yang ingin diminta
            $analyticsConfig = (new RunReportRequest())
                ->setProperty('properties/' . env('ANALYTICS_PROPERTY_ID'))
                // Jarak Waktu Yang diambil
                ->setDateRanges([
                    new DateRange([
                        'start_date' => '2023-01-01',
                        'end_date' => 'today',
                    ]),
                ])
                // Detail Tambahan
                ->setDimensions([new Dimension([
                        'name' => 'country',
                    ]),
                ])
                // Mengambil Data
                ->setMetrics([new Metric([
                        'name' => 'activeUsers',
                    ])
                ]);

            // Mengirimkan request ke Google Analytic Properties
            $analyticsData = $analyticsClient->runReport($analyticsConfig);
            // return dd($analyticsData);
            if (!empty($analyticsData->getRows())) {
                $activeUsers = 0;
                for($i = 0; $i < $analyticsData->getRowCount(); $i++) {
                    // Akses baris pertama (karena Anda hanya memiliki satu baris)
                    $firstRow = $analyticsData->getRows()[$i];

                    // Akses metrik dalam baris pertama
                    $metrics = $firstRow->getMetricValues();

                    // Mengambil banyak visitor
                    $activeUsers = $activeUsers + $metrics[0]->getValue();
                }
            } else {
                $activeUsers = null;
            }

            $jobData =  Job::all()->count();
            $articleData = Article::all()->count();
            $portofolioData = Portofolio::all()->count();
            $productData = Product::all()->count();
            $todos = ToDoList::all();
            $editRecord = EditRecord::query()
                    ->with(['user','role'])
                    ->paginate(10);
            // Membuat login record
            $loginRecords = LoginRecord::query()
                    ->with('user','role')
                    ->paginate(10);
            $allData = array('jobData','articleData','portofolioData','productData','loginRecords', 'todos', 'activeUsers','editRecord');
            return view('pages.dashboard',compact($allData));
        }

        // Token telah kedaluwarsa, arahkan pengguna untuk memperbarui token
        return redirect()->route('refresh-token');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('change-password')->with('success', 'Password changed successfully.');
        }

        return redirect()->route('change-password')->withErrors(['current_password' => 'Current password is incorrect.']);
    }
}
