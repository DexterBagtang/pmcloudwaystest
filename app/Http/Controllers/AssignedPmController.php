<?php

namespace App\Http\Controllers;

use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignedPmController extends Controller
{
    public function assigned_pm(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Approved Request For Project Design')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('pm-assigned.pm_assigned')->with('sales',$sales);
    }

    public function assigned_pm_upload($id){
        $sales = DB::table('sales_requests')
            ->where('status','=','Approved Request For Project Design')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
//        dd($sales);
        return view('pm-assigned.pm_assigned_upload')->with('sales',$sales);
    }

    public function assigned_pm_uploaded(Request $request){
        $this->validate($request,[
           'sld' => 'required',
           'bof' => 'required',
           'layout' => 'required',
        ]);
        $sales = SalesRequest::find($request->input('id'));

        if ($request->hasFile('sld')){
            foreach ($request->file('sld') as $sld){
                $name = $sld->getClientOriginalName();
                $filename = time().$name;
                $sld->move(public_path().'/files/sld/',$filename);
                $sld_data[] = $filename;
            }

        }

        if ($request->hasFile('bof')){
            foreach ($request->file('bof') as $bof){
                $name = $bof->getClientOriginalName();
                $filename = time().$name;
                $bof->move(public_path().'/files/bof/',$filename);
                $bof_data[] = $filename;
            }

        }

        if ($request->hasFile('layout')){
            foreach ($request->file('layout') as $layout){
                $name = $layout->getClientOriginalName();
                $filename = time().$name;
                $layout->move(public_path().'/files/layout/',$filename);
                $layout_data[] = $filename;
            }

        }

        $sales->sld = json_encode($sld_data);
        $sales->bof = json_encode($bof_data);
        $sales->layout = json_encode($layout_data);
        $sales->status = "Project Design Uploaded -> For Approval";

        $sales->update();

        return redirect('assigned-pm');

    }

    public function redesign_assigned_pm(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Disapproved Project Design')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('pm-assigned.pm_assigned')->with('sales',$sales);
    }

    public function redesign_assigned_pm_upload($id){
        $sales = DB::table('sales_requests')
//            ->where('status','=','Approved Request For Project Design')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        dd($sales,$data_sld,$data_bof,$data_layout);
        return view('pm-assigned.redesign_pm_assigned_upload')->with('sales',$sales)
        ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout);
    }

    public function redesign_assigned_uploaded(Request $request){
        $sales = SalesRequest::find($request->input('id'));

        if ($request->hasFile('sld')){
            foreach ($request->file('sld') as $sld){
                $name = $sld->getClientOriginalName();
                $filename = time().$name;
                $sld->move(public_path().'/files/sld/',$filename);
                $sld_data[] = $filename;
            }
        }else{
            foreach($request->input('old_sld') as $oldsld){
                $filename = $oldsld;
                $sld_data[] = $filename;
            }
        }

        if ($request->hasFile('bof')){
            foreach ($request->file('bof') as $bof){
                $name = $bof->getClientOriginalName();
                $filename = time().$name;
                $bof->move(public_path().'/files/bof/',$filename);
                $bof_data[] = $filename;
            }
        }else {
            foreach ($request->input('old_bof') as $oldbof) {
                $filename = $oldbof;
                $bof_data[] = $filename;
            }
        }

        if ($request->hasFile('layout')){
            foreach ($request->file('layout') as $layout){
                $name = $layout->getClientOriginalName();
                $filename = time().$name;
                $layout->move(public_path().'/files/layout/',$filename);
                $layout_data[] = $filename;
            }
        }else {
            foreach ($request->input('old_layout') as $oldlayout) {
                $filename = $oldlayout;
                $layout_data[] = $filename;
            }
        }

        $sales->sld = json_encode($sld_data);
        $sales->bof = json_encode($bof_data);
        $sales->layout = json_encode($layout_data);
        $sales->status = "Project Design Uploaded -> For Approval";

        $sales->update();

        return redirect('redesign-assigned-pm');

    }

    public function assigned_project_completion(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Project Completion -> Uploading of Documents')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        $sales->cer_files = json_decode($sales->cer_files);
//        dd($sales);
        return view('pm-assigned.assigned_completion')->with('sales',$sales);
    }


    public function assigned_uploading($id){
        $sales = DB::table('sales_requests')
//            ->where('status','=','Approved Request For Project Design')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        dd($sales,$data_sld,$data_bof,$data_layout);
        return view('pm-assigned.assigned_upload_completion')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout);
    }

    public function assigned_uploaded(Request $request){
        $this->validate($request,[
            'cer' => 'required',
            'copa' => 'required',
            'coca' => 'required',
        ]);
        $sales = SalesRequest::find($request->input('id'));

        if ($request->hasFile('cer')){
            foreach ($request->file('cer') as $cer){
                $name = $cer->getClientOriginalName();
                $filename = time().$name;
                $cer->move(public_path().'/files/project_completion/',$filename);
                $cer_data[] = $filename;
            }

        }

        if ($request->hasFile('copa')){
            foreach ($request->file('copa') as $copa){
                $name = $copa->getClientOriginalName();
                $filename = time().$name;
                $copa->move(public_path().'/files/project_completion/',$filename);
                $copa_data[] = $filename;
            }

        }

        if ($request->hasFile('coca')){
            foreach ($request->file('coca') as $coca){
                $name = $coca->getClientOriginalName();
                $filename = time().$name;
                $coca->move(public_path().'/files/project_completion/',$filename);
                $coca_data[] = $filename;
            }

        }

        $sales->cer_files = json_encode($cer_data);
        $sales->first_copa = json_encode($copa_data);
        $sales->coca = json_encode($coca_data);

        $sales->update();
        if ($sales->contractor_ntp == null || $sales->cari == null || $sales->contractor_po){
            $sales->status = "Project Completion -> Uploading of Documents";
        }else{
            $sales->status = "Project Complete";
        }

        $sales->update();

        return redirect('assigned-pm');

    }








}
