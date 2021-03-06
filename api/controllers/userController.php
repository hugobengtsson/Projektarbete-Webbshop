<?php 

include_once("../classes/createInstanceFunctions.php");
include_once("../controllers/mainController.php");


class UserController extends MainController {

    private $createFunction = "createUser";

    function __construct() {
        parent::__construct("users", "user");
    }


    public function addUser($user) {
        try {

            
            $hashedPwd = password_hash($user->UserPassword, PASSWORD_DEFAULT);

            
            $userToAdd = createUser(null, $user->UserEmail, $hashedPwd, null, $user->UserFirstName, $user->UserLastName,
            $user->TermsConditions, null, null,  $user->UserCountry, $user->UserCity, $user->UserStreet, $user->UserZipCode);
            error_log(json_encode($userToAdd));
            return $this->database->insertNewUser($userToAdd);
          
            

        } catch(Exception $e) {
            throw new Exception("The user is not in correct format...", 500);
        }
    }


    public function addNewsLetter($user){
        if($user->Newsletter == 1){
            $name = json_encode($user->UserFirstName);
            $email = json_encode($user->UserEmail);
            $query = "INSERT INTO subtonewsletter (Name, Email) VALUES ($name, $email)";
            $result = $this->database->freeQuery($query, null);
            return $result;
            
        }
    }


    public function checkUserExists($user){

        $result = $this->database->getUserEmail(json_encode($user->UserEmail));
        if($result->rowCount() > 0) {
            return true;
        }
        
    }

    public function logInUser($user) {

        $userObj =  $this->database->fetchUser(json_encode($user->UserEmail), $this->createFunction);

        if(password_verify($user->UserPassword, $userObj[0]->UserPassword)) {
            
            return true;
                
        } else {
            return false;
         }
        
    }

    public function checkUserAdmin($user) {
        $userObj =  $this->database->fetchUser(json_encode($user->UserEmail), $this->createFunction);

        if($userObj[0]->UserIsAdmin == 1) {
            $_SESSION["loggedInAdmin"] = serialize($userObj);
        } else {
            $_SESSION["loggedInUser"] = serialize($userObj);

        }
    }




}



?>