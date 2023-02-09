<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Mall;
use App\Models\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesRequestController extends Controller
{
    public function sales_index(){
        $salesrequests = DB::table('sales_requests')
            ->select('sales_requests.*','malls.mall_name')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->orderBy('sales_requests.updated_at','desc')
            ->get();
//        dd($salesrequests);
//        return $salesrequests;
        return view('sales.sales_index')->with('salesrequests',$salesrequests);
    }

    public function sales_create(){
        $malls = Mall::all();
        return view('sales.sales_create')->with('malls',$malls);
    }

    public function sales_store(Request $request){
        $this->validate($request,[
            'mall_id' => 'required',
            'quotation_addressee' => 'required',
            'requester' => 'required',
            'date_needed' => 'required',
            'project_requirement_files' => 'required',
            'project_title' => 'required',
            'category' => 'required',
        ]);

        if ($request->hasFile('project_requirement_files')){
            $name = $request->file('project_requirement_files')->getClientOriginalName();
            $fileName = time().'_'.$name;
            $request->file('project_requirement_files')->move(public_path().'/images/project_requirements_files/',$fileName);
            $projectfile = $fileName;
        }else{
            $projectfile= null;
        }

        $sales = new SalesRequest();
        $sales->mall_id = $request->input('mall_id');
        $sales->quotation_addressee = $request->input('quotation_addressee');
        $sales->requester = $request->input('requester');
        $sales->project_title = $request->input('project_title');
        $sales->date_needed = $request->input('date_needed');
        $sales->category = $request->input('category');
        $sales->remarks = $request->input('remarks');
        $sales->project_requirement_files = $projectfile;

        $sales->sales_request_code = 'SR'.uniqid();
        $sales->status = 'For PM Review';
        $sales->save();

        return redirect('sales')->with('message','Added Successfully');
    }
    public function sales_edit($id){
        $malls = Mall::all();
        $sales = DB::table('sales_requests')
            ->where('id',$id)->first();
//        dd($malls,$sales,$mallSelected);
        return view('sales.sales_edit')->with('malls',$malls)->with('sales',$sales);
    }

    public function sales_update(Request $request){
        $this->validate($request,[
            'mall_id' => 'required',
            'quotation_addressee' => 'required',
            'requester' => 'required',
            'date_needed' => 'required',
            'project_title' => 'required',
            'category' => 'required',
        ]);
        if ($request->hasFile('project_requirement_files')){
            $name = $request->file('project_requirement_files')->getClientOriginalName();
            $fileName = time().'_'.$name;
            $request->file('project_requirement_files')->move(public_path().'/images/project_requirements_files/',$fileName);
            $projectfile = $fileName;
        }else{
            $projectfile= $request->input('old_project_files');
        }

        $sales = SalesRequest::find($request->input('id'));
        $sales->mall_id = $request->input('mall_id');
        $sales->quotation_addressee = $request->input('quotation_addressee');
        $sales->requester = $request->input('requester');
        $sales->project_title = $request->input('project_title');
        $sales->date_needed = $request->input('date_needed');
        $sales->category = $request->input('category');
        $sales->remarks = $request->input('remarks');
        $sales->project_requirement_files = $projectfile;

        $sales->status = 'For PM Review';

        $sales->update();
        return redirect('sales')->with('message','Updated Baby');

    }

    public function sales_disapproved(){
            $salesrequests = DB::table('sales_requests')
                ->where('status','=','Disapproved Project')
                ->select('sales_requests.*','malls.mall_name')
                ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
                ->orderBy('sales_requests.updated_at','desc')
                ->get();
//        dd($salesrequests);
//            return $salesrequests;
        return view('sales.sales_index')->with('salesrequests',$salesrequests);
    }

    public function sales_upload_proofs(){
        $salesrequests = DB::table('sales_requests')
            ->where('status','=','Proposal Approved -> For Sales Upload of Proof')
            ->select('sales_requests.*','malls.mall_name')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->orderBy('sales_requests.updated_at','desc')
            ->get();
//        dd($salesrequests);
//            return $salesrequests;
        return view('sales.sales_upload_proof')->with('salesrequests',$salesrequests);
    }

    public function sales_uploading_proofs($id){
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
        return view('sales.sales_uploading_proof')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function sales_uploaded(Request $request){
        $this->validate($request,[
            'proof_of_sending' => 'required',
        ]);
        if ($request->hasFile('proof_of_sending')) {
            $name = $request->file('proof_of_sending')->getClientOriginalName();
            $filename = time() . $name;
            $request->file('proof_of_sending')->move(public_path() . '/files/proof/', $filename);
        }

        $sales = SalesRequest::find($request->input('id'));
        $sales->status = "Proposal Sent -> Proof Uploaded";
        $sales->proof_of_sending = $filename;

        $sales->update();

        return redirect('sales-uploads-proofs')->with('message','Bidders Reviewed');
    }

    public function sales_proposal_status(){
        $salesrequests = DB::table('sales_requests')
            ->where('status','=','Proposal Sent -> Proof Uploaded')
            ->select('sales_requests.*','malls.mall_name')
            ->leftJoin('malls','sales_requests.mall_id','=','malls.id')
            ->orderBy('sales_requests.updated_at','desc')
            ->get();
//        dd($salesrequests);
//            return $salesrequests;
        return view('sales.sales_upload_proof')->with('salesrequests',$salesrequests);
    }

    public function sales_view_proposal($id){
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
        return view('sales.sales_view_proposal')->with('sales',$sales)
            ->with('data_sld',$data_sld)
            ->with('data_bof',$data_bof)
            ->with('data_layout',$data_layout)
            ->with('bidders',$bidders);
    }

    public function sales_proceed(Request $request){
        $this->validate($request,[
            'status' => 'required',
        ]);
        $sales = SalesRequest::find($request->input('id'));
        if ($request->input('status') == "Yes"){
            $this->validate($request,[
                'po_ntp_files' => 'required',
                'proposal_files' => 'required',
            ]);
            if ($request->hasFile('po_ntp_files')) {
                $name = $request->file('po_ntp_files')->getClientOriginalName();
                $filename1 = time() . $name;
                $request->file('po_ntp_files')->move(public_path() . '/files/pontpfiles/', $filename1);
            }
            if ($request->hasFile('proposal_files')) {
                $name = $request->file('proposal_files')->getClientOriginalName();
                $filename2 = time() . $name;
                $request->file('proposal_files')->move(public_path() . '/files/proposal_files/', $filename2);
            }

            $sales->status = "Proceed Proposal ->For Revenue Upload Bid Summary";
            $sales->po_ntp_files = $filename1;
            $sales->proposal_files = $filename2;
            $sales->update();

        }else{
            $this->validate($request,[
                'pm_bidders_remarks' => 'required',
                'return' => 'required',
            ]);
            if ($request->input('return') == "sales"){
                $sales->status = "Disapproved Project";
            }elseif($request->input('return') == "assigned"){
                $sales->status = "Disapproved Project Design";
            }elseif($request->input('return') == "purchasing"){
                $sales->status = "Bidders Disapproved -> For Rebidding";
            }else{
                $sales->status = "Proposal Disapproved";
            }
            $sales->pm_bidders_remarks = $request->input('pm_bidders_remarks');
            $sales->update();

            $bidders = Bidding::query()->where('sales_requests_id','=',$request->input('id'))
                ->get();
            $sales->status = "Proposal Disapproved";
            foreach ($bidders as $bidder){
                $bidder = Bidding::find($bidder->id);
                $bidder->status = null;
                $bidder->revenue_status = null;
                $bidder->update();
            }
        }

        return redirect('sales-proposal-status')->with('message','Bidders Reviewed');
    }



}
