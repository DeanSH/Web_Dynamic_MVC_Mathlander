// Javascript file to contain all the form validation methods

function validateLogin() {
    //Run checks on the login form, first get the field values
    var lcName = $('#name').val();
    var lcPass = $('#pass').val();
    
    // Run checks on User Name - NOTE Errors indicate what each was checking for
    if (lcName.length > 20) {
        $('#error').html("Usernames must be less than 20 characters long!");
        return false;
    }
    if (lcName.length < 4) {
        $('#error').html("Usernames must be atleast 4 characters long!");
        return false;
    }
    if (! /^[A-Za-z]+[A-Za-z0-9\._]{2,28}[A-Za-z0-9]+$/.test(lcName)) {
        $('#error').html("Invalid Username! Valid Characters:(A-Z a-z 0-9 _ .)<br>Starts with a Letter,Ends with a Letter or Number!");
        return false;
    }
    if (! /^[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+$/.test(lcName)) {
        $('#error').html("Invalid Username! Maximum of 3 Non-Consequtive Underscores is allowed.");
        return false;
    }
    if (! /^[A-Za-z0-9_]*[\.]?[A-Za-z0-9_]*$/.test(lcName)) {
        $('#error').html("Invalid Username! Maximum of 1 Dot is allowed.");
        return false;
    }
    if (/(_\.|\._)/.test(lcName)) {
        $('#error').html("Invalid Username! A Dot and Underscore side-by-side is not allowed.");
        return false;
    }
    // Checks passwords min and max lengths, maximum size in DB is 20.
    if (lcPass.length > 20 || lcPass.length < 6) {
        $('#error').html("Password's must be between 6 to 20 characters long!");
        return false;
    }
}

function validateRegister() {
    //Run checks on the required fields of the register form, first get the field values
    var lcName = $('#name').val();
    var lcPass = $('#pass').val();
    var lcEmail = $('#email').val();
    var lcFirst = $('#first').val();
    var lcLast = $('#last').val();
    var lcSchool = $('#school').val();
    var lcCountry = $('#country').val();
    var lcDOB = $('#dob').val();
    
    // Run checks on User Name - NOTE Errors indicate what each was checking for
    if (lcName.length > 20) {
        $('#error').html("Usernames must be less than 20 characters long!");
        return false;
    }
    if (lcName.length < 4) {
        $('#error').html("Usernames must be atleast 4 characters long!");
        return false;
    }
    if (! /^[A-Za-z]+[A-Za-z0-9\._]{2,28}[A-Za-z0-9]+$/.test(lcName)) {
        $('#error').html("Invalid Username! Valid Characters:(A-Z a-z 0-9 _ .)<br>Starts with Letter,Ends with Letter or Number.");
        return false;
    }
    if (! /^[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+[_]?[A-Za-z0-9\.]+$/.test(lcName)) {
        $('#error').html("Invalid Username! Maximum of 3 Non-Consequtive Underscores is allowed.");
        return false;
    }
    if (! /^[A-Za-z0-9_]*[\.]?[A-Za-z0-9_]*$/.test(lcName)) {
        $('#error').html("Invalid Username! Maximum of 1 Dot is allowed.");
        return false;
    }
    if (/(_\.|\._)/.test(lcName)) {
        $('#error').html("Invalid Username! A Dot and Underscore side-by-side is not allowed.");
        return false;
    }
    
    // Checks for password, maximum size in DB is 20.
    if (lcPass.length > 20 || lcPass.length < 6) {
        $('#error').html("Passwords must be between 6 to 20 characters long!");
        return false;
    }
    
    // Checks for email address to be the expected format and checks lengths, maximum size in DB is 50 characters.
    if (! /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(lcEmail)) {
        $('#error').html("Invalid Email Address!");
        return false;
    }
    if (lcEmail.length > 50 || lcEmail.length < 5) {
        $('#error').html("Emails must be between 5 to 50 characters long!");
        return false;
    }
    
    // Checks for first name lengths, maximum size in DB is 40.
    if (lcFirst.length > 40 || lcFirst.length < 2) {
        $('#error').html("First names must be between 2 to 40 characters long!");
        return false;
    }
    
    // Checks for last name lengths, maximum size in DB is 40.
    if (lcLast.length > 40 || lcLast.length < 2) {
        $('#error').html("Last names must be between 2 to 40 characters long!");
        return false;
    }
    
    // Checks for school name lengths, maximum size in DB is 50.
    if (lcSchool.length > 50 || lcSchool.length < 2) {
        $('#error').html("School names must be between 2 to 50 characters long!");
        return false;
    }
    
    // Checks for country lengths, maximum size in DB is 40.
    if (lcCountry.length > 40 || lcCountry.length < 2) {
        $('#error').html("Country names must be between 2 to 40 characters long!");
        return false;
    }
    
    // Checks the DOB length, which can never be less than 8 in length.
    if (lcDOB.length < 8) {
        $('#error').html("Invalid DOB Length!");
        return false;
    }
}

function validateProfileChange() {
    //Run checks on the required fields of the register form, first get the field values
    var lcEmail = $('#email').val();
    var lcFirst = $('#first').val();
    var lcLast = $('#last').val();
    var lcSchool = $('#school').val();
    var lcCountry = $('#country').val();
    
    // Checks for email address to be the expected format and checks lengths, maximum size in DB is 50 characters.
    if (! /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(lcEmail)) {
        $('#error').html("Invalid Email Address!");
        return false;
    }
    if (lcEmail.length > 50 || lcEmail.length < 5) {
        $('#error').html("Emails must be between 5 to 50 characters long!");
        return false;
    }
    
    // Checks for first name lengths, maximum size in DB is 40.
    if (lcFirst.length > 40 || lcFirst.length < 2) {
        $('#error').html("First names must be between 2 to 40 characters long!");
        return false;
    }
    
    // Checks for last name , maximum size in DB is 40.
    if (lcLast.length > 40 || lcLast.length < 2) {
        $('#error').html("Last names must be between 2 to 40 characters long!");
        return false;
    }
    
    // Checks for school name lengths, maximum size in DB is 50.
    if (lcSchool.length > 50 || lcSchool.length < 2) {
        $('#error').html("School names must be between 2 to 50 characters long!");
        return false;
    }
    
    // Checks for country lengths, maximum size in DB is 40.
    if (lcCountry.length > 40 || lcCountry.length < 2) {
        $('#error').html("Country names must be between 2 to 40 characters long!");
        return false;
    }
    
}

function validatePassChange() {
    //Run checks on the required fields of the password changing form, first get the field values
    var lcOldPass = $('#oldpass').val();
    var lcPass = $('#pass').val();
    var lcNewPass = $('#newpass').val();
    
    // Checks for new password length, maximum size in DB is 20.
    if (lcPass.length > 20 || lcPass.length < 6) {
        $('#error2').html("New Password must be between 6 to 20 characters long!");
        return false;
    }
    
    // Checks for new password typed twice to be matching
    if (! lcPass == lcNewPass) {
        $('#error2').html("The New Password and Retyped Password did not match!");
        return false;
    }
    
    // Checks old password has been entered, later validated if correct server side in DB.
    if (lcOldPass.length > 20 || lcOldPass.length < 6) {
        $('#error2').html("Your Old Password should be 6 to 20 characters long!");
        return false;
    }
    
}

function validateCompetition() {
    //Run checks on the required fields of the competition form, first get the field values
    var lcEmail = $('#email').val();
    var lcClassroom = $('#classroom').val();
    var lcSchool = $('#school').val();
    var lcPhone = $('#phone').val();
    
    // Checks for email address to be the expected format and checks lengths, maximum size in DB is 50 characters.
    if (! /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(lcEmail)) {
        $('#error').html("Invalid Email Address!");
        return false;
    }
    if (lcEmail.length > 50 || lcEmail.length < 5) {
        $('#error').html("Emails must be between 5 to 50 characters long!");
        return false;
    }
    
    // Checks for classroom name to be in the format 2 letters followed by 2 digits
    if (! /^[A-Z]{2}[0-9]{2}$/.test(lcClassroom)) {
        $('#error').html("Classroom name must be 2 Capital Letters, then 2 Digits! eg. RM03");
        return false;
    }
    
    // Checks the phone numbers format is digits, while optionally supporting a + symbol, spaces and hyphens 
    if (! /^(\+?[0-9]*)?[0-9\- ]*$/.test(lcPhone)) {
        $('#error').html("Invalid phone number (+, 0-9, Spaces & Hyphens Only)");
        return false;
    }
    // Check lengths of the phone number, maximum size in DB is 25 characters.
    if (lcPhone.length > 25 || lcPhone.length < 6) {
        $('#error').html("Phone numbers must be between 6 to 25 characters long!");
        return false;
    }
    
    // Checks for school name lengths, maximum size in DB is 50 characters.
    if (lcSchool.length > 50 || lcSchool.length < 2) {
        $('#error').html("School names must be between 2 to 50 characters long!");
        return false;
    }
    
}