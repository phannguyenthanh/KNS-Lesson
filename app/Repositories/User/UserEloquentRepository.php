<?php

namespace App\Repositories\User;

use App\Models\RoleUser;
use App\Repositories\EloquentRepository;
use App\Role;
use App\User;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }
    // public $properties='users.*,areas.name as name_area,provinces.name as name_province, districts.name as name_district, schools.name as name_school, class.name as name_class, grades.name as name_grade, roles.display_name as name_role';
    // public $attr = 'users.id as user_id';

    /**
     * Get pages
     * @author Minhpt
     * @date 17/04/2018
     * @return mixed
     */
   
     public function getPages($records, $search = null)
    {
      if(!is_null($search)){
            $total=count(User::where('users.name', 'like', '%' . $search . '%')
                          ->orWhere('users.email', 'like', '%' . $search . '%')
                           ->whereNotNull('role_id')->get());

        }else{
            $total=count(User::whereNotNull('role_id')->get());
        }
        return ceil($total / $records); 
    }
     public function getObjects($records, $search = null)
    {
        if(is_null($search)){
            $result = User::whereNotNull('role_id')->paginate($records)->items();
        }else{
            $result = User::where('users.name', 'like', '%' . $search . '%')
                          ->orWhere('users.email', 'like', '%' . $search . '%')
                           ->whereNotNull('role_id')->paginate($records)->items();
        }
         return $result;
    }                

    /**
     * Get roles
     * @author Minhpt
     * @date 17/04/2018
     * @return mixed
     */
    public function getRoles()
    {
        return Role::all();
    }

  


    public function Area(){
        return \App\Models\Area::all();
    }
    public function district($provinceId){
        $districts=\App\Models\District::where('province_id','=',$provinceId)->get();
        count($districts) > 0 ? $districtId=$districts[0]->id : $districtId=0;
        $schools=\App\Models\School::where('district_id','=',$districtId)->get();
        $array['districts']=$districts;
        $array['schools']=$schools;
        return $array;
       
    }
    public function school($districtId){
        return \App\Models\School::where('district_id','=',$districtId)->get();;
    }
    public function select($areaId){
       
           $provinces=\App\Models\Province::where('area_id','=',$areaId)->get();

          count($provinces)>0 ? $provinceId=$provinces[0]->id : $provinceId=0;

            $districts=\App\Models\District::where('province_id','=',$provinceId)->get();
            count($districts)>0 ? $districtId=$districts[0]->id :  $districtId=0;
            $schools=\App\Models\School::where('district_id','=',$districtId)->get();
            $array['provinces']=$provinces;
            $array['districts']=$districts;
            $array['schools']=$schools;
            return $array;
       
    }
     public function grade(){
        return \App\Models\Grade::all();
    }
     public function getClass($gradeId){
        return \App\Models\LsClass::where('grade_id','=',$gradeId)->get();;
    }

    public function show($id){
       return $this->_model->find($id);
    }




    public function getAreaPages($records,$id,$tableID, $search = null)
    {
       if(!is_null($search)){
            $total=count(User::where('users.name', 'like', '%' . $search . '%')
                          ->orWhere('users.email', 'like', '%' . $search . '%')
                           ->whereNotNull('role_id')->where($tableID,$id)->get());

        }else{
            $total=count(User::whereNotNull('role_id')->where($tableID,$id)->get());
        }
        return ceil($total / $records); 
      
    }

  
    public function getAreaObjects($records,$id,$tableID, $search = null)
    {

      if(is_null($search)){
            $User = User::whereNotNull('role_id')
                    ->where($tableID,$id)
                    ->paginate($records)->items();
        }else{
            $User = User::where('users.name', 'like', '%' . $search . '%')
                          ->orWhere('users.email', 'like', '%' . $search . '%')
                          ->whereNotNull('role_id')
                          ->where($tableID,$id)
                          ->paginate($records)->items();
        }
         return $User;

//        if(is_null($search)){
//            $User = User::join('areas','users.area_id','=','areas.id')
//            ->join('provinces','users.province_id','=','provinces.id')
//            ->join('districts','users.district_id','=','districts.id')
//            ->join('schools','users.school_id','=','schools.id')
//            ->join('class','users.class_id','=','class.id')
//            ->join('grades','users.grade_id','=','grades.id')
//            ->join('roles','users.role_id','=','roles.id')
//            ->selectRaw($this->properties)->where($tableID,$id)->paginate($records)->items();
//            // $sql = User::join('areas','users.area_id','=','areas.id')
//            // ->join('provinces','users.province_id','=','provinces.id')
//            // ->join('districts','users.district_id','=','districts.id')
//            // ->join('schools','users.school_id','=','schools.id')
//            // ->join('class','users.class_id','=','class.id')
//            // ->join('grades','users.grade_id','=','grades.id')
//            // ->join('roles','users.role_id','=','roles.id')
//            // ->selectRaw($this->properties)->where($tableID,$id)->get()->sql();
//            // dd($sql);
//        }
//        else
//            $User= User::join('areas','users.area_id','=','areas.id')->join('provinces','users.province_id','=','provinces.id')->join('districts','users.district_id','=','districts.id')->join('schools','users.school_id','=','schools.id')->join('class','users.class_id','=','class.id')->join('grades','users.grade_id','=','grades.id')->join('roles','users.role_id','=','roles.id')->selectRaw($this->properties)->where(function ($q) use ($search) {
//                $q->where('name', 'like', '%' . $search . '%')->Where($tableID,$id);
//                // $q->orWhere('area_id',$area);
//                })->paginate($records)->items();
//
//        return $User;

       
    }
    

}