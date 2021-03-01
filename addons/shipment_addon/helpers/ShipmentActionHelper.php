<?php

namespace App\Http\Helpers;

use App\Mission;
use App\Shipment;

class ShipmentActionHelper{

    private $actions;
	public function __construct() {
		$this->actions = array();
	}

    public function get($status,$type=null)
    {
        if($status == Shipment::REQUESTED_STATUS)
        {
            if($type == Shipment::DROPOFF)
            {
                return $this->requested();
            }elseif($type == Shipment::PICKUP)
            {
                return $this->requestedPickup();
            }
            
        }elseif($status == Shipment::SAVED_STATUS)
        {
            if($type == Shipment::DROPOFF)
            {
                return $this->saved();
            }elseif($type == Shipment::PICKUP)
            {
                return $this->savedPickup();
            }
            
        }elseif($status == Shipment::APPROVED_STATUS)
        {
            return $this->accepted();
        }elseif($status == Shipment::CLOSED_STATUS)
        {
            return $this->closed();
        }else
        {
            return $this->default();
        }
    }

    private function saved()
    {
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Approve');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::APPROVED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Reject');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-trash';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::CLOSED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            return $this->actions;
    }

    private function savedPickup()
    {
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Create Pickup Manifest');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action.create.pickup.mission',['type'=>Mission::PICKUP_TYPE]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['js_function_caller'] = 'openCaptainModel(this,event)';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Approve');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::APPROVED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Reject');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-trash';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::CLOSED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            

            return $this->actions;
    }

    private function requested()
    {
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Approve');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::APPROVED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Reject');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-trash';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::CLOSED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            return $this->actions;
    }

    private function requestedPickup()
    {

            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Approve');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::APPROVED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Reject');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-trash';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::CLOSED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            

            return $this->actions;
    }

    private function accepted()
    {
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Assign to Captain');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action.create.delivery.mission',['type'=>Mission::DELIVERY_TYPE]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['js_function_caller'] = 'openAssignShipmentCaptainModel(this,event)';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;

            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Reject');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-trash';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::CLOSED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            return $this->actions;
    }
    private function closed()
    {
            $this->actions[count($this->actions)] = array();
            $this->actions[count($this->actions)-1]['title'] = translate('Approve');
            $this->actions[count($this->actions)-1]['icon'] = 'fa fa-check';
            $this->actions[count($this->actions)-1]['url'] = route('admin.shipments.action',['to'=>Shipment::APPROVED_STATUS]);
            $this->actions[count($this->actions)-1]['method'] = 'POST';
            $this->actions[count($this->actions)-1]['type'] = 1; 
            $this->actions[count($this->actions)-1]['index'] = true;
            return $this->actions;
    }

    private function default()
    {
           
            return $this->actions;
    }
}