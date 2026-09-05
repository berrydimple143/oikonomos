<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oikonomos - Registration Form</title>
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico">          
        <script src="./js/tailwindcss.cdn.js"></script>
        <script type="module" src="./js/main.js"></script>
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body x-data="loginLoad()">
        <?php include('./includes/front/modals/registration-successful.php'); ?>
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
                    loginUrl: './login.php',
                    registerAPI: "./api/register.php",
                    errors: {},
                    registerSuccessful: null,
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
                    },
                    async register() {                        
                        try {
                            const response = await fetch(this.registerAPI, {
                                method: "POST",
                                headers: {"Content-Type": "application/json"},
                                body: JSON.stringify({ 
                                    organization: this.organization,
                                    firstname: this.firstname,
                                    lastname: this.lastname,                                   
                                    email: this.email,
                                    password: this.password
                                })
                            });
                            
                            const res = await response.json();
                            if(res.data == "exist") {
                                alert('Email already exist. Please try another.');
                                this.email = "";
                                this.$refs.email.focus();
                            } else {
                                if(!res.status) {
                                    alert("Invalid inputs");
                                } else {
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
                    }
                }
            }
        </script>   
    </body>
</html>