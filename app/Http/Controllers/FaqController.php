<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PatientCaseStudy;
use App\Models\Step;
use App\Models\Prescription;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StepsController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:prescription-read|prescription-create|prescription-update|prescription-delete', ['only' => ['index','show']]);
        $this->middleware('permission:prescription-create', ['only' => ['create','store']]);
        $this->middleware('permission:prescription-update', ['only' => ['edit','update']]);
        $this->middleware('permission:prescription-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $prescriptions = $this->filter($request)->paginate(10);


        $patients = User::distinct('id')->role('patient')->get(['id', 'name']);
        //Log::info(($patients));
        return view('steps.index', compact('prescriptions', 'patients'));
    }
    public function show(Request $request){
        Log::info($request);
        $prescriptions=Step::select('*')->where('user_id',$request->user_id)->get();
        Log::info($prescriptions);

        return view('steps.show', compact('prescriptions'));
    }

    private function filter(Request $request)
    {
        $query = Step::query();

        if (auth()->user()->hasRole('Patient'))
            $query->where('user_id', auth()->id());
        elseif ($request->user_id)
            $query->where('user_id', $request->user_id);

        return $query;
    }

    public function store(Request $request)
    {


        foreach ($request->medicine_name as $key => $value) {
            if (empty($request->medicine_name[$key]))
                continue;

        $prescriptionData[] = [
            'user_id'=>$request->user_id,
            'step'=>$request->medicine_name,
            'on_clinic'=>$request->medicine_type,
            'payment'=>$request->instruction,
        ];
       $step=new Step();
       $step->user_id=$request->user_id;
       $step->step=$request->medicine_name[$key];
       $step->on_clinic=$request->medicine_type[$key];
       $step->payment=$request->instruction[$key];
       $step->save();
        }

Log::info ($prescriptionData);

//        Step::create($prescriptionData);


        return redirect()->route('steps.index')->with('success', trans('Prescription Created Successfully'));
    }

    public function edit(Request $request, Prescription $prescription)
    {
        $patients = User::role('Patient')->where('status', '1')->get(['id', 'name']);
        $patientCaseStudy = null;

        if ($request->user_id)
            $patientCaseStudy = PatientCaseStudy::where('user_id', $request->user_id)->first();

        return view('steps.edit', compact('patients', 'patientCaseStudy', 'prescription'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        if (auth()->id() != $prescription->doctor_id)
            return redirect()->route('dashboard');

        $this->validation($request);

        $prescriptionData = $request->only(['user_id', 'weight', 'height', 'blood_group', 'chief_complaint', 'note', 'prescription_date']);
        $caseStudyData = $request->only(['user_id','food_allergy','heart_disease','high_blood_pressure','diabetic','surgery','accident','others','family_medical_history','current_medication','pregnancy','breastfeeding','health_insurance']);

        $prescriptionData['doctor_id'] = auth()->id();
        $prescriptionData['medicine_info'] = $this->makeMedicineJson($request);
        $prescriptionData['diagnosis_info'] = $this->makeDiagnosisJson($request);

        $prescription->update($prescriptionData);
        PatientCaseStudy::updateOrCreate(['user_id' => $request->user_id], $caseStudyData);

        return redirect()->route('steps.index')->with('success', trans('Prescription Updated Successfully'));
    }

    public function destroy(Step $prescription)
    {
        Log::info($prescription);
     $prescription->delete();
        //Step::where('user_id',$prescription->user_id)->delete();
        return redirect()->route('steps.index')->with('success', trans('Steps Deleted Successfully'));
    }


}
