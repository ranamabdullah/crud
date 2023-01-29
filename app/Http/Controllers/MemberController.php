<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Member::all();
        return view('member.index',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->search){

            // Logic for search

            $query = DB::table('members');

            if($request->name){
                $query->where('name',$request->name);
            }

            if($request->number){
                $query->where('number',$request->number);
            }

            if($request->regdate){
                $query->where('regdate',$request->regdate);
            }

            if($request->status){
                $query->where('status',$request->status);
            }

            $data = $query->get();
            return view('member.index',compact('data'));

        }else{
            // Logic for add/edit

            $error_message = "";

            if($request->name == ''){
                $error_message .= ", Name is required";
            }

            if($request->number ==''){
                $error_message .= ", Number is required";
            }

            if($request->regdate ==''){
                $error_message .= ", Reg Date is required";
            }

            if($error_message != ''){
                $data = Member::all();
                return view('member.index',compact('data','error_message'));
            }


            $name = $request->name;
            $number = $request->number;
            $regdate = $request->regdate;
            $status = $request->status;

            if(isset($request->edit_id)){
                // Logic to update to database
                $member = Member::find($request->edit_id);
                $member->name = $name;
                $member->number = $number;
                $member->regdate = $regdate;
                $member->status = $status;
                $member->update();

            }else{
                // Logic to add to database
                Member::create(['name'=>$name,'number'=>$number,'regdate'=>$regdate,'status'=>$status]);
            }

            return redirect()->route('member.index');

        }

    }


    public function edit(Request $request,$id){
        $member = Member::find($id);
        $data = member::all();
        return view('member.index',compact('data','member'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Member::destroy($id);
        return redirect()->route('member.index');
    }
}
