<!DOCTYPE html>
<html>
    <head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    
        <style type="text/css">
        
            #users{
                display:flex;
                flex-wrap: wrap;
                justify-content: space-around;
                
            }
            .profile{
                width: 400px;
                flex-wrap:wrap;
                display: flex;
                justify-content:center;
                flex-direction: column;
                align-content:center;
                font-size: 25px;
            }
        </style>
    </head>
    <body>
        <div id ="users">
            
        </div>
        <button id="del">Clear friends?</button>
    </body>
   
    <script src="https://www.gstatic.com/firebasejs/5.9.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.2/firebase-firestore.js"></script>
    <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyBos7qpkcF8858FSwsB6VWAiQVWmBbW9Tk",
        authDomain: "friendify-ios.firebaseapp.com",
        databaseURL: "https://friendify-ios.firebaseio.com",
        projectId: "friendify-ios",
        storageBucket: "friendify-ios.appspot.com",
        messagingSenderId: "306571184793"
    };
    firebase.initializeApp(config);
    var db = firebase.firestore();
    
    function addFriend(userID){
        
        var userRef = db.collection("users").doc("pzN0kiADlhvXQlzKF4G8");

// Atomically add a new region to the "regions" array field.
        userRef.update({
        friends: firebase.firestore.FieldValue.arrayUnion(userID)
        });
    }
    async function getFriends(friendsArr){
        let html="";
         for(let i = 0; i< friendsArr.length;i++){
              await db.collection("users").doc(friendsArr[i]).get().then( function(doc) {
            console.log(doc.data().name);
      
             html+= "<text>"+doc.data().name+"</text><br>";
        });
             
         }
         return await Promise.resolve(html);
    }
    
     db.collection("users").get().then((querySnapshot) => {
         let i=0;
    querySnapshot.forEach((doc) => {
        
             let data= doc.data();
        
        
        let html="<div class='profile'>"+
        "<img  height= 400px width= 400px style=border-radius:50% src='"+ data.profilePic+"' />" +
        "<b style='margin:auto'>"+data.name +"</b>"+
        "<text style='margin:auto; color: gray'>"+data.age +"</text>"+
        "<button class='add' value="+doc.id+" >Add Friend</button>"+
        "<hr>"+"<u>Friends</u> <div id='p"+i+"'> ";
        
        html+="</div></div>";
        $("#users").append(html);
        i++;
        });
      
    
}).then( function(){
    
    $(document).ready(function(){
    $("button").click( function(){
       
        addFriend( $(this).val() );} );
    });
    
});
db.collection("users").doc("pzN0kiADlhvXQlzKF4G8")
    .onSnapshot(async function(doc) {
      if(doc.data().friends !=null){
            $("#p2").html(await getFriends( doc.data().friends.slice(1)));
      } else
        $("#p2").html("");
    });

// Remove the 'capital' field from the document
$("#del").click(function(){
var userRef = db.collection("users").doc("pzN0kiADlhvXQlzKF4G8");
userRef.update({
    friends: firebase.firestore.FieldValue.delete()
});
});
    </script>
    
</html>