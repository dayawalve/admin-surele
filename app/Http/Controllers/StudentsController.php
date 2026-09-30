<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\College;
use App\Models\TrainingProgram;
use App\Models\StudentPayment;
use App\Models\CompanySetting;
use App\Models\BusinessDeveloper;
use App\Models\OtherRefer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class StudentsController extends Controller
{

    private function generateUniqueReferId(): string
    {
        do {
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
            $numbers = rand(100, 999);
            $referId = $letters . $numbers;
        } while (Students::where('refer_id', $referId)->exists());

        return $referId;
    }

    public function index(Request $request)
    {
        $query = Students::with(['trainingProgram', 'college'])
            ->where('is_deleted', 0);

        if ($request->filled('training_program_id')) {
            $query->where('training_program_id', $request->training_program_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $data = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $trainingPrograms = TrainingProgram::where('is_deleted', 0)->get();

        return view('admin.students.index', compact('data', 'trainingPrograms'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


    public function create()
    {
        $data = College::where('is_active', 1)->where('is_deleted', 0)->get();
        $trainingPrograms = TrainingProgram::where('status', 'Active')->get();
        $Students = Students::where('is_deleted', 0)->get();
        $BusinessDeveloper = BusinessDeveloper::where('is_active', 1)->get();
        return view('admin.students.create', compact('data', 'trainingPrograms', 'Students', 'BusinessDeveloper'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'fname'   => 'required|string|max:255',
                'lname'   => 'required|string|max:255',
                'email'   => 'required|email|unique:students,email',
                'phone'   => 'required|string|max:20',
                'college' => 'required',
                'training_program_id' => 'required',
                'enrollment_type' => 'required',
                'other_refer_name' => 'required_if:refer_by,0'
            ],
            [
                'email.unique' => 'This email is already registered with us.',
            ]
        );

        $student = new Students();
        $student->refer_id = $this->generateUniqueReferId();
        $student->fname = $request->fname;
        $student->lname = $request->lname;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->college_id = $request->college;
        $student->training_program_id = $request->training_program_id;
        $student->enrollment_type = $request->enrollment_type;

        $student->refer_by_id = ($request->refer_by == 0) ? null : $request->refer_by;

        $student->bd_id = $request->business_developer_id ?? null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/students/photo'), $imageName);
            $student->image = 'public/storage/students/photo/' . $imageName;
        }

        $student->save();
        
        if ($request->refer_by == 0 && $request->filled('other_refer_name')) {
            OtherRefer::create([
                'student_id' => $student->id,
                'name'       => $request->other_refer_name,
            ]);
        }

        if ($request->enrollment_type === 'instant' && $request->filled('paid_amount')) {

            $payment = new StudentPayment();
            $payment->student_id = $student->id;
            $payment->training_program_id = $request->training_program_id;
            $payment->amount = $request->paid_amount;
            $payment->payment_mode = $request->payment_mode;
            $payment->payment_date = now();
            $payment->remarks = 'Initial payment during instant enrollment';

            if ($request->hasFile('payment_receipt')) {
                $receiptName = time() . '.' . $request->payment_receipt->getClientOriginalExtension();
                $request->payment_receipt->move(
                    public_path('storage/students/payment_receipt'),
                    $receiptName
                );
                $payment->payment_receipt = 'public/storage/students/payment_receipt/' . $receiptName;
            }

            $payment->save();
        }

        $paymentData = null;

        if ($request->enrollment_type === 'instant' && $request->filled('paid_amount')) {
            $paymentData = [
                'amount' => $request->paid_amount,
                'mode'   => $request->payment_mode,
                'date'   => now()->format('d M Y'),
            ];
        }

        Mail::send('mail-templates.student-enroll', compact('student', 'paymentData'),
            function ($message) use ($student, $request) {
                $subject = $request->enrollment_type === 'instant'
                    ? 'Enrollment & Payment Confirmation - Surele'
                    : 'Enrollment Confirmation - Surele';

                $message->to($student->email)->subject($subject);
            }
        );

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }


    public function show($id)
    {
        $data = Students::with([
            'trainingProgram',
            'college',
            'referredBy',
            'referrals',
            'otherRefer', 
            'payments' => function ($q) {
                $q->orderBy('payment_date', 'desc');
            }
        ])->findOrFail($id);

        return view('admin.students.show', compact('data'));
    }

    // public function edit($id)
    // {
    //     $data = Students::with([
    //         'trainingProgram',
    //         'college',
    //         'payments' => function ($q) {
    //             $q->orderBy('payment_date', 'desc');
    //         }
    //     ])->findOrFail($id);

    //     $lastPayment = $data->payments->first();
    //     $trainingPrograms = TrainingProgram::where('is_deleted', 0)->get();
    //     $college = College::where('is_active', 1)->where('is_deleted', 0)->get();
    //     $Students = Students::where('is_deleted', 0)->where('id', '!=', $id)->get();
    //     $BusinessDeveloper = BusinessDeveloper::where('is_active', 1)->get();

    //     return view('admin.students.edit', compact(
    //         'data',
    //         'trainingPrograms',
    //         'lastPayment',
    //         'college',
    //         'Students',
    //         'BusinessDeveloper'
    //     ));
    // }


    // public function update(Request $request, $id)
    // {
    //     $student = Students::findOrFail($id);

    //     if ($student->refer_id === null) {
    //         $student->refer_id = $this->generateUniqueReferId();
    //     }

    //     $student->fname                = $request->fname;
    //     $student->lname                = $request->lname;
    //     $student->email                = $request->email;
    //     $student->phone                = $request->phone;
    //     $student->college_id            = $request->college;
    //     $student->training_program_id   = $request->training_program_id;
    //     $student->enrollment_type       = $request->enrollment_type;
    //     $student->refer_by_id           = $request->refer_by ?? null;
    //     $student->bd_id                 = $request->business_developer_id ?? null;

    //     if ($request->hasFile('image')) {
    //         if (!empty($student->image) && file_exists(public_path($student->image))) {
    //             unlink(public_path($student->image));
    //         }

    //         $imageName = time() . '.' . $request->image->getClientOriginalExtension();
    //         $request->image->move(public_path('storage/students/photo'), $imageName);
    //         $student->image = 'public/storage/students/photo/' . $imageName;
    //     }

    //     $student->save();

    //     if (
    //         $request->enrollment_type === 'instant' &&
    //         $request->filled('paid_amount') &&
    //         $request->paid_amount > 0
    //     ) {
    //         $payment = StudentPayment::where('student_id', $student->id)
    //             ->where('training_program_id', $student->training_program_id)
    //             ->orderBy('payment_date', 'desc')
    //             ->first();

    //         if ($payment) {

    //             $payment->amount       = $request->paid_amount;
    //             $payment->payment_mode = $request->payment_mode;
    //             $payment->payment_date = now();
    //             $payment->remarks      = 'Payment updated from edit page';

    //         }
    //         else {

    //             $payment = new StudentPayment();
    //             $payment->student_id          = $student->id;
    //             $payment->training_program_id = $student->training_program_id;
    //             $payment->amount              = $request->paid_amount;
    //             $payment->payment_mode        = $request->payment_mode;
    //             $payment->payment_date        = now();
    //             $payment->remarks             = 'Payment added after free trial enrollment';
    //         }

    //         if ($request->hasFile('payment_receipt')) {
    //             if (!empty($payment->payment_receipt) && file_exists(public_path($payment->payment_receipt))) {
    //                 unlink(public_path($payment->payment_receipt));
    //             }
    //             $receiptName = time() . '.' . $request->payment_receipt->getClientOriginalExtension();
    //             $request->payment_receipt->move(
    //                 public_path('storage/students/payment_receipt'),
    //                 $receiptName
    //             );
    //             $payment->payment_receipt = 'public/storage/students/payment_receipt/' . $receiptName;
    //         }

    //         $payment->save();
    //     }

    //     return redirect()
    //         ->route('admin.students.index')
    //         ->with('success', 'Student record updated successfully.');
    // }


    public function edit($id)
    {
        $data = Students::with([
            'trainingProgram',
            'college',
            'otherRefer',   // ✅ ADD THIS
            'payments' => function ($q) {
                $q->orderBy('payment_date', 'desc');
            }
        ])->findOrFail($id);

        $lastPayment = $data->payments->first();
        $trainingPrograms = TrainingProgram::where('is_deleted', 0)->get();
        $college = College::where('is_active', 1)->where('is_deleted', 0)->get();
        $Students = Students::where('is_deleted', 0)->where('id', '!=', $id)->get();
        $BusinessDeveloper = BusinessDeveloper::where('is_active', 1)->get();

        return view('admin.students.edit', compact(
            'data',
            'trainingPrograms',
            'lastPayment',
            'college',
            'Students',
            'BusinessDeveloper'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'fname'   => 'required|string|max:255',
            'lname'   => 'required|string|max:255',
            'email'   => 'required|email|unique:students,email,' . $id,
            'phone'   => 'required|string|max:20',
            'college' => 'required',
            'training_program_id' => 'required',
            'enrollment_type' => 'required',
            'other_refer_name' => 'required_if:refer_by,0'
        ]);

        $student = Students::findOrFail($id);

        if ($student->refer_id === null) {
            $student->refer_id = $this->generateUniqueReferId();
        }

        $student->fname                 = $request->fname;
        $student->lname                 = $request->lname;
        $student->email                 = $request->email;
        $student->phone                 = $request->phone;
        $student->college_id            = $request->college;
        $student->training_program_id   = $request->training_program_id;
        $student->enrollment_type       = $request->enrollment_type;

        $student->refer_by_id = ($request->refer_by == 0) ? null : $request->refer_by;

        $student->bd_id = $request->business_developer_id ?? null;

        // ✅ Image Update
        if ($request->hasFile('image')) {
            if (!empty($student->image) && file_exists(public_path($student->image))) {
                unlink(public_path($student->image));
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/students/photo'), $imageName);
            $student->image = 'public/storage/students/photo/' . $imageName;
        }

        $student->save();

        // ✅ Handle Other Refer Save / Update / Delete
        if ($request->refer_by == 0 && $request->filled('other_refer_name')) {

            OtherRefer::updateOrCreate(
                ['student_id' => $student->id],
                ['name' => $request->other_refer_name]
            );

        } else {
            // If switched from Other to Student — remove old entry
            OtherRefer::where('student_id', $student->id)->delete();
        }

        // ✅ Payment Handling
        if (
            $request->enrollment_type === 'instant' &&
            $request->filled('paid_amount') &&
            $request->paid_amount > 0
        ) {

            $payment = StudentPayment::where('student_id', $student->id)
                ->where('training_program_id', $student->training_program_id)
                ->orderBy('payment_date', 'desc')
                ->first();

            if ($payment) {
                $payment->amount       = $request->paid_amount;
                $payment->payment_mode = $request->payment_mode;
                $payment->payment_date = now();
                $payment->remarks      = 'Payment updated from edit page';
            } else {
                $payment = new StudentPayment();
                $payment->student_id           = $student->id;
                $payment->training_program_id  = $student->training_program_id;
                $payment->amount               = $request->paid_amount;
                $payment->payment_mode         = $request->payment_mode;
                $payment->payment_date         = now();
                $payment->remarks              = 'Payment added after free trial enrollment';
            }

            // Receipt Upload
            if ($request->hasFile('payment_receipt')) {
                if (!empty($payment->payment_receipt) && file_exists(public_path($payment->payment_receipt))) {
                    unlink(public_path($payment->payment_receipt));
                }

                $receiptName = time() . '.' . $request->payment_receipt->getClientOriginalExtension();
                $request->payment_receipt->move(
                    public_path('storage/students/payment_receipt'),
                    $receiptName
                );
                $payment->payment_receipt = 'public/storage/students/payment_receipt/' . $receiptName;
            }

            $payment->save();
        }

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student record updated successfully.');
    }

    public function destroy($id)
    {
        $user = Students::find($id);
        if ($user->is_deleted == 0) {
            $user->is_deleted = 1;
            $msg = 'Students deleted successfully';
        } else {
            $user->is_deleted = 0;
            $msg = 'Students restore successfully';
        }
        $user->update();
        return redirect()->route('admin.students.index')->with('success', $msg);
    }

    public function status($id)
    {
        $student = Students::findOrFail($id);

        $student->is_active = $student->is_active == 1 ? 0 : 1;
        $student->save();

        $message = $student->is_active ? 'Student activated successfully.' : 'Student deactivated successfully.';

        return redirect()->route('admin.students.index')->with('success', $message);
    }

    // public function addPayment(Request $request, $id)
    // {
    //     $student = Students::with('trainingProgram', 'payments')->findOrFail($id);

    //     $totalPaid = $student->payments->sum('amount');
    //     $totalFees = $student->trainingProgram->fees;
    //     $pending   = $totalFees - $totalPaid;

    //     if ($request->amount > $pending) {
    //         return back()->with('error', 'Amount exceeds pending fees');
    //     }

    //     $payment = new StudentPayment();
    //     $payment->student_id = $student->id;
    //     $payment->training_program_id = $student->training_program_id;
    //     $payment->amount = $request->amount;
    //     $payment->payment_mode = $request->payment_mode;
    //     $payment->payment_date = now();
    //     $payment->remarks = $request->remarks;

    //     if ($request->hasFile('payment_receipt')) {
    //         $file = $request->file('payment_receipt');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('storage/students/payment_receipt'), $filename);
    //         $payment->payment_receipt = 'public/storage/students/payment_receipt/' . $filename;
    //     }

    //     $payment->save();

    //     if ($student->enrollment_type === 'trial') {
    //         $student->enrollment_type = 'after_trial';
    //         $student->save();
    //     }

    //     $paymentMailData = [
    //         'id'           => $student->id,
    //         'student_name'  => $student->fname . ' ' . $student->lname,
    //         'email'         => $student->email,
    //         'program'       => $student->trainingProgram->program_name ?? 'N/A',
    //         'amount'        => $payment->amount,
    //         'payment_mode'  => $payment->payment_mode,
    //         'payment_date'  => now()->format('d M Y'),
    //         'total_fees'    => $totalFees,
    //         'total_paid'    => $totalPaid + $payment->amount,
    //         'pending'       => $pending - $payment->amount,
    //     ];

    //     Mail::send('mail-templates.payment-received', compact('paymentMailData'),
    //         function ($message) use ($student) {
    //             $message->to($student->email);
    //             $message->subject('Payment Received Confirmation - Surele');
    //     });


    //     return back()->with('success', 'Payment added successfully');
    // }


    public function addPayment(Request $request, $id)
    {
        $student = Students::with('trainingProgram', 'payments')->findOrFail($id);

        $totalPaid = $student->payments->sum('amount');
        $totalFees = $student->trainingProgram->fees;
        $pending   = $totalFees - $totalPaid;

        if ($request->amount > $pending) {
            return back()->with('error', 'Amount exceeds pending fees');
        }

        $payment = new StudentPayment();
        $payment->student_id = $student->id;
        $payment->training_program_id = $student->training_program_id;
        $payment->amount = $request->amount;
        $payment->payment_mode = $request->payment_mode;
        $payment->payment_date = now();
        $payment->remarks = $request->remarks;

        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/students/payment_receipt'), $filename);
            $payment->payment_receipt = 'public/storage/students/payment_receipt/' . $filename;
        }

        $payment->save();

        if ($student->enrollment_type === 'trial') {
            $student->enrollment_type = 'after_trial';
            $student->save();
        }

        $paymentMailData = [
            'id'            => $payment->id, 
            'student_name'  => $student->fname . ' ' . $student->lname,
            'email'         => $student->email,
            'program'       => $student->trainingProgram->program_name ?? 'N/A',
            'amount'        => $payment->amount,
            'payment_mode'  => $payment->payment_mode,
            'payment_date'  => now()->format('d M Y'),
            'total_fees'    => $totalFees,
            'total_paid'    => $totalPaid + $payment->amount,
            'pending'       => $pending - $payment->amount,
        ];

        $pdf = Pdf::loadView('mail-templates.payment-received', compact('paymentMailData'))
            ->setPaper('A4', 'portrait');

        $fileName = 'Payment_Receipt_' . str_pad($payment->id, 3, '0', STR_PAD_LEFT) . '.pdf';

        Mail::send('mail-templates.payment-received', compact('paymentMailData'), function ($message) use ($student, $pdf, $fileName) {
            $message->to($student->email);
            $message->subject('Payment Received Confirmation - Surele');
            $message->attachData($pdf->output(), $fileName);
        });

        return back()->with('success', 'Payment added successfully and receipt emailed');
    }


    public function sendPaymentReminder($id)
    {
        $student = Students::with('trainingProgram', 'payments')->findOrFail($id);
        
        $totalPaid = $student->payments->sum('amount');
        $totalFees = $student->trainingProgram->fees ?? 0;
        $pending   = max($totalFees - $totalPaid, 0);

        if ($pending <= 0) {
            return back()->with('error', 'No pending amount for this student.');
        }

        $reminderData = [
            'student_name' => $student->fname . ' ' . $student->lname,
            'email'        => $student->email,
            'program'      => $student->trainingProgram->program_name ?? 'N/A',
            'total_fees'   => $totalFees,
            'paid'         => $totalPaid,
            'pending'      => $pending,
            'due_date'     => now()->addDays(7)->format('d M Y'), 
        ];

        Mail::send('mail-templates.payment-reminder', compact('reminderData'),
            function ($message) use ($student) {
                $message->to($student->email);
                $message->subject('Payment Reminder – Pending Fees');
            }
        );

        return back()->with('success', 'Payment reminder sent successfully.');
    }

    public function sendOfferLetter($id)
    {
        $student = Students::with('trainingProgram')->findOrFail($id);
        $company = CompanySetting::first();

        $offerMailData = [
            'student_name'      => $student->fname . ' ' . $student->lname,
            'program_name'      => $student->trainingProgram->program_name ?? 'Internship',
            'start_date'        => now()->format('d F Y'),
            'company_name'      => $company->company_name,
            'company_address1'  => str_replace(',', '<br>', $company->address),
            'company_address2'  => $company->address_line_2,
            'company_city'      => $company->city,
            'company_pincode'   => $company->pincode,
            'company_phone'     => $company->company_phone,
            'company_logo'      => $company->logo,
            'company_seal'      => $company->digital_signature,
            'date'              => now()->format('d.m.Y'),
        ];

        $pdf = Pdf::loadView('mail-templates.offer-letter', compact('offerMailData'))
            ->setPaper('A4', 'portrait');

        $fileName = 'Offer_Letter_' . $student->id . '.pdf';

        Mail::send(
            'mail-templates.offer-letter',
            compact('offerMailData'),
            function ($message) use ($student, $pdf, $fileName) {
                $message->to($student->email);
                $message->subject('Offer Letter from ' . ($company->company_name ?? 'Surele'));
                $message->attachData($pdf->output(), $fileName);
            }
        );

        return back()->with('success', 'Offer letter sent successfully with PDF attachment.');
    }

}
