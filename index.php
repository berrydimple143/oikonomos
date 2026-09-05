<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virgil Rosalita Portfolio Website</title>
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="./css/main.css">
    <!-- <link href="./src/output.css" rel="stylesheet"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
     <script src="./js/tailwindcss.cdn.js"></script>
    <script type="module" src="./js/main.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="pageLoad()">
    <?php include('./includes/front/modals/view-details.php'); ?>
    <?php include('./includes/front/modals/send-successful.php'); ?>
    <div class="text-white flex items-center justify-between max-w-[1920px] mx-auto h-16 border-b border-gray-300 bg-gradient-to-r from-blue-200 via-blue-500 to-blue-400">        
        <?php include('./includes/front/header.php'); ?>      
    </div>          
    <?php include('./includes/front/hero.php'); ?> 
    <?php include('./includes/front/about.php'); ?>
    <?php include('./includes/front/work.php'); ?>
    <?php include('./includes/front/experience.php'); ?>    
    <?php include('./includes/front/contact.php'); ?>   
    <script>
        function pageLoad() {
            return {
                showMobileMenu: false,
                messageAPI: './api/admin/message.php',
                contactAPI: './api/admin/contact.php',
                aboutAPI: './api/admin/about.php',
                projectAPI: './api/admin/project.php',
                expAPI: './api/admin/experience.php',
                projectDirectory: './images/uploads/',
                viewDetailsModal: null, 
                sendSuccessful: null,
                firstname: '',
                lastname: '',
                email: '',
                phone: '',
                message: '',
                subject: '',
                info_phone: '',
                info_email: '',
                linkedin: '',
                facebook: '',
                address: '',
                mobile: '',
                github: '',
                description: '',
                years_of_experience: 0,
                number_of_clients: 0,
                number_of_projects: 0,
                projects: [],                
                experiences: [],
                detailImage: '',
                detailTechs: '',
                detailTitle: '',
                detailDescription: '',
                detailCode: '',

                smartTruncate(text, maxLength, appendEllipsis = true) {
                    // Return the original text if it's already short enough
                    if (text.length <= maxLength) return text;

                    // 1. Cut the string down to the maximum allowed length
                    let trimmed = text.substring(0, maxLength);

                    // 2. Find the last space to avoid cutting a word
                    const lastSpace = trimmed.lastIndexOf(" ");
                    
                    // 3. Trim again up to that last space (if a space exists)
                    if (lastSpace !== -1) {
                        trimmed = trimmed.substring(0, lastSpace);
                    }

                    // 4. Return the trimmed text with or without an ellipsis
                    return appendEllipsis ? `${trimmed} ...` : trimmed;
                },
                async sendMessage() {
                    try {
                            this.sendSuccessful.classList.remove('hidden');
                            let response = await fetch(this.messageAPI, {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({ 
                                    id: 2,
                                    status: 1,
                                    replied: 1,
                                    subject: this.subject,
                                    message: this.message,
                                    firstname: this.firstname,
                                    lastname: this.lastname,                                
                                    email: this.email, 
                                    phone: this.phone, 
                                    mode: "add"
                                })
                            });
                            let res = await response.json();           
                            if(res.status) {
                                this.$refs.sendText.innerText = "Email sent successfully!";
                                this.$refs.sendInfo.innerText = "Your message has been sent successfully through email. Please wait patiently for the reply within 24 hours. Thank you so much.";
                            }              
                        } catch(error) {
                            console.error('Error fetching data:', error);
                        } finally {
                            setTimeout(() => {
                                this.sendSuccessful.classList.add('hidden');
                                window.location = 'index.php';    
                            }, 2000);                            
                        }
                },
                showMobile() {
                    this.showMobileMenu = !this.showMobileMenu;
                },                
                initText() {                      
                    const tl = gsap.timeline({
                        id: "text-scramble",
                        defaults: { ease: "none" }
                    });
                    const cursorTl = gsap.timeline({ repeat: -1 });
                    gsap.set("#scramble-text-original", { opacity: 0 });

                    cursorTl
                    .to("#scramble-cursor", {
                        opacity: 0,
                        duration: 0.5,
                        ease: "none",
                        delay: 0.2
                    })
                    .to("#scramble-cursor", {
                        opacity: 1,
                        duration: 0.5,
                        ease: "none",
                        delay: 0.2
                    });

                    tl.to("#scramble-text-1", {
                    scrambleText: {
                        text: "I am an interactive ",
                        chars: "0110",
                        speed: 0.4
                    },
                    duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: {
                        text: " and well-experienced",
                        chars: "0110",
                        speed: 0.4
                        },
                        duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: { text: " fullstack web application", chars: "0110", speed: 0.4 },
                        duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: { text: " developer for more", chars: " 0110", speed: 0.3 },
                        duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: { text: " than 13 years now.", chars: " 0110", speed: 0.3 },
                        duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: { text: " Hire me as your", chars: " 0110", speed: 0.3 },
                        duration: 2
                    })
                    .to("#scramble-text-1", {
                        scrambleText: { text: "Fullstack Developer", chars: " 0110", speed: 0.3
                        },
                        duration: 2
                    })
                    .add(cursorTl);
                    tl.play(0);
                },
                checkComma(techs) {
                    if(techs) {
                        if(techs.includes(",")) {
                            return true;                        
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                },
                async initContactInfo() {
                    try {
                        let response = await fetch(this.contactAPI, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({                                                       
                                id: 1,
                                phone: "samp",
                                mobile: "samp",
                                email: "samp",
                                facebook: "samp",
                                linkedin: "samp",
                                address: "samp",
                                github: "samp",
                                mode: 'search'
                            })
                        });
                        let contact = await response.json();
                        let ctc = contact.data;                              
                        if(!(Array.isArray(ctc) && ctc.length === 0)) {                            
                            this.info_phone = ctc.phone;
                            this.info_email = ctc.email;
                            this.mobile = ctc.mobile;                            
                            this.linkedin = ctc.linkedin;
                            this.facebook = ctc.facebook;
                            this.address = ctc.address;
                            this.github = ctc.github;
                        }
                      } catch(error) {
                          console.error('Error fetching data:', error);
                      }
                },
                async initAboutInfo() {
                    try {
                        let response = await fetch(this.aboutAPI, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({
                                id: 1,
                                years_of_experience: "samp",
                                number_of_clients: "samp",
                                abtdescription: "samp",                                        
                                mode: 'search'
                            })
                        });
                        let about = await response.json();
                        let abt = about.data;                              
                        if(!(Array.isArray(abt) && abt.length === 0)) {
                            this.years_of_experience = abt.years_of_experience;
                            this.number_of_clients = abt.number_of_clients;
                            this.description = abt.description;
                        }
                    } catch(error) {
                        console.error('Error fetching data:', error);
                    }
                },
                async initProjects() {
                    try {
                        let response = await fetch(this.projectAPI, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({ 
                                id: 2,
                                status: 1,
                                title: 'sample',
                                code: 'sample',
                                technology: 'sample',
                                image: 'sample',
                                description: 'sample',
                                mode: "getAll"
                            })
                        });
                        let project = await response.json();
                        this.projects = project.data;       
                        this.number_of_projects = this.projects.length;
                    } catch(error) {
                    console.error('Error fetching data:', error);
                    }
                },  
                async initExperiences() {
                    try {
                        let response = await fetch(this.expAPI, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({ 
                                id: 2,
                                status: 1,
                                company: 'na',
                                role: 'na',
                                employment_type: 'na',
                                work_setup: 'na',
                                expdescription: 'na',
                                exptechs: ['hello'],
                                date_started: '2026-05-01 08:00:00',
                                date_finished: '2026-05-01 17:00:00',
                                mode: "getAll"
                            })
                        });
                        let exp = await response.json();
                        this.experiences = exp.data;                        
                    } catch(error) {
                        console.error('Error fetching data:', error);
                    }
                },
                viewDetail(img, techs, title, desc, cd) {
                    this.detailImage = this.projectDirectory + img;
                    this.detailTechs = techs;
                    this.detailTitle = title;
                    this.detailDescription = desc;
                    this.detailCode = cd;
                    this.viewDetailsModal.classList.remove('hidden');
                },
                closeView() {
                    this.viewDetailsModal.classList.add('hidden');
                },
                initModals() {
                    this.viewDetailsModal = document.getElementById('viewDetailsModal');
                    this.sendSuccessful = document.getElementById('sendSuccessful');
                },
                init() {                    
                    this.initText(); 
                    this.initModals();
                    this.initExperiences();
                    this.initProjects();   
                    this.initAboutInfo();   
                    this.initContactInfo();                                   
                }
            }
        }
    </script>    
</body>
</html>