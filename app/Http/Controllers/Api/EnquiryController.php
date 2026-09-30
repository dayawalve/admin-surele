<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    /**
     * Store a newly created enquiry from the frontend form.
     */
    public function store(Request $request)
    {
        // Flexible validation supporting common naming conventions
        $validator = Validator::make($request->all(), [
            'name'           => 'nullable|string|max:255',
            'full_name'      => 'nullable|string|max:255',
            'company'        => 'nullable|string|max:255',
            'company_name'   => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'whatsapp'       => 'nullable|string|max:50',
            'phone_whatsapp' => 'nullable|string|max:50',
            'product'        => 'nullable|string|max:255',
            'size_qty'       => 'nullable|string|max:100',
            'size'           => 'nullable|string|max:100',
            'qty'            => 'nullable|string|max:100',
            'quantity'       => 'nullable|string|max:100',
            'message'        => 'nullable|string|max:5000',
            'source'         => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'success' => false,
                'message' => 'Validation error. Please verify the submitted data.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Resolve input field aliases from frontend
        $name = $request->input('name') 
            ?? $request->input('full_name') 
            ?? 'Website Visitor';

        $company = $request->input('company') 
            ?? $request->input('company_name');

        $email = $request->input('email');

        $phone = $request->input('phone') 
            ?? $request->input('whatsapp') 
            ?? $request->input('phone_whatsapp');

        $product = $request->input('product');

        $sizeQty = $request->input('size_qty') 
            ?? $request->input('size') 
            ?? $request->input('qty') 
            ?? $request->input('quantity');

        $message = $request->input('message');

        $source = $request->input('source') ?? 'Website Form';

        // Check that at least some data was provided
        if (empty($name) && empty($email) && empty($phone) && empty($message)) {
            return response()->json([
                'status'  => false,
                'success' => false,
                'message' => 'Please provide at least a name, email or phone number.',
            ], 422);
        }

        // Create enquiry record
        $enquiry = Enquiry::create([
            'name'       => $name,
            'company'    => $company,
            'email'      => $email,
            'phone'      => $phone,
            'product'    => $product,
            'size_qty'   => $sizeQty,
            'message'    => $message,
            'status'     => 'New',
            'source'     => $source,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status'  => true,
            'success' => true,
            'message' => 'Enquiry submitted successfully! Our team will get back to you shortly.',
            'data'    => $enquiry,
        ], 201);
    }
}
