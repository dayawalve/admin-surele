<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandPermissionsController extends Controller
{
    public function index()
    {
        $users = DB::connection('pgsql_second')
            ->table('users')
            ->leftJoin('brands', function ($join) {
                $join->on('brands.user_id', '=', 'users.id')
                     ->where('brands.is_self', '=', 1);
            })
            ->leftJoin('brand_permissions', 'brand_permissions.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                'users.email',
                'brands.brand_name',
                'brand_permissions.has_seo',
                'brand_permissions.has_aeo',
                'brand_permissions.has_gbp',
                'brand_permissions.has_content_engines',
                'brand_permissions.has_insights',
                'brand_permissions.has_analytics_suite',
                'brand_permissions.has_heatmap',
                'brand_permissions.has_monitoring',
                'brand_permissions.has_competitive_intel',
                'brand_permissions.disabled_routes'
            )
            ->where('users.is_deleted', false)
            ->orderBy('users.id', 'desc')
            ->get();

        return view('admin.brand_permissions.index', compact('users'));
    }

    public function edit(string $id)
    {
        $user = DB::connection('pgsql_second')
            ->table('users')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()->route('admin.brand_permissions.index')->with('error', 'User not found.');
        }

        $brand = DB::connection('pgsql_second')
            ->table('brands')
            ->where('user_id', $id)
            ->where('is_self', 1)
            ->first();

        $permissions = DB::connection('pgsql_second')
            ->table('brand_permissions')
            ->where('user_id', $id)
            ->first();

        // Decode disabled_routes if it is stringified JSON
        if ($permissions && isset($permissions->disabled_routes)) {
            if (is_string($permissions->disabled_routes)) {
                $permissions->disabled_routes = json_decode($permissions->disabled_routes, true) ?: [];
            }
        } else {
            if ($permissions) {
                $permissions->disabled_routes = [];
            }
        }

        return view('admin.brand_permissions.edit', compact('user', 'brand', 'permissions'));
    }

    public function update(Request $request, string $id)
    {
        $enabledRoutes = $request->input('enabled_routes');
        if (is_array($enabledRoutes)) {
            $allRoutes = [
                '/dashboard/seo-overview', '/dashboard/seo-scores', '/dashboard/crawl-data', '/dashboard/seo-errors',
                '/dashboard/canonical', '/dashboard/site-analysis', '/dashboard/technical-issues', '/dashboard/schema-analysis',
                '/dashboard/depth-analysis', '/dashboard/meta-tags', '/dashboard/headings', '/dashboard/content-analysis',
                '/dashboard/image-alt', '/dashboard/page-analysis', '/dashboard/performance', '/dashboard/keyword-ranking',
                '/dashboard/seo-backlink-tracker', '/dashboard/seo-failures', '/dashboard/fix-status',
                '/dashboard/seo-recommendations', '/dashboard/seo-faqs', '/dashboard/llm-prompts', '/dashboard/ai-visibility',
                '/dashboard/ai-citation', '/dashboard/competitors', '/dashboard/aeo-sentiment', '/dashboard/aeo-scores',
                '/dashboard/aeo-trend-analysis', '/dashboard/aeo-internal-links', '/dashboard/share-of-voice',
                '/dashboard/googlebusinessprofile', '/dashboard/gbp-profile-audit', '/dashboard/gbp-analytics',
                '/dashboard/gbp-reviews', '/dashboard/gbp-ai-insights', '/dashboard/gbp-pages', '/dashboard/gbp-post-planner',
                '/dashboard/gbp-ai-replies', '/dashboard/gbp-action', '/dashboard/gbp-rankings', '/dashboard/gbp-competitors',
                '/dashboard/gbp-entity', '/dashboard/gbp-report', '/dashboard/gbp-spam-check', '/dashboard/gbp-geo-grid',
                '/dashboard/content-suggestions', '/dashboard/brand-intelligence', '/dashboard/blog-ideas',
                '/dashboard/six-month-plan', '/dashboard/backlinks', '/dashboard/internal-linking', '/dashboard/new-page-suggestions',
                '/dashboard/scorecard', '/dashboard/generated-files', '/dashboard/Monthlyreportpage', '/dashboard/audit-excel', '/dashboard/deck-report-gamma',
                '/dashboard/analytics-dashboard', '/dashboard/audit-summary', '/dashboard/keyword-planner', '/dashboard/keywords',
                '/dashboard/keyword-mapping', '/dashboard/googleanalytics', '/dashboard/chatbot', '/dashboard/googlesearchconsole', '/dashboard/indexing',
                '/dashboard/heatmap', '/dashboard/uptimemonitoring', '/dashboard/ai-competitive-intelligence',
                '/dashboard/ai-competitive-intelligence/dashboard'
            ];
            $disabledRoutes = array_values(array_diff($allRoutes, $enabledRoutes));
        } else {
            $disabledRoutesInput = $request->input('disabled_routes');
            $disabledRoutes = [];
            if (is_array($disabledRoutesInput)) {
                $disabledRoutes = $disabledRoutesInput;
            } elseif (is_string($disabledRoutesInput) && !empty($disabledRoutesInput)) {
                $disabledRoutes = array_filter(array_map('trim', explode(',', $disabledRoutesInput)));
            }
        }

        // We prepare disabled_routes value in correct format for JSONB/JSON column
        $disabledRoutesJson = json_encode(array_values($disabledRoutes));

        DB::connection('pgsql_second')->table('brand_permissions')->updateOrInsert(
            ['user_id' => $id],
            [
                'has_seo' => $request->has('has_seo'),
                'has_aeo' => $request->has('has_aeo'),
                'has_gbp' => $request->has('has_gbp'),
                'has_content_engines' => $request->has('has_content_engines'),
                'has_insights' => $request->has('has_insights'),
                'has_analytics_suite' => $request->has('has_analytics_suite'),
                'has_heatmap' => $request->has('has_heatmap'),
                'has_monitoring' => $request->has('has_monitoring'),
                'has_competitive_intel' => $request->has('has_competitive_intel'),
                'disabled_routes' => $disabledRoutesJson,
                'createdAt' => now(),
                'updatedAt' => now()
            ]
        );

        return redirect()->route('admin.brand_permissions.index')
            ->with('success', 'Brand permissions updated successfully!');
    }
}
