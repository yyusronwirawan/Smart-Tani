firebase.auth().onAuthStateChanged(function(user) {
    if (user) {
        var email = user.email;
        var lastName = user.last_name;
        var firstName = user.first_name;
        var password = user.password;
        var uid = user.uid;
        console.log(user.emailVerified);
    } else {
        console.log("Firebase javascript disabled");
    }
});

var userId = firebase.auth().currentUser.uid;
localStorage.setItem("userId", userId);
console.log("Signed In!");
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
console.log('ajax');
$.ajax({
    type: "POST",
    url: "/user",
    dataType: "JSON",
    data: {
        userId: localStorage.getItem('userId'),
        email: email,
        password: pass
    },
    success: function(result) {
        location.href('/profile');
        alert(result.success)
    },
    error: function(error) {
        firebase.auth().signOut().then(function() {
            alert("There was a problem, you were signed in and then the system insist to sign out");
            console.log(error);
        }).catch(function(error) {
            alert(error.message);
        });
    }
}).done(function() {
    console.log("ajax done function");
});
console.log('reached firestore');
restoreButton();

$('#loginForm').submit(function(e) {
    removeWarning();

    var email = document.getElementById('email').value;
    var pass = document.getElementById('password').value;

    firebase.auth().signInWithEmailAndPassword(email, pass).then(function(response) {
        var userId = firebase.auth().currentUser.uid;
        localStorage.setItem("userId", userId);
        console.log("Signed In!");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log('ajax');
        $.ajax({
            type: "POST",
            url: "/user",
            dataType: "JSON",
            data: {
                userId: localStorage.getItem('userId'),
                email: email,
                password: pass
            },
            success: function(result) {
                location.href('/profile');
                alert(result.success)
            },
            error: function(error) {
                firebase.auth().signOut().then(function() {
                    alert("There was a problem, you were signed in and then the system insist to sign out");
                    console.log(error);
                }).catch(function(error) {
                    alert(error.message);
                });
            }
        }).done(function() {
            console.log("ajax done function");
        });
        console.log('reached firestore');
        restoreButton();
    }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        var errorElement = `<span class="invalid-feedback"><strong>${errorMessage}</strong></span>`;
        if (errorCode === 'auth/invalid-email' || errorCode === 'auth/user-not-found') {
            $("#loginForm #email").addClass(function() {
                $(this).after(errorElement);
                return "is-invalid";
            });
        } else if (errorCode === 'auth/wrong-password') {
            $("#loginForm #password").addClass(function() {
                $(this).after(errorElement);
                return "is-invalid";
            });
        } else {
            console.log(errorMessage);
        }
        console.log(error);
        console.log("Auth Error so Stopped");
        restoreButton();
        return false;
    });
    e.preventDefault();
});