<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Mall;
use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PmSupervisorController extends Controller
{
    public function pm_review_sales(){
//        $malls = Mall::all();
        $sales = DB::table('sales_requests')
            ->where('status','=','For PM Review')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($salesrequests);
        return view('pm-supervisor.pm_review_sales')->with('sales',$sales);
    }

    public function pm_reviews($id){
      $sales = DB::table('sales_requests')
            ->where('status','=','For PM Review')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
//        dd($sales);
        return view('pm-supervisor.pm_reviews')->with('sales',$sales);
    }

    public function pm_review_approve(Request $request){
        $sales = SalesRequest::find($request->input('id'));
//        $sales->mall_id = $request->input('mall_id');
//        $sales->quotation_addressee = $request->input('quotation_addressee');
//        $sales->requester = $request->input('requester');
//        $sales->project_title = $request->input('project_title');
//        $sales->date_needed = $request->input('date_needed');
//        $sales->category = $request->input('category');
//        $sales->remarks = $request->input('remarks');
//        $sales->project_requirement_files = $request->input('old_project_files');

        if ($request->input('status') == "Yes"){
            $sales->status = "Approved Request For Project Design";
            $this->validate($request,['pm_assigned_id'=>'required']);
            $sales->pm_assigned_id = $request->input('pm_assigned_id');

        }else{
            $sales->status = "Disapproved Project";
            $this->validate($request,['pm_remarks'=>'required']);
            $sales->pm_remarks = $request->input('pm_remarks');
        }

        $sales->update();
        return redirect('pm-review-sales');
    }

    public function review_projects(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Project Design Uploaded -> For Approval')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('pm-supervisor.project_designs_review')->with('sales',$sales);
    }

    public function review_design($id){
        $sales = DB::table('sales_requests')
            ->where('status','=','Project Design Uploaded -> For Approval')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();

        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        dd($sales,$data_sld,$data_bof,$data_layout);
        return view('pm-supervisor.review_project_design')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout);
    }

    public function approve_design(Request $request){
        $sales = SalesRequest::find($request->input('id'));

        if ($request->input('status') == "Yes"){
            $sales->status = "Approved Project Design -> For Bidding";

        }else{
            $sales->status = "Disapproved Project Design";
            $sales->pm_remarks = $request->input('pm_design_remarks');
        }

        $sales->update();
        return redirect('review-projects');
    }

    //Choose Bid Winner

    public function review_bidders(){
        $sales = DB::table('sales_requests')
            ->where('status','=',"Bidders Uploaded -> For Supervisor's Approval")
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('pm-supervisor.bidders_review')->with('sales',$sales);
    }

    public function review_bidder($id){
        $sales = DB::table('sales_requests')
            ->where('sales_requests.status','=',"Bidders Uploaded -> For Supervisor's Approval")
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->leftJoin('biddings','biddings.sales_requests_id','=','sales_requests.id')
            ->select('sales_requests.*','malls.mall_name','biddings.bid_file')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
        $bidders = DB::table('biddings')
            ->where('sales_requests_id','=',$id)
            ->get();



        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        $bidders = json_decode($sales->biddings);

//        dd($sales,$data_sld,$data_bof,$data_layout,$bidders);
        return view('pm-supervisor.review_bidder')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }


    public function review_selected_bidder(Request $request){
        $this->validate($request,[
            'pm_bidders_remarks' => 'required',
//            'checked' => 'required',
            'status' => 'required',
        ]);


        $sales = SalesRequest::find($request->input('id'));
        if ($request->input('status') == 'Yes'){
            $sales->status = "Checked Bidders -> For Revenue Review";
        }else{
            $sales->status = "Bidders Disapproved -> For Rebidding";
        }
        $sales->pm_bidders_remarks = $request->input('pm_bidders_remarks');

        $sales->update();


        $bidding = $request->bidder;

        foreach($bidding as $key => $value){
            $bid = Bidding::find($bidding[$key]);
            if($request->has('bidder')) {
                $bid->status = 1;
                $bid->update();
            }
        }
        return redirect('review-bidders')->with('message','Bidders Reviewed');
    }

    public function review_technicals(){
        $sales = DB::table('sales_requests')
            ->where('status','=',"Bid Winner Marked -> For Technical Check")
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('pm-supervisor.technicals_review')->with('sales',$sales);
    }

    public function review_technical($id){
        $sales = DB::table('sales_requests')
//            ->where('sales_requests.status','=',"Bidders Uploaded -> For Supervisor's Approval")
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->leftJoin('biddings','biddings.sales_requests_id','=','sales_requests.id')
            ->select('sales_requests.*','malls.mall_name','biddings.bid_file')
            ->orderBy('sales_requests.created_at','desc')
            ->first();
        $bidders = DB::table('biddings')
            ->where('sales_requests_id','=',$id)
            ->where('revenue_status','!=',null)
            ->get();


        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        $bidders = json_decode($sales->biddings);

//        dd($sales,$data_sld,$data_bof,$data_layout,$bidders);
        return view('pm-supervisor.review_technical')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function done_review_technical(Request $request){
        $this->validate($request,[
//            'pm_bidders_remarks' => 'required',
//            'checked' => 'required',
            'status' => 'required',
        ]);

        $bidders = DB::table('biddings')
            ->where('sales_requests_id','=',$request->input('id'))
            ->where('revenue_status','!=',null)
            ->get();


        $sales = SalesRequest::find($request->input('id'));
        if ($request->input('status') == 'Yes'){
            $sales->status = "Proposal Approved -> For Revenue Head Check";
        }else{
            $sales->status = "Proposal Disapproved";
            foreach ($bidders as $bidder){
                $bidder = Bidding::find($bidder->id);
                $bidder->revenue_status = null;
                $bidder->update();
            }

        }
        $sales->pm_bidders_remarks = $request->input('pm_bidders_remarks');

        $sales->update();

        return redirect('review-bidders')->with('message','Bidders Reviewed');
    }



}
