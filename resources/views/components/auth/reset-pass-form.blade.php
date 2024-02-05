<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="confirmpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function ResetPass() {
    let password = document.getElementById('password').value;
    let confirmpassword = document.getElementById('confirmpassword').value;

    if(password.length === 0){
        errorToast("Password is required");
    } else if(confirmpassword.length === 0){
        errorToast("Confrim Password is required");
    } else if(password !== confirmpassword){
        errorToast("Password and Confirm Password must be same");
    } else{
        showLoader();
        
        let response = await axios.post("/reset-password", {
            password: password
        });
        
      debugger;
        // hideLoader();
        if(response.status===200 && response.data["status"]==="success"){
            successToast(response.data["message"]);
            setTimeout(() => {
                window.location.href ="/userLogin";
            }, 1000);
        }else{
            errorToast(response.data["message"]);
        }
    }
    
 }
</script>
