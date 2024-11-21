<?php

namespace App\Http\Controllers;

use App\Mail\ExpiringPolicies;
use App\Mail\MyEmail;
use App\Models\Policy;
use App\PolicyType;
use App\Status;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PolicyController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->success(Policy::all(), 'Policies successfully fetched');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedPolicyData = $this->validatePolicyData($request);
            $policy = Policy::create($validatedPolicyData);
            return $this->success($policy, 'Policy created successfully', 201);
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy): JsonResponse
    {
        try {
            return $this->success($policy, 'Policy successfully fetched');
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validatedPolicyData = $this->validatePolicyData($request, $id);
            $policy = Policy::find($id);
            $policy->update($validatedPolicyData);
            return $this->success($policy, 'Policy with id '. $policy->policy_number . ' updated successfully.');
        } catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            Policy::destroy($id);
            return $this->success( '', '', 204);
        }
        catch (\Exception $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }


    public function filterPolicies(Request $request): JsonResponse
    {
        try {
            $policyType = $request->query('policy_type');
            $status = $request->query('status');
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query = Policy::query();

            if ($policyType){
                $query->where('policy_type', $policyType);
            }

            if ($status){
                $query->where('status', $status);
            }

            if ($startDate && $endDate){
                $query->whereBetween('start_date', [$startDate, $endDate]);
            } elseif ($startDate){
                $query->whereDate('start_date', '>=', $startDate);
            } elseif ($endDate){
                $query->whereDate('end_date', '<=', $endDate);
            }

            $policies = $query->orderBy('start_date')->get();
            return $this->success($policies, 'Policies successfully fetched');
        } catch(\Exception $exception){
            return $this->error(500, $exception->getMessage());
        }
    }


    public function searchPolicy(Request $request): JsonResponse
    {
        try {
            $policyNumber = $request->query('policy_number');
            $customer_name = $request->query('customer_name');

            $policy = Policy::query();
            if ($policyNumber){
                $policy->where('policy_number', $policyNumber);
            }
            if ($customer_name){
                $policy->where('customer_name', 'like', '%'.$customer_name.'%');
            }

            $policies = $policy->get();
            return $this->success($policies, 'policies fetched successfully');
        } catch (\Exception $exception){
            return $this->error(500, $exception->getMessage());
        }
    }


    private function validatePolicyData(Request $request, $id=null): array
    {
        return $request->validate([
            'policy_number' => ['required', 'string', Rule::unique('policies', 'policy_number')->ignore($id)],
            'customer_name' => ['required', 'string'],
            'policy_type' => ['required', new Enum(PolicyType::class)],
            'status' => ['required', new Enum(Status::class)],
            'premium_amount' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);
    }


    public function checkExpiringPolicies(): JsonResponse
    {
        try {
            $policies = Policy::where('end_date', '>=', now())
                ->where('end_date', '<=', Carbon::now()->addDays(7))
                ->get();
            Mail::to(env('MAIL_USERNAME'))->send(new ExpiringPolicies($policies));

            return $this->success($policies, 'Policies successfully fetched');
        } catch(\Exception $exception){
            return $this->error(500, $exception->getMessage());
        }
    }

}
