<?php

namespace App\Http\Helpers;

use App\Mission;
use App\Shipment;
use App\ShipmentLog;
use App\ShipmentMission;
use DB;
class StatusManagerHelper{

    public function change_shipment_status($shipments,$to,$mission_id = null)
    {
        $response = array();
		$response['success'] = 1;
		$response['error_msg'] = '';
		try {
			DB::beginTransaction();
            foreach($shipments as $shipment_id)
            {
                $shipment = Shipment::find($shipment_id);
                if($shipment !=null)
                {
                    $oldStatus = $shipment->status_id;

                    //Conditions of change status
                    if($to == Shipment::REQUESTED_STATUS)
                    {
                       
                        if($mission_id != null && ShipmentMission::check_if_shipment_is_assigned_to_mission($shipment_id,Mission::PICKUP_TYPE) == 0)
                        {
                                $shipment_mission = new ShipmentMission();
                                $shipment_mission->shipment_id = $shipment_id;
                                $shipment_mission->mission_id = $mission_id;
                                $shipment_mission->save();
                        }
                    }elseif($to == Shipment::SAVED_STATUS)
                    {
                        $shipment_mission = ShipmentMission::where('mission_id',$mission_id)->where('shipment_id',$shipment->id)->first();
                        $shipment_mission->delete();
                        $shipment->captain_id = null;
                        $shipment->mission_id = null;
                    }elseif($to == Shipment::CAPTAIN_ASSIGNED_STATUS)
                    {
                        if($mission_id != null)
                        {
                                    $mission = Mission::find($mission_id);
                                    $shipment->captain_id = $mission->captain_id;
                        }
                        
                    }
                    
                    $shipment->status_id = $to;
                    if(!$shipment->save())
                    {
                        throw new \Exception("can't change shipment status");
                    }
                    
                    $log = new ShipmentLog();
                    $log->from = $oldStatus;
                    $log->to = $shipment->status_id;
                    $log->created_by = \Auth::user()->id;
                    $log->save();
                }else
                {
                    throw new \Exception("There is no shipment with this ID");
                }
                
            }
            DB::commit();
        }catch (\Exception $e) {
			//echo $e->getMessage();exit;
			DB::rollback();
			$response['success'] = 0;
			$response['error_msg'] = $e->getMessage();
		}
        return $response;
    }



}