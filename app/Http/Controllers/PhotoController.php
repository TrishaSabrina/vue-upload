<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\uploadimage;

class PhotoController extends Controller
{
    
  public function index()  // this function show data in Table
  {
      return uploadimage::paginate(2);
  }

  public function store(Request $request)  // this function store or save new data in table
  {
      $this->validate($request,[
          'name' => 'required|string|max:191',
          'photo' => 'required'
      ]);

      if($request->photo){
          //  this code make image or convert file in controller and for play that i install require image in First
          $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
          \Image::make($request->photo)->save(public_path('img/public/').$name); // this code add image that we upload in folder (public/img/public)
          $request->merge(['photo' => $name]);
         
      }

      uploadimage::create($request->all());

      return ['message' => 'Success'];

  }

  public function show(Request $request,$id)  // this function show data according id 
  {
      $upload = uploadimage::find($id);
  }

  public function update(Request $request, $id)  // update your image or string 
  {
      $upload = uploadimage::find($id);

      $this->validate($request,[
          'name' => 'required|string|max:191',
          'photo' => 'required'
      ]);

      $currentPhoto = $upload->photo;  // $currentPhoto is that image there are in table and file of framework

      if($request->photo != $currentPhoto){
           //  this code make image or convert file in controller and for play that i install require image in First
          $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
          \Image::make($request->photo)->save(public_path('img/public/').$name);  // this code add image that we upload in folder (public/img/public)
          $request->merge(['photo' => $name]);

          $userPhoto = public_path('img/public/').$currentPhoto;

          if(file_exists($userPhoto)){  // for update image in folder if exists delete that there in table and add new image insted of that

              @unlink($userPhoto);
              
          }
         
      }

      $upload->update($request->all());

      return ['message' => 'Success'];
  }

  public function destroy($id)     // delete according id
  {
      $upload = uploadimage::findOrFail($id);

      $upload->delete();

      $currentPhoto = $upload->photo;  // by this code controller find currentPhoto in file of framework

      $userPhoto = public_path('img/public/').$currentPhoto;  // delete image in public(file of framework)

      if(file_exists($userPhoto)) {

          @unlink($userPhoto);
              
      }

      return [
       'message' => 'Photo deleted successfully'
      ];
  }

}