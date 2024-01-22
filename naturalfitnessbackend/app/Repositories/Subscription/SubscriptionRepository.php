<?php

namespace App\Repositories\Subscription;

use App\Contracts\Subscription\SubscriptionContract;
use App\Models\Site\Membership;
use App\Models\Site\MembershipPrice;
use App\Models\User\User;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use Illuminate\Support\Carbon;

/**
 * Class UserRepository
 *
 * @package \App\Repositories\User
 */
class SubscriptionRepository extends BaseRepository implements SubscriptionContract
{
    use UploadAble;
    public function __construct(Membership $model, protected MembershipPrice $validityModel, protected User $userModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->validityModel = $validityModel;
        $this->userModel = $userModel;

    }

    public function getList($start, $limit, $order, $dir, $search = null)
    {
        if ($search) {
            return $this->model->where('name', 'LIKE', "%{$search}%")
                ->orWhereHas('price', function ($q) use ($search) {
                    $q->where('duration', 'LIKE', "%{$search}%");
                    $q->orWhere('price', 'LIKE', "%{$search}%");
                })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    public function getTotalData($search = null)
    {
        if ($search) {
            return $this->model->where('name', 'LIKE', "%{$search}%")
                ->orWhereHas('price', function ($q) use ($search) {
                    $q->where('duration', 'LIKE', "%{$search}%");
                    $q->orWhere('price', 'LIKE', "%{$search}%");
                })->count();
        }

        return $this->model->count();
    }

    public function createPlan($attributes)
    {
        $isPackageCreated = $this->create($attributes);
        if ($isPackageCreated) {
            $isPackagePriceCreated = $isPackageCreated->price()->create([
                'price' => $attributes['price'],
                'duration' => $attributes['duration'],
                'interval' => $attributes['interval'] ?? null,
            ]);
            if ($isPackagePriceCreated) {
                return $isPackageCreated;
            }
        }
        return false;
    }
    public function updatePlan($attributes, $id)
    {
        $isPackageFound = $this->find($id);
        $isPackageUpdated = $this->update($attributes, $id);
        if ($isPackageUpdated) {
            $isPackagePriceUpdated = $isPackageFound->price()->update([
                'price' => $attributes['price'],
                'duration' => $attributes['duration'],
                'interval' => $attributes['interval'] ?? null,
            ]);
            if ($isPackagePriceUpdated) {
                return $isPackageFound;
            }
        }
        return false;
    }

    public function makeSubscription(array $attributes, int $id)
    {
        $packageId = uuidtoid($attributes['package_uuid'], 'memberships');
        $findPackage = $this->find($packageId);
        if ($findPackage) {
            $duration = $findPackage->price->interval == 'year' ? 12 : $findPackage->price->duration;
            $startDate = date('Y-m-d');
            $endDate = Carbon::now()->addMonths($duration)->format('Y-m-d');
            $isSubscriptionExist = $findPackage->subscribedUsers()->where(['user_id' => $id, 'is_expired' => false])->orderBy('start_date', 'desc')?->first();
            if ($isSubscriptionExist) {
                $startDate = $isSubscriptionExist->end_date;
                $endDate = Carbon::parse($isSubscriptionExist->end_date)->addMonths($duration)->format('Y-m-d');
            }
            $isValidityCreated = $findPackage->subscribedUsers()->create([
                'user_id' => $id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_expired' => false,
            ]);
            if ($isValidityCreated) {

                $user = $this->userModel->find($id);
                $updateuser = $user->update(['is_subscribed' => 1]);
                return $user;
            }
        }
        return false;
    }

}
