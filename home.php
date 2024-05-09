<?php
    session_start();

    if(isset($_SESSION['username'])){

        # database connection file
        include 'app/db.conn.php';

        include 'app/helpers/user.php';
        include 'app/helpers/conversations.php';
        include 'app/helpers/timeAgo.php';
        include 'app/helpers/last_chat.php';

        # Getting user data
        $user = getUser($_SESSION['username'], $conn);

        # Getting User conversations
        $conversations = getConversation($user['user_id'], $conn);
        print_r($conversations['last_seen']);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ChatLink - Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="image/logo1.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="cont p-2 w-400 rounded shadow">
                <div>
                    <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="uploads/<?= $user['p_p']?>" class = "w-25 rounded-circle">
                            <h3 class="fs-xs m-2"><?= $user['name'] ?></h3>
                        </div>
                        <a href="logout.php" class="btn btn-dark">Logout</a>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id = "searchText" placeholder="Search..." class="form-control">
                        <button class="btn btn-primary" id="searchBtn">Search</button>
                    </div>
                    <ul id="chatList" class="list-group mvh-50 overflow-auto">
                        <?php if(!empty($conversations)){ ?>
                            <?php foreach($conversations as $conversation){ ?>
                                <li class="list-group-item">
                                    <a href="chat.php?user=<?=$conversation['username']?>" class="d-flex justify-content-between align-items-center p-2">
                                        <div class="d-flex align-items-center">
                                            <img src="uploads/<?=$conversation['p_p'] ?>" class="w-10 rounded-circle">
                                            <h3 class="fs-xs m-2"> <?=$conversation['name'] ?><br>
                                                <small style="color:grey;">
                                                    <?php echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn); ?>
                                                </small>
                                            </h3>
                                        </div>
                                        <?php if(last_seen($conversation['last_seen']) == 'Active') { ?>
                                            <div title="online">
                                                <div class="online"></div>
                                            </div>
                                        <?php } ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots-fill" viewBox="0 0 16 16">
                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                                &nbsp;No Messages yet, Start the Conversation
                            </div>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

    <script>
            $(document).ready(function(){

                // search with the help of AJAX 
                $("#searchText").on("input",function(){
                    var searchText = $(this).val();
                    if(searchText==""){
                        $("#chatList").empty(); // Clear the list of users
                        return;
                    }
                    $.post('app/ajax/search.php',
                        {
                            key: searchText
                        },
                        function(data, status){
                            $("#chatList").html(data);
                        });
                });

                // search using button
                $("#searchBtn").on("click",function(){
                    var searchText = $("#searchText").val();
                    if(searchText==""){
                        $("#chatList").empty(); // Clear the list of users
                        return;
                    }
                    $.post('app/ajax/search.php',
                        {
                            key: searchText
                        },
                        function(data, status){
                            $("#chatList").html(data);
                        });
                });
                // auto update last seen
                let lastSeenUpdate = function(){
                    $.get("app/ajax/update_last_seen.php");
                }
                lastSeenUpdate();

                // suto update last seen every 10 sec
                setInterval(lastSeenUpdate,10000);
            });
    </script>    
    </body>
    </html>
<?php
    }else{
        header("Location: index.php");
        exit;
    }
?>