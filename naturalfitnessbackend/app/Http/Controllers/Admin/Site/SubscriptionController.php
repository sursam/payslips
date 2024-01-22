<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\BaseController;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends BaseController
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index(Request $request)
    {
        $this->setPageTitle('Membership Plans');
        return view('admin.subscription.index');
    }

    public function add(Request $request)
    {
        $this->setPageTitle('Add Plan');
        if ($request->post()) {
            $request->validate([
                'name' => 'required|unique:memberships,name',
                'price' => 'required|numeric',
                'duration' => 'required|numeric',
            ]);
            DB::beginTransaction();
            try {
                $isPlanCreated = $this->subscriptionService->createOrUpdatePlan($request->except('_token'));
                if ($isPlanCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.settings.membership.list','Membership Created successfully','success');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.subscription.add');

    }
    public function edit(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Plan');
        $id = uuidtoid($uuid, 'memberships');
        $plan= $this->subscriptionService->find($id);
        if ($request->post()) {
            $request->validate([
                'name' => 'required|unique:memberships,name,' . $id,
                'price' => 'required|numeric',
                'duration' => 'required|numeric',
            ]);
            DB::beginTransaction();
            try {
                $isPlanUpdated = $this->subscriptionService->createOrUpdatePlan($request->except('_token'), $id);
                if ($isPlanUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.settings.membership.list','Membership Updated successfully','success');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.subscription.edit',compact('plan'));
    }
}
