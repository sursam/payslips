<?php

namespace App\Http\Controllers\Admin\Zone;

use Illuminate\Http\Request;
use App\Services\Zone\ZoneService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Http;
class ZoneController extends BaseController
{
    public function __construct(protected ZoneService $zoneService){
        $this->zoneService= $zoneService;
    }
    public function index(Request $request){
        $this->setPageTitle('List Zones');
        return view('admin.zone.list');
    }
    public function add(Request $request){
        $this->setPageTitle('Add Zone');
        if ($request->post()) {
            $request->validate([
                'name' => 'required|unique:zones,name,NULL,id,deleted_at,NULL',
                //'postcode'=>'required',
                'postcodes.codes'=>'required',
                //'description' => 'sometimes|nullable'
            ]);
            DB::beginTransaction();
            try {
                $postcodes = explode(',', $request->postcodes['codes']);
                $zoneCoords = [];
                foreach($postcodes as $postcode){
                    $zoneCoords[$postcode] = $this->getGeoCode(trim(($postcode)));
                }
                //dd($zoneCoords);
                $request->merge(['coordinates' => json_encode($zoneCoords)]);
                $iszoneCreated = $this->zoneService->createOrUpdateZone($request->except('_token'));
                if ($iszoneCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.settings.zone.list', 'Zone created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.zone.add');
    }
    public function edit(Request $request,$uuid){
        $this->setPageTitle('Edit Zone');
        $filterConditions= [
            'status'=> true
        ];
        $zoneId= uuidtoid($uuid,'zones');
        $zoneData= $this->zoneService->findZoneById($zoneId);
        if($request->post()){
            DB::beginTransaction();
             try{
                $postcodes = explode(',', $request->postcodes['codes']);
                $zoneCoords = [];
                foreach($postcodes as $postcode){
                    $zoneCoords[$postcode] = $this->getGeoCode(trim(($postcode)));
                }
                //dd($zoneCoords);
                $request->merge(['coordinates' => json_encode($zoneCoords)]);
                $iszoneUpdated= $this->zoneService->createOrUpdateZone($request->except('_token'),$zoneId);
                if($iszoneUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.settings.zone.list','Zone updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.zone.edit',compact('zoneData'));
    }

    protected function getGeoCode($address)
    {
        $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=".config('constants.GOOGLE_MAP_API_KEY');
        $response = Http::get($url);

        $data['lat'] = 0;
        $data['lng'] = 0;
        $data['place_id'] = '';
        if($response->successful() && count($response->json()['results'])){
            $json = $response->json();
            $data['lat'] = $json['results'][0]['geometry']['location']['lat'];
            $data['lng'] = $json['results'][0]['geometry']['location']['lng'];
            $data['place_id'] = $json['results'][0]['place_id'];
        }
        return $data;
    }
}
