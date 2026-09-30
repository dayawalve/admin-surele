<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class DataForSEOCostingController extends Controller
{
    public function index()
    {
        $login = config('services.dataforseo.login');
        $password = config('services.dataforseo.password');

        try {
            $response = Http::withBasicAuth($login, $password)
                ->timeout(15)
                ->get('https://api.dataforseo.com/v3/appendix/user_data');

            if ($response->successful()) {
                $body = $response->json();
                $result = $body['tasks'][0]['result'][0] ?? null;
                $error = null;

                if ($result) {
                    $balance = $result['money']['balance'] ?? 0;
                    $admin = Auth::guard('admin')->user();

                    if ($balance <= 5.00) {
                        if ($admin && !$admin->is_mail_send_dataforseo) {
                            Mail::send('mail-templates.dataforseo-low-balance', [
                                'balance' => $balance,
                                'login' => $result['login'] ?? $login
                            ], function ($message) use ($admin) {
                                $recipient = $admin->email ?? config('mail.from.address');
                                if ($recipient) {
                                    $message->to($recipient);
                                    $message->subject('Alert: DataForSEO Available Credit is Low');
                                }
                            });

                            Admin::query()->update(['is_mail_send_dataforseo' => true]);
                        }
                    } else {

                        Admin::query()->update(['is_mail_send_dataforseo' => false]);
                    }
                }
            } else {
                $result = null;
                $error = 'Failed to fetch DataForSEO statistics. API returned status code: ' . $response->status();
            }
        } catch (\Exception $e) {
            $result = null;
            $error = 'Error connecting to DataForSEO: ' . $e->getMessage();
        }

        return view('admin.dataforseo-costing.index', compact('result', 'error'));
    }
}
