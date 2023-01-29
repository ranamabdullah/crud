<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Book::all();
        $categories = Category::all();
        return view('book.index',compact('data','categories'));
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

            $query = Book::select();

            if($request->name){
                $query->where('name',$request->name);
            }

            if($request->arrival_date){
                $query->where('arrival_date',$request->arrival_date);
            }

            if($request->no_of_copies){
                $query->where('no_of_copies',$request->no_of_copies);
            }

            if($request->category_id){
                $query->where('category_id',$request->category_id);
            }

            if($request->description){
                $query->where('description',$request->description);
            }

            $data = $query->get();
            $categories = Category::all();
            return view('book.index',compact('data','categories'));

        }else{
            // Logic for add/edit

            $error_message = "";

            if($request->name == ''){
                $error_message .= ", Name is required";
            }

            if($request->arrival_date ==''){
                $error_message .= ", arrival date is required";
            }

            if($request->no_of_copies ==''){
                $error_message .= ", No of copies is required";
            }

            if($request->description ==''){
                $error_message .= ", description is required";
            }

            if($error_message != ''){
                $data = Book::all();
                $categories = Category::all();
                return view('book.index',compact('data','categories','error_message'));
                
            }


            $name = $request->name;
            $arrival_date = $request->arrival_date;
            $no_of_copies = $request->no_of_copies;
            $category_id = $request->category_id;
            $description = $request->description;

            if(isset($request->edit_id)){
                // Logic to update to database
                $book = Book::find($request->edit_id);
                $book->name = $name;
                $book->arrival_date = $arrival_date;
                $book->no_of_copies = $no_of_copies;
                $book->category_id = $category_id;
                $book->description = $description;
                $book->update();

            }else{
                // Logic to add to database
                Book::create(
                    [
                        'name'=>$name,
                        'arrival_date'=>$arrival_date,
                        'no_of_copies'=>$no_of_copies,
                        'category_id'=>$category_id,
                        'description'=>$description
                    ]
                );
            }

            return redirect()->route('book.index');

        }

    }


    public function edit(Request $request,$id){
        $book = Book::find($id);
        $data = Book::all();
        $categories = Category::all();
        return view('book.index',compact('data','categories','book'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->route('book.index');
    }
}
