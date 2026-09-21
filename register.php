<?php
    require_once './src/Functions/helpers.php';
    $siteUrl = getFullUrl('confirmation');  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oikonomos - Registration Form</title>
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">          
        <script src="./js/tailwindcss.cdn.js"></script>
        <script type="module" src="./js/main.js"></script>
        <script src="./js/myFunctions.js"></script>
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body x-data="loginLoad()">
        <?php include('./includes/front/modals/registration-successful.php'); ?>
        <?php include('./includes/front/modals/loading.php'); ?>
        <?php include('./includes/front/register.php'); ?>
        <script>
            function loginLoad() {
                return {
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    organization: '',
                    email: '',
                    username: '',
                    password: '',
                    password2: '',
                    isEyeOpen1: false,
                    isEyeOpen2: false,
                    loginUrl: './login.php',
                    registerAPI: "./api/register.php",
                    errors: {},
                    registerSuccessful: null,
                    loadingModal: null,
                    isLoading: false,


                    showPass1() {
                        this.isEyeOpen1 = true;
                        this.$refs.pass1.type = 'text';
                    },
                    showPass2() {
                        this.isEyeOpen2 = true;
                        this.$refs.pass2.type = 'text';
                    },
                    hidePass1() {
                        this.isEyeOpen1 = false;
                        this.$refs.pass1.type = 'password';
                    },
                    hidePass2() {
                        this.isEyeOpen2 = false;
                        this.$refs.pass2.type = 'password';
                    },
                    clearInputs() {
                        this.firstname = '';
                        this.lastname = '';
                        this.organization = '';
                        this.email = '';
                        this.password = '';
                    },
                    login() {
                        window.location = this.loginUrl;
                    },
                    init() {
                        this.registerSuccessful = document.getElementById('registerSuccessful');
                        this.loadingModal = document.getElementById('loadingModal');
                    },
                    async register() {       
                        this.isLoading = true;
                        this.loadingModal.classList.remove('hidden'); 
                        if(isPasswordsEqual(this.password, this.password2)) {
                            try {
                                const response = await fetch(this.registerAPI, {
                                    method: "POST",
                                    headers: {"Content-Type": "application/json"},
                                    body: JSON.stringify({ 
                                        organization: this.organization,
                                        firstname: this.firstname,
                                        lastname: this.lastname,                          
                                        email: this.email,
                                        siteUrl: "<?= $siteUrl; ?>",
                                        code: generateCode(),
                                        password: this.password
                                    })
                                });
                                
                                const res = await response.json();
                                if(res.data == "exist") {
                                    this.isLoading = false;
                                    this.loadingModal.classList.add('hidden');
                                    alert('Email already exist. Please try another.');
                                    this.email = "";
                                    this.$refs.email.focus();                                    
                                } else if(res.data == "code exist") {
                                    this.isLoading = false;
                                    this.loadingModal.classList.add('hidden');
                                    this.register();
                                } else {
                                    if(!res.status) {
                                        this.isLoading = false;
                                        this.loadingModal.classList.add('hidden');
                                        alert("Invalid inputs");
                                    } else {
                                        this.isLoading = false;
                                        this.loadingModal.classList.add('hidden');
                                        this.registerSuccessful.classList.remove('hidden');   
                                        this.clearInputs();
                                        setTimeout(() => {
                                            this.registerSuccessful.classList.add('hidden');
                                            window.location = this.loginUrl;
                                        }, 2000);
                                    }
                                }                            
                            } catch (error) {		      	  
                                console.error('Error fetching data:', error);
                            }   
                        } else {
                            this.isLoading = false;
                            this.loadingModal.classList.add('hidden');
                            alert('Password not equal');
                        }                             
                    }
                }
            }
        </script>   
    </body>
</html>