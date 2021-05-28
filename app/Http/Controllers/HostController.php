<?php

namespace App\Http\Controllers;

use App\Http\Transformers\HostContentTransformer;
use Illuminate\Http\Request;
use App\Hosttype;
use App\Host;
use App\Http\Transformers\HostTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Log;

class HostController extends Controller
{
    use Helpers;
    public function hosttypes(){
        $hosttypes =  Hosttype::orderBy('updated_at','desc')->paginate(10);
        //return $hosttypes;
        return $this->paginator($hosttypes,new HostTransformer());
    }

    public function hostcontent($id){
        $hosttype = Hosttype::find($id);
        return $this->item($hosttype,new HostContentTransformer());

    }
    public function createhost(Request $request){
        $hosttype = new HostType();
        $hosttype->title = $request->title;
        $hosttype->save();
        foreach ($request->hostcontent as $requesthost){
            Host::create([
                'host_type_id' => $hosttype->id,
                'record' => $requesthost['record'],
            ]);
        }
        return response()->json('success');
    }
    public function edithost($id,Request $request){
        $hosttype = Hosttype::find($id);
        $hosttype->title = $request->title;
        foreach ($request->hostcontent as $requesthost){

            $host = Host::find($requesthost['id']);

            if ($host != null){
                $host->record = $requesthost['record'];
                $host->save();
            }else{
                Host::create([
                    'host_type_id' => $id,
                    'record' => $requesthost['record'],
                ]);
            }

        }
        $hosttype->save();
        return response()->json('success');
    }
    public function delhost($id){
        $hosttype = Hosttype::find($id);
        foreach ($hosttype->hosts as $host){
            $host->delete();
        }
        $hosttype->delete();
        return response()->json('success');
    }
    public function delhostcontent($id){
        $host = Host::find($id);
        $host->delete();
        return response()->json('success');
    }
}
