<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Repositories\GradeLevel\GradeLevelEloquentRepository;
use Illuminate\Support\Facades\Session;

class GradeController extends Controller
{
    protected $repository;

    public function __construct(GradeLevelEloquentRepository $repository)
    {
        $this->repository = $repository;
        // dd($this->repository);
    }

    public function pagination(Request $request, $records, $search = null)
    {
        
        $per_page = is_null($records) ? 10 : $records;

        return view('admin::gradeLevel.pagination',
            [
                'grades'      => $this->repository->getObjects($per_page, $search),
                'pages'       => $this->repository->getPages($per_page, $search),
                'records'     => $per_page,
                'currentPage' => $request->page
            ]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    

    public function index()
    {


        $records = 10;
        $grades =  $this->repository->getObjects($records);
        // $user  = User::all();
        $pages = $this->repository->getPages($records);
        return view('admin::gradeLevel.index', compact('grades','pages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
       
        return view('admin::gradeLevel.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $gradeLevel = new Grade;
        
        $gradeLevel->name = $request->name;
        $gradeLevel->save();

        // session()->flash('message', 'Successfully created provicial!');
        Session::flash('flash_level', 'success');
        Session::flash('flash_message', 'Tạo mới thành công');

        return redirect('admin/grade/index');



    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $grade = Grade::findOrFail($id);
        return view('admin::gradeLevel.show',compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('admin::gradeLevel.edit',compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $grade = Grade::findOrFail($id);

        $grade->name = $request->name;
        $grade->save();

        Session::flash('flash_level', 'success');
        Session::flash('flash_message', 'Xoá thành công');

        return redirect('admin/grade/index');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
    public function delete($id)
    {
        $class = Grade::findOrFail($id);

        Session::flash('flash_level', 'success');
        Session::flash('flash_message', 'Xoá thành công');

        $class->delete();
    }
}
