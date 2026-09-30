<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    protected $conn = 'pgsql_second';

    /**
     * Parse features input into JSON format.
     */
    private function formatFeatures($input): string
    {
        if (empty($input)) {
            return json_encode([]);
        }

        if (is_array($input)) {
            return json_encode(array_values(array_filter(array_map('trim', $input))));
        }

        // Split by line breaks if given as textarea
        $lines = preg_split('/\r\n|\r|\n/', (string) $input);
        $features = [];
        foreach ($lines as $line) {
            $cleaned = trim($line, " \t\n\r\0\x0B-•*");
            if (!empty($cleaned)) {
                $features[] = $cleaned;
            }
        }

        return json_encode($features);
    }

    /**
     * Save data payload to PostgreSQL.
     */
    private function savePlan(array $data, ?int $id = null): int
    {
        if ($id) {
            $data['updated_at'] = now();
            DB::connection($this->conn)->table('subscription_plans')->where('id', $id)->update($data);
            return $id;
        }

        $data['created_at'] = now();
        $data['updated_at'] = now();
        return DB::connection($this->conn)->table('subscription_plans')->insertGetId($data);
    }

    public function index()
    {
        $plans = DB::connection('pgsql_second')
            ->table('subscription_plans')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Decode features for view consumption
        foreach ($plans as $plan) {
            $plan->features_array = [];
            if (!empty($plan->features)) {
                $decoded = json_decode($plan->features, true);
                if (is_array($decoded)) {
                    $plan->features_array = $decoded;
                }
            }
        }

        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'billing_period'   => 'required|string|max:50',
            'tagline'          => 'nullable|string|max:255',
            'badge'            => 'nullable|string|max:100',
            'button_text'      => 'nullable|string|max:100',
            'button_link'      => 'nullable|string|max:500',
            'llm_prompts'      => 'required|integer|min:0',
            'keyword_ranking'  => 'required|string|max:100',
            'blog_posts'       => 'required|string|max:100',
            'backlink_checks'  => 'required|string|max:100',
            'new_pages'        => 'required|string|max:100',
            'ai_engines_count' => 'required|integer|min:1',
            'sort_order'       => 'nullable|integer',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (DB::connection('pgsql_second')->table('subscription_plans')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $data = [
            'name'              => $request->name,
            'slug'              => $slug,
            'tagline'           => $request->tagline,
            'price'             => (float) $request->price,
            'currency'          => $request->currency ?: '$',
            'billing_period'    => $request->billing_period ?: 'mo',
            'badge'             => $request->badge ?: null,
            'button_text'       => $request->button_text ?: 'Start Now',
            'button_link'       => $request->button_link ?: '#',
            'features'          => $this->formatFeatures($request->features),
            'llm_prompts'       => $request->llm_prompts ? (int) $request->llm_prompts : null,
            'keyword_ranking'   => $request->keyword_ranking ?: null,
            'blog_posts'        => $request->blog_posts ?: null,
            'backlink_checks'   => $request->backlink_checks ?: null,
            'new_pages'         => $request->new_pages ?: null,
            'ai_engines_count'  => (int) ($request->ai_engines_count ?: 6),
            'is_popular'        => $request->boolean('is_popular'),
            'is_active'         => $request->boolean('is_active'),
            'sort_order'        => (int) ($request->sort_order ?: 0),
        ];

        $this->savePlan($data);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription Plan created successfully!');
    }

    public function show($id)
    {
        return redirect()->route('admin.subscription-plans.edit', $id);
    }

    public function edit($id)
    {
        $plan = DB::connection($this->conn)
            ->table('subscription_plans')
            ->where('id', $id)
            ->first();

        if (!$plan) {
            return redirect()->route('admin.subscription-plans.index')->with('error', 'Plan not found.');
        }

        $plan->features_array = [];
        if (!empty($plan->features)) {
            $decoded = json_decode($plan->features, true);
            if (is_array($decoded)) {
                $plan->features_array = $decoded;
            }
        }

        $plan->features_text = implode("\n", $plan->features_array);

        return view('admin.subscription-plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'billing_period'   => 'required|string|max:50',
            'tagline'          => 'nullable|string|max:255',
            'badge'            => 'nullable|string|max:100',
            'button_text'      => 'nullable|string|max:100',
            'button_link'      => 'nullable|string|max:500',
            'llm_prompts'      => 'required|integer|min:0',
            'keyword_ranking'  => 'required|string|max:100',
            'blog_posts'       => 'required|string|max:100',
            'backlink_checks'  => 'required|string|max:100',
            'new_pages'        => 'required|string|max:100',
            'ai_engines_count' => 'required|integer|min:1',
            'sort_order'       => 'nullable|integer',
        ]);

        $data = [
            'name'              => $request->name,
            'tagline'           => $request->tagline,
            'price'             => (float) $request->price,
            'currency'          => $request->currency ?: '$',
            'billing_period'    => $request->billing_period ?: 'mo',
            'badge'             => $request->badge ?: null,
            'button_text'       => $request->button_text ?: 'Start Now',
            'button_link'       => $request->button_link ?: '#',
            'features'          => $this->formatFeatures($request->features),
            'llm_prompts'       => $request->llm_prompts ? (int) $request->llm_prompts : null,
            'keyword_ranking'   => $request->keyword_ranking ?: null,
            'blog_posts'        => $request->blog_posts ?: null,
            'backlink_checks'   => $request->backlink_checks ?: null,
            'new_pages'         => $request->new_pages ?: null,
            'ai_engines_count'  => (int) ($request->ai_engines_count ?: 6),
            'is_popular'        => $request->boolean('is_popular'),
            'is_active'         => $request->boolean('is_active'),
            'sort_order'        => (int) ($request->sort_order ?: 0),
        ];

        $this->savePlan($data, (int) $id);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription Plan updated successfully!');
    }

    public function destroy($id)
    {
        DB::connection($this->conn)->table('subscription_plans')->where('id', $id)->delete();

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription Plan deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $plan = DB::connection($this->conn)->table('subscription_plans')->where('id', $id)->first();
        if ($plan) {
            $newStatus = !$plan->is_active;
            DB::connection($this->conn)->table('subscription_plans')->where('id', $id)->update([
                'is_active' => $newStatus,
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'is_active' => $newStatus]);
        }

        return response()->json(['success' => false, 'message' => 'Plan not found'], 404);
    }
}
