<?php
include_once __DIR__."../../core/ini.php";
include __DIR__ .'../../includes/header.php';
use Utility\Input;
use Utility\Token;
use Validation\Validation;
use Utility\Redirect;
if(Input::exist('POST') && Input::get('login')){

    if(Token::check(Input::get('token'))){
        $input = [];
        $input['email'] = $_POST['email'];
        $input['password'] = $_POST['password'];
        foreach ($input as $key => $value){
            $input[$key] = sanitaze($value);
        }

        $validation = new Validation($conn);
        $validation->check($input, array(
            'email' => array(
                'required' => true,

            ),
            'password' => array(
                'required' => true
            )
        ));
        if($validation->passed()){
            $user = $userService->login($input['email'], $input['password']);

            if($user) {
                Redirect::to('profile.php');
            }
            echo "password or email doesnt match.";

        }else{

            print_r($validation->getErrors());
        }

    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="login.php">
        <p>
            <label for="email">Email:</label>
            <input type="text" value="" name="email" id="email">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" value="" name="password" id="password">
        </p>
        <input type="hidden" name="token" value="<?php echo Token::tokenForm()?>">
        <button type="submit" name="login" value="login">login</button>
    </form>
</body>
</html>
