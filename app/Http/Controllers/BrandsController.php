<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SelfBrandsExport;

class BrandsController extends Controller
{
    private function getSeoStatusDefaults()
    {
        return [
            'seo_overview' => false,
            'seo_failures' => false,
            'seo_technical' => false,
            'seo_onpage' => false,
            'seo_page_analysis' => false,
            'seo_performance' => false,
            'seo_ai_insights' => false,
            'seo_llm_prompts' => false,
            'seo_reports' => false,
            'seo_analytics' => false,
            'seo_keywords' => false,
            'seo_backlink_tracker' => false,
            'seo_content_strategy' => false,
            'seo_implementation' => false,
            'pillar_visibility_score' => false,
            'pillar_visibility_trend' => false,
            'pillar_responses' => false,
            'pillar_competitors' => false,
            'pillar_citations' => false,
            'pillar_google_analytics' => false,
            'pillar_google_search_console' => false,
            'pillar_chat_bot' => false,
        ];
    }

    /**
     * SEO Audit menu items with their display labels
     */
    private function getSeoAuditMenuItems()
    {
        return [
            'seo_overview' => 'Overview',
            'seo_failures' => 'Failures',
            'seo_technical' => 'Technical SEO',
            'seo_onpage' => 'On-Page SEO',
            'seo_page_analysis' => 'Page Analysis Performance',
            'seo_performance' => 'Performance',
            'seo_ai_insights' => 'AI Insights',
            'seo_llm_prompts' => 'LLM Prompts Strategy',
            'seo_reports' => 'Reports',
            'seo_analytics' => 'Analytics',
            'seo_keywords' => 'Keywords',
            'seo_backlink_tracker' => 'SEO Backlink Tracker',
            'seo_content_strategy' => 'Content Strategy',
            'seo_implementation' => 'Implementation',
        ];
    }

    /**
     * Pillar menu items with their display labels
     */
    private function getPillarMenuItems()
    {
        return [
            'pillar_visibility_score' => 'Visibility Score',
            'pillar_visibility_trend' => 'Visibility Trend',
            'pillar_responses' => 'Responses',
            'pillar_competitors' => 'Competitors',
            'pillar_citations' => 'Citations',
            'pillar_google_analytics' => 'Google Analytics',
            'pillar_google_search_console' => 'Google Search Console',
            'pillar_chat_bot' => 'Chat Bot',
        ];
    }

    public function index(Request $request)
    {
        $month = $request->get('month');
        $carbonDate = $month && strlen($month) === 7 ? Carbon::createFromFormat('Y-m', $month) : Carbon::now();
        $selectedMonth = $carbonDate->format('F Y');
        $daysInMonth = $carbonDate->daysInMonth;
        $startOfMonth = $carbonDate->copy()->startOfMonth();
        $endOfMonth = $carbonDate->copy()->endOfMonth();

        $users = DB::connection('pgsql_second')
            ->table('users')
            ->leftJoin('brands', function ($join) {
                $join->on('brands.user_id', '=', 'users.id')
                     ->where('brands.is_self', '=', 1);
            })
            ->select(
                'users.id',
                'users.username',
                'users.email',
                'users.createdAt',
                'users.is_aeo_enabled',
                'brands.brand_name'
            )
            ->where('users.is_deleted', false)
            ->orderBy('users.id', 'desc')
            ->get();

        $totalBrands = DB::connection('pgsql_second')
            ->table('users')
            ->where('is_deleted', false)
            ->count();

        // OVERALL totals (across all users) for the selected month
        $totalPromptsOverall = DB::connection('pgsql_second')
            ->table('prompts')
            ->whereRaw('EXISTS (SELECT 1 FROM "users" u WHERE u.id = prompts."userId" AND u.is_deleted = false)')
            ->when($month && strlen($month) === 7, function ($query) use ($carbonDate) {
                return $query->where('createdAt', '<=', $carbonDate->copy()->endOfMonth());
            })
            ->count();

        $aiModels = DB::connection('pgsql_second')->table('ai_models')->get();

        // 1. Batch aggregate: Monthly tokens by engine across all active users
        $overallMonthlyTokens = DB::connection('pgsql_second')
            ->table('ai_responses')
            ->whereRaw('EXISTS (SELECT 1 FROM "brands" b JOIN "users" u ON b.user_id = u.id WHERE b.id = ai_responses.brand_id AND u.is_deleted = false)')
            ->whereBetween('createdAt', [$startOfMonth, $endOfMonth])
            ->select('engine', DB::raw('SUM(input_tokens) as total_input'), DB::raw('SUM(output_tokens) as total_output'))
            ->groupBy('engine')
            ->get()
            ->keyBy('engine');

        $promptsInMonth = null;
        $totalSpendingOverall = 0;
        $overallMonthlySpendingByEngine = [];

        foreach ($aiModels as $model) {
            $engines = match ($model->name) {
                'OpenAI' => ['openai'],
                'Perplexity' => ['perplexity'],
                'Grok' => ['xai'],
                'Gemini' => ['google', 'google_ai_overview'],
                'Claude' => ['anthropic'],
                default => [strtolower($model->name)],
            };

            $engineMonthlyInputTokens = 0;
            $engineMonthlyOutputTokens = 0;
            foreach ($engines as $eng) {
                if (isset($overallMonthlyTokens[$eng])) {
                    $engineMonthlyInputTokens += (float) $overallMonthlyTokens[$eng]->total_input;
                    $engineMonthlyOutputTokens += (float) $overallMonthlyTokens[$eng]->total_output;
                }
            }

            if ($engineMonthlyInputTokens == 0 && $engineMonthlyOutputTokens == 0) {
                if ($promptsInMonth === null) {
                    $promptsInMonth = DB::connection('pgsql_second')
                        ->table('prompts')
                        ->whereRaw('EXISTS (SELECT 1 FROM "users" u WHERE u.id = prompts."userId" AND u.is_deleted = false)')
                        ->whereBetween('createdAt', [$startOfMonth, $endOfMonth])
                        ->count();
                }
                $engineMonthlyInputTokens = ($model->max_tokens * 0.5) * $promptsInMonth;
                $engineMonthlyOutputTokens = ($model->max_tokens * 0.5) * $promptsInMonth;
            }

            $inputPrice = $model->input_price;
            $outputPrice = $model->output_price ?? 0.00;
            $engineMonthlyCost = round((($engineMonthlyInputTokens * $inputPrice) + ($engineMonthlyOutputTokens * $outputPrice)) / 1000000, 4);
            $totalSpendingOverall += $engineMonthlyCost;
            $overallMonthlySpendingByEngine[$model->name] = $engineMonthlyCost;
        }

        // 2. Batch aggregate: Total prompts per user
        $userTotalPromptsMap = DB::connection('pgsql_second')
            ->table('prompts')
            ->select('userId', DB::raw('COUNT(*) as total'))
            ->groupBy('userId')
            ->pluck('total', 'userId');

        // 3. Batch aggregate: Monthly prompts per user (fallback)
        $userMonthlyPromptsMap = DB::connection('pgsql_second')
            ->table('prompts')
            ->whereBetween('createdAt', [$startOfMonth, $endOfMonth])
            ->select('userId', DB::raw('COUNT(*) as total'))
            ->groupBy('userId')
            ->pluck('total', 'userId');

        // 4. Batch aggregate: Overall tokens per user & engine
        $userOverallTokensQuery = DB::connection('pgsql_second')
            ->table('ai_responses')
            ->join('brands', 'ai_responses.brand_id', '=', 'brands.id')
            ->select('brands.user_id', 'ai_responses.engine', DB::raw('SUM(ai_responses.input_tokens) as total_input'), DB::raw('SUM(ai_responses.output_tokens) as total_output'))
            ->when($month && strlen($month) === 7, function ($query) use ($endOfMonth) {
                return $query->where('ai_responses.createdAt', '<=', $endOfMonth);
            })
            ->groupBy('brands.user_id', 'ai_responses.engine')
            ->get();

        $userOverallTokensGrouped = [];
        foreach ($userOverallTokensQuery as $row) {
            $userOverallTokensGrouped[$row->user_id][$row->engine] = [
                'input'  => (float) $row->total_input,
                'output' => (float) $row->total_output,
            ];
        }

        // 5. Batch aggregate: Monthly tokens per user & engine
        $userMonthlyTokensQuery = DB::connection('pgsql_second')
            ->table('ai_responses')
            ->join('brands', 'ai_responses.brand_id', '=', 'brands.id')
            ->select('brands.user_id', 'ai_responses.engine', DB::raw('SUM(ai_responses.input_tokens) as total_input'), DB::raw('SUM(ai_responses.output_tokens) as total_output'))
            ->whereBetween('ai_responses.createdAt', [$startOfMonth, $endOfMonth])
            ->groupBy('brands.user_id', 'ai_responses.engine')
            ->get();

        $userMonthlyTokensGrouped = [];
        foreach ($userMonthlyTokensQuery as $row) {
            $userMonthlyTokensGrouped[$row->user_id][$row->engine] = [
                'input'  => (float) $row->total_input,
                'output' => (float) $row->total_output,
            ];
        }

        // Compute detailed spending for each user in memory without any DB queries
        foreach ($users as $user) {
            $totalprompts = $userTotalPromptsMap[$user->id] ?? 0;
            $aiSpending = [];
            $totalspends = 0;
            $monthlySpending = [];

            foreach ($aiModels as $model) {
                $engines = match ($model->name) {
                    'OpenAI' => ['openai'],
                    'Perplexity' => ['perplexity'],
                    'Grok' => ['xai'],
                    'Gemini' => ['google', 'google_ai_overview'],
                    'Claude' => ['anthropic'],
                    default => [strtolower($model->name)],
                };

                // 1. Overall spend
                $userOverallInputTokens = 0;
                $userOverallOutputTokens = 0;
                foreach ($engines as $eng) {
                    if (isset($userOverallTokensGrouped[$user->id][$eng])) {
                        $userOverallInputTokens += $userOverallTokensGrouped[$user->id][$eng]['input'];
                        $userOverallOutputTokens += $userOverallTokensGrouped[$user->id][$eng]['output'];
                    }
                }

                if ($userOverallInputTokens == 0 && $userOverallOutputTokens == 0) {
                    $userOverallInputTokens = ($model->max_tokens * 0.5) * $totalprompts;
                    $userOverallOutputTokens = ($model->max_tokens * 0.5) * $totalprompts;
                }

                $inputPrice = $model->input_price;
                $outputPrice = $model->output_price ?? 0.00;
                $engineCost = (($userOverallInputTokens * $inputPrice) + ($userOverallOutputTokens * $outputPrice)) / 1000000;
                $aiSpending[$model->name] = round($engineCost, 4);
                $totalspends += $engineCost;

                // 2. Monthly spend
                $userMonthlyInputTokens = 0;
                $userMonthlyOutputTokens = 0;
                foreach ($engines as $eng) {
                    if (isset($userMonthlyTokensGrouped[$user->id][$eng])) {
                        $userMonthlyInputTokens += $userMonthlyTokensGrouped[$user->id][$eng]['input'];
                        $userMonthlyOutputTokens += $userMonthlyTokensGrouped[$user->id][$eng]['output'];
                    }
                }

                if ($userMonthlyInputTokens == 0 && $userMonthlyOutputTokens == 0) {
                    $userPromptsInMonth = $userMonthlyPromptsMap[$user->id] ?? 0;
                    $userMonthlyInputTokens = ($model->max_tokens * 0.5) * $userPromptsInMonth;
                    $userMonthlyOutputTokens = ($model->max_tokens * 0.5) * $userPromptsInMonth;
                }

                $monthlyCost = (($userMonthlyInputTokens * $inputPrice) + ($userMonthlyOutputTokens * $outputPrice)) / 1000000;
                $monthlySpending[$model->name] = round($monthlyCost, 4);
            }

            $user->totalprompts = $totalprompts;
            $user->totalspends = round($totalspends, 4);
            $user->aiSpending = $aiSpending;
            $user->monthlySpending = round(array_sum($monthlySpending), 4);
        }

        return view('admin.customers.index', compact('users', 'totalBrands', 'totalPromptsOverall', 'totalSpendingOverall', 'overallMonthlySpendingByEngine', 'daysInMonth', 'selectedMonth'));
    }

    public function exportExcel()
    {
        return Excel::download(new SelfBrandsExport, 'self_brands.xlsx');
    }

    public function create()
    {
        $seo_status = null;
        $seoAuditMenuItems = $this->getSeoAuditMenuItems();
        $pillarMenuItems = $this->getPillarMenuItems();
        return view('admin.customers.create', compact('seo_status', 'seoAuditMenuItems', 'pillarMenuItems'));
    }

    public function store(Request $request)
    {
        DB::connection('pgsql_second')->table('users')->insert([
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'isVerified' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        $user_id = DB::connection('pgsql_second')->getPdo()->lastInsertId();

        $seo_data = $this->getSeoStatusDefaults();
        $has_seo_changes = false;

        // Process checkbox fields
        foreach ($seo_data as $key => $default) {
            if ($request->boolean($key)) {
                $seo_data[$key] = true;
                $has_seo_changes = true;
            }
        }

        // Process order fields - build JSON arrays for SEO Audit and Pillar orders
        $seo_audit_order = [];
        $pillar_order = [];

        foreach (array_keys($this->getSeoAuditMenuItems()) as $key) {
            $orderKey = $key . '_order';
            if ($request->filled($orderKey)) {
                $seo_audit_order[$key] = (int) $request->input($orderKey);
            }
        }

        foreach (array_keys($this->getPillarMenuItems()) as $key) {
            $orderKey = $key . '_order';
            if ($request->filled($orderKey)) {
                $pillar_order[$key] = (int) $request->input($orderKey);
            }
        }

        // Store order data as JSON
        if (!empty($seo_audit_order)) {
            $seo_data['seo_audit_order'] = json_encode($seo_audit_order);
        }
        if (!empty($pillar_order)) {
            $seo_data['pillar_order'] = json_encode($pillar_order);
        }

        if ($has_seo_changes || !empty($seo_audit_order) || !empty($pillar_order)) {
            DB::connection('pgsql_second')->table('brand_permissions')->updateOrInsert(
                ['user_id' => $user_id],
                array_merge(['created_at' => now(), 'updated_at' => now()], $seo_data)
            );
        }

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    public function show(Request $request, string $id)
    {
        $month = $request->get('month');
        $carbonDate = $month && strlen($month) === 7 ? Carbon::createFromFormat('Y-m', $month) : Carbon::now();
        $selectedMonth = $carbonDate->format('F Y');
        $daysInMonth = $carbonDate->daysInMonth;

        $user = DB::connection('pgsql_second')
            ->table('users')
            ->where('id', $id)
            ->first();

        $totalprompts = DB::connection('pgsql_second')
            ->table('prompts')
            ->where('userId', $id)
            ->count(); 

        $competitors = DB::connection('pgsql_second')
            ->table('brands')
            ->where('user_id', $id)
            ->where('is_self', 0)
            ->get();

        // Dynamic engine data from AI models to compute spending
        $aiModels = DB::connection('pgsql_second')->table('ai_models')->get();
        $aiSpending = [];
        $totalspends = 0;
        $monthlySpending = [];
        foreach ($aiModels as $model) {
            $enginePrompts = $totalprompts;
            // Dynamic total_tokens
            $engineMaxTokens = DB::connection('pgsql_second')
                ->table('visibility_logs')
                ->where('user_id', $id)
                ->where('platform', $model->name)
                ->when($month && strlen($month) === 7, function ($query) use ($carbonDate) {
                    return $query->where('createdAt', '<=', $carbonDate->copy()->endOfMonth());
                })
                ->sum('total_tokens') ?: $model->max_tokens; // Fallback to max_tokens * total prompts if no visibility logs
            $inputPrice = $model->input_price;
            $engineCost = ($engineMaxTokens * $enginePrompts * $inputPrice) / 1000000;
            $aiSpending[$model->name] = round($engineCost, 4);
            $totalspends += $engineCost;
            // Projected monthly cost based on daily average
            $monthlyCost = ($engineMaxTokens * $totalprompts * $inputPrice * $daysInMonth) / 1000000;
            $monthlySpending[$model->name] = round($monthlyCost, 4);
        }
        $user->monthlySpending = round(array_sum($monthlySpending), 4);
        return view('admin.customers.show', compact('user', 'totalspends', 'totalprompts', 'competitors', 'aiSpending', 'monthlySpending', 'daysInMonth', 'selectedMonth'));
    }

    public function edit(string $id)
    {
        $user = DB::connection('pgsql_second')
            ->table('users')
            ->where('id', $id)
            ->first();

        $seo_status = DB::connection('pgsql_second')
            ->table('brand_permissions')
            ->where('user_id', $id)
            ->first();

        if (!$seo_status) {
            $seo_status = (object) $this->getSeoStatusDefaults();
        } else {
            // Fill missing fields with defaults
            $defaults = $this->getSeoStatusDefaults();
            foreach ($defaults as $key => $value) {
                if (!isset($seo_status->{$key})) {
                    $seo_status->{$key} = $value;
                }
            }

            // Decode JSON order fields and add to seo_status object for view access
            if (isset($seo_status->seo_audit_order) && is_string($seo_status->seo_audit_order)) {
                $seoAuditOrder = json_decode($seo_status->seo_audit_order, true);
                if (is_array($seoAuditOrder)) {
                    foreach ($seoAuditOrder as $key => $order) {
                        $seo_status->{$key . '_order'} = $order;
                    }
                }
            }
            if (isset($seo_status->pillar_order) && is_string($seo_status->pillar_order)) {
                $pillarOrder = json_decode($seo_status->pillar_order, true);
                if (is_array($pillarOrder)) {
                    foreach ($pillarOrder as $key => $order) {
                        $seo_status->{$key . '_order'} = $order;
                    }
                }
            }
        }

        $seoAuditMenuItems = $this->getSeoAuditMenuItems();
        $pillarMenuItems = $this->getPillarMenuItems();
        return view('admin.customers.edit', compact('user', 'seo_status', 'seoAuditMenuItems', 'pillarMenuItems'));
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'username'  => $request->username,
            'email'     => $request->email,
            'updatedAt' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::connection('pgsql_second')
            ->table('users')
            ->where('id', $id)
            ->update($data);

        // Update SEO status
        $seo_data = $this->getSeoStatusDefaults();
        $has_seo_changes = false;

        // Process checkbox fields
        foreach ($seo_data as $key => $default) {
            if ($request->boolean($key)) {
                $seo_data[$key] = true;
                $has_seo_changes = true;
            }
        }

        // Process order fields - build JSON arrays for SEO Audit and Pillar orders
        $seo_audit_order = [];
        $pillar_order = [];

        foreach (array_keys($this->getSeoAuditMenuItems()) as $key) {
            $orderKey = $key . '_order';
            if ($request->filled($orderKey)) {
                $seo_audit_order[$key] = (int) $request->input($orderKey);
            }
        }

        foreach (array_keys($this->getPillarMenuItems()) as $key) {
            $orderKey = $key . '_order';
            if ($request->filled($orderKey)) {
                $pillar_order[$key] = (int) $request->input($orderKey);
            }
        }

        // Store order data as JSON
        if (!empty($seo_audit_order)) {
            $seo_data['seo_audit_order'] = json_encode($seo_audit_order);
        }
        if (!empty($pillar_order)) {
            $seo_data['pillar_order'] = json_encode($pillar_order);
        }

        if ($has_seo_changes || !empty($seo_audit_order) || !empty($pillar_order)) {
            DB::connection('pgsql_second')->table('brand_permissions')->updateOrInsert(
                ['user_id' => $id],
                array_merge(['updated_at' => now()], $seo_data)
            );
        }

        return redirect()->route('admin.brands.index')->with('success', 'User updated successfully!');
    }

    public function toggleAeo($id)
    {
        try {
            $user = DB::connection('pgsql_second')
                ->table('users')
                ->where('id', $id)
                ->first();

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            $newValue = $user->is_aeo_enabled ? false : true;

            DB::connection('pgsql_second')
                ->table('users')
                ->where('id', $id)
                ->update([
                    'is_aeo_enabled' => $newValue,
                ]);

            $statusText = $newValue ? 'enabled' : 'disabled';
            return redirect()->back()->with('success', "AEO option {$statusText} successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::connection('pgsql_second')
                ->table('users')
                ->where('id', $id)
                ->update([
                    'is_deleted' => true,
                ]);

            return redirect()->back()->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
