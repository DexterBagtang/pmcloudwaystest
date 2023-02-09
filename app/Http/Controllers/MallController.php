<?php

namespace App\Http\Controllers;

use App\Models\Mall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MallController extends Controller
{
//    public function mall_count(){
//        $malls = DB::table('malls')->count();
//        return view('project_layout.sidebar')->with('malls',$malls);
//
//    }

    public function sales_malls(){
        $malls = Mall::all();
        return view('malls.malls_index')
            ->with('malls',$malls);
    }

    public function sales_malls_create(){
        return view('malls.create_malls');
    }

    public function sales_malls_store(Request $request){
        $this->validate($request,[
            'region' => 'required',
            'mall_name' => 'required',
            'mall_code' => 'required',
            'mall_logo' => 'image|max:1999',
        ]);
        if ($request->hasFile('mall_logo')){
            $fileName = $request->file('mall_logo')->getClientOriginalName();
            $fileNameToStore = time().'_'.$fileName;
            $request->file('mall_logo')->move(public_path().'/images/logo/',$fileNameToStore);
            $mall_logo = $fileNameToStore;
        }else{
            $mall_logo = null;
        }

        $mall = new Mall();
        $mall->region = $request->input('region');
        $mall->mall_name = $request->input('mall_name');
        $mall->mall_code = $request->input('mall_code');
        $mall->mall_logo = $mall_logo;

        $mall->save();
        return redirect('sales-malls')->with('message','Added Successfully');

    }

    public function sales_malls_edit($id){
        $mall = Mall::find($id);
        return view('malls.edit_malls')->with('mall',$mall);
    }

    public function sales_malls_update(Request $request){
        $this->validate($request,[
            'region' => 'required',
            'mall_name' => 'required',
            'mall_code' => 'required',
            'mall_logo' => 'image|max:1999',
        ]);
        if ($request->hasFile('mall_logo')){
            $fileName = $request->file('mall_logo')->getClientOriginalName();
            $fileNameToStore = time().'_'.$fileName;
            $request->file('mall_logo')->move(public_path().'/images/logo/',$fileNameToStore);
            $mall_logo = $fileNameToStore;
        }else {
            $mall_logo = $request->input('old_mall_logo');
        }

        $mall = Mall::find($request->input('id'));
        $mall->region = $request->input('region');
        $mall->mall_name = $request->input('mall_name');
        $mall->mall_code = $request->input('mall_code');
        $mall->mall_logo = $mall_logo;

        $mall->update();

        return redirect('sales-malls')->with('message','Updated Successfully');


    }

}
