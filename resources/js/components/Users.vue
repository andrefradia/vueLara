<template>
    <div class="container">
        
        <div class="row mt-3" v-if="$gate.isAdmin()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                
                <div class="col-md-4 col-6 input-group">
                  <input v-model="search" class="form-control" type="search" placeholder="Search">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" disabled>
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>

                <div class="card-tools">                                    
                  <button class="btn btn-success" @click="createModal">
                      Add New 
                      <i class="fas fa-user-plus fa-fw"></i>
                  </button>
                </div>                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Modify</th>
                    </tr>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type | upText}}</td>
                      <td>{{user.created_at | toDate}}</td>                    
                      <td>
                          <a href="#" @click="updateModal(user)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#" @click="deleteUser(user.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>                  
                  </tbody>
                </table>                
              </div>
              <div class="card-footer">              
                <pagination :records="totalRec" v-model="page" :per-page="5" @paginate="getResults"></pagination>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- 404 error page -->
        <error-page v-if="!$gate.isAdmin()"></error-page>

        <!-- Modal -->
        <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="addNewTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="addNewTitle">Add New</h5>
                <h5 v-show="editMode" class="modal-title" id="addNewTitle">Update User's Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editMode ? editUser() : createUser()">
                  <div class="modal-body">
                    
                    <div class="form-group">
                      <input v-model="form.name" type="text" name="name" id="name" placeholder="Name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                      <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">                  
                      <input v-model="form.email" type="text" name="email" id="email" placeholder="Email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                      <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">                  
                      <textarea v-model="form.bio" name="bio" id="bio" 
                        placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                      <has-error :form="form" field="bio"></has-error>
                    </div>

                    <div class="form-group">                  
                        <select v-model="form.type" type="text" name="type" id="type" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="" selected disabled="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                    <div class="form-group">
                      <input v-model="form.photo" type="text" name="photo" id="photo" placeholder="Photo"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
                      <has-error :form="form" field="photo"></has-error>
                    </div>

                    <div class="form-group">
                      <input v-model="form.password" type="password" name="password" id="password" placeholder="Password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                      <has-error :form="form" field="password"></has-error>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                    <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                  </div>
              </form>

            </div>
          </div>
        </div>        
    </div>
</template>

<script>
import _ from 'lodash';

    export default {        
        data(){
            return{
                page: 1,
                totalRec: 0,
                pageUrl: '',
                editMode: false,
                search: '',
                users:{},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },        
        methods:{
            paginationURL(){
                if(!this.search){
                  this.pageUrl = 'api/user';
                }else{
                  this.pageUrl = 'api/searchuser/'+this.search;
                }
            },
            getResults(page) {
                this.paginationURL();

                axios.get(this.pageUrl+'?page='+page)
                .then(({data}) => {
                    this.users = data;
                });
            },            
            loadUser(){
                if (this.$gate.isAdmin()) {
                  axios.get('api/user')
                  .then(({data}) => {
                    this.users = data;
                    this.totalRec = this.users.total;
                    console.log(this.users);
                  })
                  .catch(e => {this.error.push(e)});                  
                };
            },
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#dataModal').modal('show');
            },
            updateModal(user){
                this.editMode = true;
                this.form.id = user.id;
                this.form.fill(user);
                $('#dataModal').modal('show');                
            },
            createUser(){
                if (this.$gate.isAdmin()) {                  
                  this.$Progress.start()
                  this.form.post('api/user')
                  .then(() => {
                      this.$Progress.finish()
                      Fire.$emit('loadUserData')
                      $('#dataModal').modal('hide')
                      toast.fire({
                        type: 'success',
                        title: 'User created successfully'
                      })
                  })
                  .catch(e => {
                      this.$Progress.fail()
                      this.error.push(e)
                  });
                };
            },
            editUser(){
                if (this.$gate.isAdmin()) {
                  this.$Progress.start()
                  this.form.put('api/user/'+this.form.id)
                  .then(() =>{
                      Fire.$emit('loadUserData')
                      $('#dataModal').modal('hide')
                      this.$Progress.finish()
                      toast.fire({
                        type: 'success',
                        title: 'Successfully updated user\'s info'
                      })
                  })
                  .catch(e => {
                      this.$Progress.fail();
                      this.error.push(e)
                  });
                };
            },
            deleteUser(id){
                if (this.$gate.isAdmin()) {
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                      if(result.value){

                          this.$Progress.start();
                          axios.delete('api/user/'+id)
                          .then(() => {
                              Fire.$emit('loadUserData')
                              this.$Progress.finish();

                              Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              )
                          })
                          .catch(e => {
                              this.$Progress.fail();
                              this.error.push(e)

                              Swal.fire(
                                'Oops...',
                                'Something went wrong!',
                                'error'
                              )
                          });
                      }
                  })
                };
            },            
            searchUser: _.debounce(function(){
              if (this.search) {
                axios.get('api/searchuser/'+this.search)
                .then(({data}) => {
                  this.users = data;
                  this.totalRec = this.users.total;
                  this.page = 1;
                })
                .catch();
              }else{
                this.loadUser();
              };
            },500),
        },
        watch:{
          search(){            
            this.searchUser();            
            console.log(this.search+" "+this.search.length+" "+_.isEmpty(this.search));          
          }
        },
        created() {            
            this.loadUser();
            Fire.$on('loadUserData',()=>{
                this.loadUser();                
            })
        }
    }
</script>
