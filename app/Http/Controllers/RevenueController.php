<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function revenue_markups(){
        $sales = DB::table('sales_requests')
            ->where('status','=',"Checked Bidders -> For Revenue Review")
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('revenue.markups')->with('sales',$sales);
    }

    public function revenue_markup($id){
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
            ->get();


        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        $bidders = json_decode($sales->biddings);

//        dd($sales,$data_sld,$data_bof,$data_layout,$bidders);
        return view('revenue.view_markup')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function revenue_marked(Request $request){
        $this->validate($request,[
//            'pm_bidders_remarks' => 'required',
            'status' => 'required',
        ]);


        $sales = SalesRequest::find($request->input('id'));
        if ($request->input('status') == 'Yes'){
            $sales->status = "Bid Winner Marked -> For Technical Check";
            if ($request->hasFile('proposal_files')){
                $this->validate($request,['proposal_files']);
                $name = $request->file('proposal_files')->getClientOriginalName();
                $fileName = time().'_'.$name;
                $request->file('proposal_files')->move(public_path().'/files/proposal_files/',$fileName);
            }
            $sales->proposal_files = $fileName;
            $sales->project_size = $request->input('project_size');

            $bidding = $request->revenue_bidder;

            foreach($bidding as $key => $value){
                $bid = Bidding::find($bidding[$key]);
                if($request->has('revenue_bidder')) {
                    $bid->revenue_status = 1;
                    $bid->update();
                }
            }
        }else{
            $sales->status = "Bidders Disapproved -> For Rebidding";
            $sales->pm_bidders_remarks = $request->input('pm_bidders_remarks');
        }


        $sales->update();

        return redirect('revenue-markups')->with('message','Bidders Reviewed');
    }

    public function revenue_disapproved(){
        $sales = DB::table('sales_requests')
            ->where('status','=',"Proposal Disapproved")
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('revenue.markups')->with('sales',$sales);
    }

    public function revenue_disapproved_markup($id){
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
            ->get();


        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        $bidders = json_decode($sales->biddings);

//        dd($sales,$data_sld,$data_bof,$data_layout,$bidders);
        return view('revenue.view_disapproved_markup')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function revenue_bid_summary(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Proceed Proposal ->For Revenue Upload Bid Summary')
            ->select('sales_requests.*','malls.mall_name')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->orderBy('sales_requests.updated_at','desc')
            ->get();
//        dd($salesrequests);
//            return $salesrequests;
        return view('revenue.markups')->with('sales',$sales);
    }

    public function revenue_uploading($id){
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
        return view('revenue.upload_bid_summary')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function revenue_uploaded(Request $request){
        $this->validate($request,[
            'status' => 'required',
        ]);
        $sales = SalesRequest::find($request->input('id'));
        if ($request->input('status') == "Yes"){
            $this->validate($request,[
                'bid_summary_files' => 'required',
            ]);
            if ($request->hasFile('bid_summary_files')) {
                $name = $request->file('bid_summary_files')->getClientOriginalName();
                $filename1 = time() . $name;
                $request->file('bid_summary_files')->move(public_path() . '/files/bid_summary_files/', $filename1);
            }
            $sales->status = "Project Completion -> Uploading of Documents";
            $sales->bid_summary_files = $filename1;
            $sales->update();
        }else{
            $this->validate($request,[
                'pm_bidders_remarks' => 'required',
            ]);
            $sales->status = "Proposal Disapproved";
            $sales->pm_bidders_remarks = $request->input('pm_bidders_remarks');
            $sales->status = "Proposal Sent -> Proof Uploaded";
            $sales->update();
        }
        return redirect('revenue-bid-summary')->with('message','Bidders Reviewed');
    }


}
