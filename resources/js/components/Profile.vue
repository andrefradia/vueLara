<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                
                <!-- Profile Widget -->
                <div class="card card-widget widget-user">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header text-white widget-user-header-style" style="background: url('./img/user-cover.jpg');">
                    <div class="col-md-">
                        
                    </div>
                    <h3 class="widget-user-username">{{form.name}}</h3>
                    <h5 class="widget-user-desc">{{form.email}}</h5>
                  </div>
                  <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">3,200</h5>
                          <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">13,000</h5>
                          <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <h5 class="description-header">35</h5>
                          <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
                <!-- /.Profile Widget -->

                <!-- Activity & Setting Cart -->
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link active show" href="#activity" data-toggle="tab">Activity</a></li>                      
                      <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                      <li class="nav-item"><a class="nav-link" href="#invoice-tab" data-toggle="tab">Invoice</a></li>

                    </ul>
                  </div><!-- /.card-header -->
                  
                  <div class="card-body">
                    <div class="tab-content">
                      <!-- Activity Pane -->                      
                      <div class="tab-pane active show" id="activity">
                        <!-- Post -->
                        <div class="post">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="/img/user.png" alt="user image">
                            <span class="username">
                              <a href="#">Jonathan Burke Jr.</a>
                              <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                            </span>
                            <span class="description">Shared publicly - 7:30 PM today</span>
                          </div>
                          <!-- /.user-block -->
                          <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                          </p>

                          <p>
                            <a href="#" class="link-black text-sm mr-2"><i class="fa fa-share mr-1"></i> Share</a>
                            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up mr-1"></i> Like</a>
                            <span class="float-right">
                              <a href="#" class="link-black text-sm">
                                <i class="fa fa-comments-o mr-1"></i> Comments (5)
                              </a>
                            </span>
                          </p>

                          <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->                        
                      </div>
                      <!-- /.Activity Pane -->                                        

                      <!-- Setting Pane -->
                      <div class="tab-pane" id="settings">
                        <form class="form-horizontal">
                          <div class="form-group">
                            <label for="name" class="col-md-12 control-label">Name</label>
                            <div class="col-md-12">
                              <input v-model="form.name" class="form-control" :class="{'is-invalid': errors.name }" type="text" id="name" placeholder="Name">
                              <form-error :errors="errors.name"></form-error>
                            </div>                            
                          </div>

                          <div class="form-group">
                            <label for="email" class="col-md-12 control-label">Email</label>
                            <div class="col-md-12">
                              <input v-model="form.email" class="form-control" :class="{'is-invalid': errors.email }" type="email" id="email" placeholder="Email">
                              <form-error :errors="errors.email"></form-error>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="bio" class="col-md-12 control-label">Experience</label>
                            <div class="col-md-12">
                              <textarea v-model="form.bio" class="form-control" id="bio" placeholder="Experience" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                              <has-error :form="form" field="bio"></has-error>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="email" class="col-md-12 control-label">Profile Photo</label>
                            <div class="col-md-12">                                
                                <input @change="imageSelect" class="browse-file" type="file" name="photo" id="photo">
                                <div class="input-group">                                
                                    <input v-model="attach.name" type="text" class="form-control" placeholder="Choose file" readonly>
                                    <div class="input-group-append">
                                        <button @click="browseFile" class="btn btn-secondary" type="button">Browse&hellip;</button> 
                                    </div>
                                </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="password" class="col-md-12 control-label">Password (Leave empty if not changing)</label>
                            <div class="col-md-12">
                              <input v-model="form.password" type="password" class="form-control" id="password" :class="{'is-invalid': errors.password }">
                              <form-error :errors="errors.password"></form-error>
                            </div>                            
                          </div>
                          
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button @click.prevent="updateProfile()" type="submit" class="btn btn-success">Update</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.Setting Pane -->
                      
                      <!-- Invoice Page -->
                      <div class="tab-pane" id="invoice-tab">
                        <invoice-page></invoice-page>
                      </div>
                      <!-- /.Invoice Page -->

                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.Activity & Setting Cart -->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),
                fd: {},
                attach: '',
                errors: {},                            
            }
        },
        methods:{
            browseFile(){
                $('#photo').click();
            },
            getProfilePhoto(){
                return "/img/uploads"+this.form.photo;
            },
            imageSelect(img){                
                this.attach = img.target.files[0];
                if (!(this.attach.type == 'image/jpg') && !(this.attach.type == 'image/png') && !(this.attach.type == 'image/jpeg')) {                    
                    this.attach = '';
                    Swal.fire(
                      'Oops...',
                      'Only accept image file with jpg/jpeg/png extension!',
                      'error'
                    )
                }else{
                    if (this.attach.size>2097152) {
                        this.attach = '';
                        Swal.fire(
                          'Oops...',
                          'Your file is larger than 2MB!',
                          'error'
                        )
                    };
                };
            },
            objcetToDataForm(){
                let dataForm = new FormData();
                dataForm.append('name', this.form.name);
                dataForm.append('email', this.form.email);
                if (this.form.bio) {
                    dataForm.append('bio', this.form.bio);
                };
                if (this.attach) {
                    dataForm.append('photo', this.attach);
                };
                if (this.form.password) {
                    dataForm.append('password', this.form.password);
                };
                return dataForm;
            },
            resetFormData(){
                this.fd = {};
                this.attach = '';
            },
            updateProfile(){
                this.$Progress.start();
                this.fd = this.objcetToDataForm();
                axios.post('api/updateprofile', this.fd)
                .then(() => {
                    this.resetFormData();
                    this.errors = {};
                    Fire.$emit('loadUserData');

                    toast.fire({
                        type: 'success',
                        title: 'Successfully updated user\'s info'
                    });

                    this.$Progress.finish();
                })
                .catch((e) => {
                    this.$Progress.fail();
                    this.errors = e.response.data.errors;                    
                });
            },            
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('api/authprofile')
            .then(({data})=>{
                this.form.fill(data);
            })
            .catch(e => {
                this.error.push(e);
            });

            Fire.$on('loadUserData',()=>{
                axios.get('api/authprofile')
                .then(({data})=>{
                    this.form.fill(data);
                })
                .catch(e => {
                    this.error.push(e);
                });
            })
        }
    }
</script>
