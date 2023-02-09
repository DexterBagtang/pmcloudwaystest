<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasingController extends Controller
{
    public function bidding(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Approved Project Design -> For Bidding')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('purchasing.biddings')->with('sales',$sales);
    }

    public function bidding_upload($id){
        $sales = DB::table('sales_requests')
//            ->where('status','=','Approved Project Design -> For Bidding')
            ->where('sales_requests.id','=',$id)
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->first();

        $data_sld=json_decode($sales->sld);
        $data_bof=json_decode($sales->bof);
        $data_layout=json_decode($sales->layout);
//        dd($sales);
        return view('purchasing.biddings_upload')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout);
    }

    public function upload_biddings(Request $request){
        $this->validate($request,[
           'trade' => 'required',
           'contractor_name' => 'required',
           'total_cost' => 'required',
            'bid_file' => 'required',
        ]);

        if ($request->hasFile('bid_file')) {
            $name = $request->file('bid_file')->getClientOriginalName();
            $filename = time() . $name;
            $request->file('bid_file')->move(public_path().'/files/bidfiles/',$filename);
        }
        $bidders_sales_id = $request->input('id');

        $contractor = array_filter($request->contractor_name);
        $trade = array_filter($request->trade);
        $total = array_filter($request->total_cost);

        foreach ($contractor as $key => $value){
            $bidding = new Bidding();
            $bidding->sales_requests_id = $bidders_sales_id;
            $bidding->contractor_name = $contractor[$key];
            $bidding->trade = $trade[$key];
            $bidding->total_cost = $total[$key];
            $bidding->bid_file = $filename;

            $bidding->save();
            $data[] = $bidding;
        }
        $sales = SalesRequest::find($request->input('id'));
        $sales->biddings = json_encode($data);

        $sales->status = "Bidders Uploaded -> For Supervisor's Approval";

        $sales->update();

        return redirect('bidding')->with('message','Bidding Uploaded !');





//        foreach ($contractor as $key => $value){
//            $data = array(
//                'contractor_name' => $contractor[$key],
//                'trade' => $trade[$key],
//                'total_cost' => $total[$key],
//                'bid_file' => $filename,
//                'sales_requests_id' => $bidders_sales_id,
//            );
////            return $request->contractor_name;
////            return $contractor;
//
//            Bidding::insert($data);
//
//        }

    }

    public function disapproved_bidding(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Bidders Disapproved -> For Rebidding')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        dd($sales);
        return view('purchasing.disapproved_biddings')->with('sales',$sales);
    }

    public function upload_disapproved($id){
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
        return view('purchasing.bidding_disapproved_uploaded')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function rebid_bidding(Request $request)
    {
        $this->validate($request, [
            'trade' => 'required',
            'contractor_name' => 'required',
            'total_cost' => 'required',
//            'bid_file' => 'required',
        ]);

        if ($request->hasFile('bid_file')) {
            $name = $request->file('bid_file')->getClientOriginalName();
            $filename = time() . $name;
            $request->file('bid_file')->move(public_path() . '/files/bidfiles/', $filename);
        }else{
            $filename=$request->input('old_bid_file');
        }
        $bidders_sales_id = $request->input('id');

        // Edit Existing Data in the Bidders

        $bidder_id = array_filter($request->bidder_id);
        $contractor = array_filter($request->contractor_name);
        $trade = array_filter($request->trade);
        $total = array_filter($request->total_cost);

        foreach ($bidder_id as $key => $value) {
            $bidding = Bidding::find($bidder_id[$key]);
            $bidding->sales_requests_id = $bidders_sales_id;
            $bidding->contractor_name = $contractor[$key];
            $bidding->trade = $trade[$key];
            $bidding->total_cost = $total[$key];
            $bidding->bid_file = $filename;
            $bidding->status = null;
            $bidding->revenue_status = null;

            $bidding->update();
            $data[] = $bidding;
        }

        //CREATE NEW BIDDERS

        $contractor2 = array_filter($request->contractor_name2);
        $trade2 = array_filter($request->trade2);
        $total2 = array_filter($request->total_cost2);

        foreach ($contractor2 as $key => $value) {
            $bidding = new Bidding();
            $bidding->sales_requests_id = $bidders_sales_id;
            $bidding->contractor_name = $contractor2[$key];
            $bidding->trade = $trade2[$key];
            $bidding->total_cost = $total2[$key];
            $bidding->bid_file = $filename;

            $bidding->save();
            $data[] = $bidding;
        }

        $sales = SalesRequest::find($request->input('id'));
        $sales->biddings = json_encode($data);

        $sales->status = "Bidders Uploaded -> For Supervisor's Approval";

        $sales->update();

        return redirect('bidding')->with('message', 'Bidding Uploaded !');
    }

    public function bidding_project_completion(){
        $sales = DB::table('sales_requests')
            ->where('status','=','Project Completion -> Uploading of Documents')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->select('sales_requests.*','malls.mall_name')
            ->orderBy('sales_requests.created_at','desc')
            ->get();
//        $sales->cer_files = json_decode($sales->cer_files);
//        dd($sales);
        return view('purchasing.biddings_project_completion')->with('sales',$sales);
    }


    public function bidding_uploading($id){
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
        return view('purchasing.biddings_uploading_completion')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout);
    }

    public function bidding_uploaded(Request $request){
        $this->validate($request,[
            'ntp' => 'required',
            'po' => 'required',
            'cari' => 'required',
        ]);
        $sales = SalesRequest::find($request->input('id'));

        if ($request->hasFile('ntp')){
            foreach ($request->file('ntp') as $ntp){
                $name = $ntp->getClientOriginalName();
                $filename = time().$name;
                $ntp->move(public_path().'/files/project_completion/',$filename);
                $ntp_data[] = $filename;
            }

        }

        if ($request->hasFile('po')){
            foreach ($request->file('po') as $po){
                $name = $po->getClientOriginalName();
                $filename = time().$name;
                $po->move(public_path().'/files/project_completion/',$filename);
                $po_data[] = $filename;
            }

        }

        if ($request->hasFile('cari')){
            foreach ($request->file('cari') as $cari){
                $name = $cari->getClientOriginalName();
                $filename = time().$name;
                $cari->move(public_path().'/files/project_completion/',$filename);
                $cari_data[] = $filename;
            }

        }

        $sales->contractor_ntp = json_encode($ntp_data);
        $sales->contractor_po = json_encode($po_data);
        $sales->cari = json_encode($cari_data);

        $sales->update();
        if ($sales->cer_files == null || $sales->first_copa == null || $sales->coca == null){
            $sales->status = "Project Completion -> Uploading of Documents";
        }else{
            $sales->status = "Project Complete";
        }

        $sales->update();

        return redirect('bidding-project-completion')->with('info','Files Uploaded !');

    }






}
