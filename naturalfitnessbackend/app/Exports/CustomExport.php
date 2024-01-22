<?php

namespace App\Exports;

use App\Models\User\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomExport implements FromCollection, WithHeadings, WithMapping
{
    public $role;
    public $vehicleType;
    public $isRegistered;
    public $orderBy;
    public $sortBy;
    public function __construct($role, $vehicleType, $isRegistered = 1, $orderBy = 'id', $sortBy = 'DESC')
    {
        $this->role = $role;
        $this->vehicleType = $vehicleType;
        $this->isRegistered = $isRegistered;
        $this->orderBy = $orderBy;
        $this->sortBy = $sortBy;
    }
    public function collection()
    {
        $role = $this->role;
        $vehicleType = $this->vehicleType;
        $isRegistered = $this->isRegistered;
        $orderBy = $this->orderBy;
        $sortBy = $this->sortBy;
        $model = new User;
        $model = $model->where(['is_registered' => $isRegistered]);
        if($vehicleType != 'all'){
            $model= $model->whereHas('vehicle',function($q)use($vehicleType){
                $q= $q->whereHas('vehicleType',function($qu)use($vehicleType){
                    $qu= $qu->where('slug', $vehicleType);
                });
            })->whereHas('roles',function($r)use($role){
                $r= $r->where('slug', $role);
            });
        }
        $model = $model->whereHas('roles',function($r)use($role){
            $r= $r->where('slug', $role);
        });
        $model = $model->orderBy($orderBy, $sortBy);

        return $model->get();
        // return User::all();
    }

    public function map($row): array
    {
        switch($row->is_branding){
            case 0: $branding_status = 'Not Applied'; break;
            case 1: $branding_status = 'Applied'; break;
            case 2: $branding_status = 'Accepted'; break;
            case 3: $branding_status = 'Rejected'; break;
        }
        $is_active = ($row->is_active) ? 'Not Suspended' : 'Suspended';
        $vehicleType = $row->vehicle?->vehicleType?->name;
        if($row->vehicle?->vehicleType?->slug == 'truck'){
            $vehicleType .= ' - ' . $row->vehicle?->vehicleSubType?->name .' ( '.$row->vehicle?->vehicleBodyType?->name.' )';
        }
        return [
            $row->first_name,
            $row->last_name,
            $row->email,
            $row->mobile_number,
            $row->created_at->format('d/m/Y') .' at '.$row->created_at->format('h:i A'),
            number_format((float)($row?->wallet?->balance ? $row?->wallet?->balance : 0), 2, '.', ''),
            $branding_status,
            ($row->is_approve == 1) ? 'Active' : 'Pending',
            $is_active,
            $vehicleType,
            $row->vehicle?->registration_number,
            $row->profile_picture,
            $row->userDocument('aadhar_front'),
            $row->userDocument('aadhar_back'),
            $row->userDocument('licence_front'),
            $row->userDocument('licence_back'),
            $row->vehicle?->vehicleDocument('rc_front'),
            $row->vehicle?->vehicleDocument('rc_back'),
            $row->vehicle?->vehicleDocument('vehicle_image')
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone Number',
            'Registration Date',
            'Wallet Balance',
            'Branding Status',
            'Verification Status',
            'Suspension Status',
            'Vehicle Type',
            'Vehicle Number',
            'Profile Image',
            'Aadhar Front',
            'Aadhar Back',
            'Licence Front',
            'Licence Back',
            'RC Front',
            'RC Back',
            'Vehicle Image',
        ];
    }
}
