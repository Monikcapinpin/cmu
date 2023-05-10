        <?php 
        $page_id = null;
        $comp_model = new SharedController;
        ?>
        <div  class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 bg-success login-card-holder comp-grid">
                        <div  class="">
                            <div class="container">
                                <div class="row ">
                                    <div class="col-sm-8 svg comp-grid">
                                    </div>
                                    <div class="col-sm-4 bg-white comp-grid">
                                        <h4 class="mt-4 mb-3 bold">Welcome Back!</h4>
                                        <?php $this :: display_page_errors(); ?>
                                        
                                        <div  class="bg-light p-3 hide-line animated fadeIn page-content">
                                            <div>
                                                <h4><i class="fa fa-key"></i> User Login</h4>
                                                <hr />
                                                <?php 
                                                $this :: display_page_errors(); 
                                                ?>
                                                <form name="loginForm" action="<?php print_link('index/login/?csrf_token=' . Csrf::$token); ?>" class="needs-validation form page-form" method="post">
                                                    <div class="input-group form-group">
                                                        <input placeholder="Username Or Email" name="username"  required="required" class="form-control" type="text"  />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="form-control-feedback fa fa-user"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group form-group">
                                                        <input  placeholder="Password" required="required" v-model="user.password" name="password" class="form-control " type="password" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="form-control-feedback fa fa-key"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix mt-3 mb-3">
                                                        <div class="col-6">
                                                            <label class="">
                                                                <input value="true" type="checkbox" name="rememberme" />
                                                                Remember Me
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="<?php print_link('passwordmanager') ?>" class="text-danger"> Reset Password?</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button class="btn btn-primary btn-block btn-md" type="submit"> 
                                                            <i class="load-indicator">
                                                                <clip-loader :loading="loading" color="#fff" size="20px"></clip-loader> 
                                                            </i>
                                                            Login <i class="fa fa-key"></i>
                                                        </button>
                                                    </div>
                                                    <hr />
                                                    <div class="text-center">
                                                        Don't Have an Account? <a href="<?php print_link("index/register") ?>" class="btn btn-success">Register
                                                        <i class="fa fa-user"></i></a>
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
            </div>
        </div>
        <div  class=" py-5">
            <div class="container">
                <div class="row justify-content-around">
                    <div class="col-sm-12 comp-grid">
                        <h4  class="text-center p-3 small">Developed by CMU-Student</h4 >
                        <div class=""><style>
                            .login-card-holder{
                            border-radius:30px;
                            box-shadow:0 0 30px rgba(0, 0, 0, 0.5);
                            overflow:hidden;
                            margin-top:70px;
                            }
                            button.btn{
                            border-radius:30px;
                            box-shadow:0 0 30px rgba(0,0,0,0.3);
                            }
                            .hide-line hr {
                            display:none;
                            }
                            .hide-line h4{
                            display:none;
                            }
                        </style>
                        
                        <script>
                            $("button.btn").removeClass("btn-block btn-md")
                        </script>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    