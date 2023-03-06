<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Profile</div>

                    <div class="card-body">



  <div class="tab-pane active" id="settings">
      <!-- this form is to add new data or upload image -->
      <form class="form-horizontal">  
        <div class="form-group row">
          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
               <!-- here  is form that come frome data in script-->
            <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error> 
          </div>
        </div>

        <div class="form-group row">
          <label for="inputSkills" class="col-sm-2 col-form-label">Avatar</label>
          <div class="col-sm-10">
              <!-- this input is to upload new image or file -->
              <!-- here  is form that come frome data in script-->
            <input type="file" @change='uploadPhoto' name="photo" class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
            <has-error :form="form" field="photo"></has-error> 
          </div>
        </div>
        <!-- new upload image come here to show before add in table -->
         <div v-if="imageprevi" class="mt-3">  
                <img :src="imageprevi" class="figure-img img-fluid rounded"  style="max-height:100px;">
            </div>
       
        <div class="form-group row">
          <div class="offset-sm-2 col-sm-10">
            <button type="submit" @click.prevent="profileUpload" class="btn btn-danger">Submit</button>
          </div>
        </div>
      </form>
      </div>

  <div class="card-body table-responsive p-0">
    <table class="table table-hover">
      <tbody>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Photo</th>
            <th>Modify</th>
      </tr> 

      <tr v-for="item in tabledata.data" :key="item.id">
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>
		<!-- by this code we get image from file in framework according id that come frome Table -->
          <img :src="`img/public/${item.photo}`" class="profile-user-img img-fluid img-circle" style="height:40px; width:40px;">
        </td>
  
        <td>
		<!-- to edit or delete we need the below code to connect function -->
		<!-- for edit we set just item because item come frome all inform of table -->
            <a href="#" @click="editPhotoModal(item)">  
                edit
            </a>
            |
			<!-- for delete we set just item.id because item.id come frome all inform of table -->
            <a href="#" @click="deletePhoto(item.id)">
                delete
            </a>

        </td>
      </tr>
    </tbody></table>
    <!-- set that here after finish get data from backend  -->
 <pagination :data="tabledata"  @pagination-change-page="getResults" ></pagination>

    

  </div>
<!-- this is Modal to edit or update -->
    <div class="modal" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="addNewLabel">Update Photo</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
<!-- this fom is to update -->
<form>
<div class="modal-body">

     <div class="form-group">
         <!-- here is formm -->
        <input v-model="formm.name" type="text" name="name"
            placeholder="Name"
            class="form-control">
       
    </div>

      <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label">Update</label>
          <div class="col-sm-10">
            <input type="file" @change='uploadPh' name="photo" class="form-control" >
           
        </div>
      </div>
       <div v-if="user.photo" class="mt-3">
                <img :src="`img/public/${user.photo}`" class="figure-img img-fluid rounded"  style="max-height:100px;">
       </div>
       <div v-if="image" class="mt-3 im" id="mybox"> 
                <img :src="image" class="figure-img img-fluid rounded i"  style="max-height:100px;">
       </div>
    
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" @click.prevent="UpdatePhoto(formm.id)" >Update</button>
</div>

       </form>
      
     </div>
   </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
//  imageSelected
        data(){
            return {
                numbers:'',
                page:'',
                pag:'',
                tabledata: {},
                user:{},
// in vue for use each of Form must definde tha Form. in vue in the Form insted of value add v-model to request .i used 2 Form in this Project one for add other for update & clone vform and install in node_modules
// the below code is for update form                
				formm: new Form({   
                    id: '',
                    name : '',
                    photo: '',
                }), 
	// the below code is for Add form			
                form: new Form({
                    id: '',
                    name : '',
                    photo: '',
                }),
                imageprevi: null,
                image: null,
            }
        
        },
        methods: {
            uploadPhoto(e){  // upload new file or image do by this code
              let file = e.target.files[0];
                let reader = new FileReader();  
                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                     this.form.photo = reader.result;
                    }              
                     reader.readAsDataURL(file);
                     reader.onload = e => {
                     this.imageprevi = e.target.result;
                     $('.im').show();
               };
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            uploadPh(e){   //  upload updat file or image do by this code
              let file = e.target.files[0];
                let reader = new FileReader();  
                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                     this.formm.photo = reader.result;
                    }              
                     reader.readAsDataURL(file);
                     reader.onload = e => {
                     this.image = e.target.result;   // fadeOut()
                     $('.im').show();
                     
               };
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            //For getting Instant Uploaded Photo
            getPhoto(){
               let photo = (this.form.photo.length > 100) ? this.form.photo : "public/img/profile/"+ this.form.photo;
                return photo;
            },
            //Insert Photo
            profileUpload(){  // insert new file or image by this code
            this.form.post('http://localhost:8000/api/st')
               .then(()=>{
                   Toast.fire({
                      icon: 'success',
                      title: 'File uploaded successfully'
                    })
                   this.loadTableData()
               })
               .catch(()=>{
                  console.log("Error.....")
               })
            },
            //get Table data
            loadTableData(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('http://localhost:8000/api/photo?page=' + page)
                   .then(({ data }) =>( this.tabledata = data))
                   .catch(()=>{
                      console.log("Error...")
                   })
            },
            // is here 
          getResults(page) {   // we must set varriable in where that get data from backaend
              
                
                  
                  if (typeof page == 'undefined') {  // i sayed to function if page undefined get currentHost of href 
   // and if currentHost  == exampleURL(http://localhost:8000/edit#) page = 1 (the number of 1 is first page of data that get from backaend for paginate) 				  
                    var currentHost = window.location.href;
                    var exampleURL = 'http://localhost:8000/edit#';
                    if(currentHost == exampleURL){
                      
                    page = 1 ; 
                    }else{ 
					// for get number of page 1 set this function from js
                      var numbers = currentHost.match(/\/edit#\/([0-9]+)/)[1];
                      page = numbers ;
                    
                    }
                  }
				  // according page 1 can get data from backaend 
                  axios.get('http://localhost:8000/api/photo?page=' + page)
                    .then(response => {
                      this.tabledata = response.data;
                      window.history.pushState('', '', '/edit#/'+page); // i set a varriable to currentHost of href
                  });
                
            },
            //Edit Option  show
            editPhotoModal(item){  // to edit must show data in modal and that do by this function according id
               this.formm.clear();
               this.formm.reset();
               axios.get('http://localhost:8000/api/show/' + item.id)
                    .then(response => {
                      this.user = response.data;
                      console.log(this.user.name);
                     
                  });   //  im
               $('#addNew').modal('show');
              
               //$(".im").css("display", "none");
               this.formm.fill(item)
            },
            UpdatePhoto(id){  // edit or update data by this function
              this.formm.post('http://localhost:8000/api/update/'+ id ,{id:this.formm.id})
               .then(()=>{
                   Toast.fire({
                      icon: 'success',
                      title: 'Photo updated successfully'
                    })
                    this.loadTableData()
                   
                    $('#addNew').modal('hide');
                    $('.im').hide();
                    $(".image").addClass("intro");
               })
               .catch(()=>{
                  console.log("Error.....")
               })
            },
            //Delete photo
            deletePhoto(id){  // delete data by this function
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                      
              if (result.value) {
                //Send Request to server
                this.form.post('http://localhost:8000/api/store_image/delete/'+id  ,{id:this.formm.id})
                    .then((response)=> {
                            Swal.fire(
                              'Deleted!',
                              'Photo deleted successfully',
                              'success'
                            )
                    this.loadTableData();
                    }).catch(() => {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!',
                          footer: '<a href>Why do I have this issue?</a>'
                        })
                    })
                }
            })
            }
                  
        },
        created() {  // in vue must show all data that get from table and do tha by this function
          
          //LoadTableData
          this.getResults()  // so write that functione get data from table in  created() 
            
        },
     
        
    }
</script>