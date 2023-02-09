<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueHeadController extends Controller
{
    public function revenue_head_markups(){
        $sales = DB::table('sales_requests')
            ->where('status','=',"Proposal Approved -> For Revenue Head Check")
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('revenue-head.revenue_head_markups')->with('sales',$sales);
    }

    public function revenue_head_markup($id){
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
        return view('revenue-head.revenue_head_markup')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function revenue_head_marked(Request $request){
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
            $sales->status = "Proposal Approved -> For Sales Upload of Proof";
            if ($request->hasFile('pnl_file')) {
                $name = $request->file('pnl_file')->getClientOriginalName();
                $filename = time() . $name;
                $request->file('pnl_file')->move(public_path() . '/files/pnl/', $filename);
            }
            $sales->pnl_file = $filename;
            $sales->update();
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

        return redirect('revenue-head-markups')->with('message','Bidders Reviewed');
    }
}
