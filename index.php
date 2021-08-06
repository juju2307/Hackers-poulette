<?php
//Importer PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require ('vendor/autoload.php');

function validate_input($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function validate_data($name,$lastname,$gender,$email,$country,$message){
  if($_SERVER["REQUEST_METHOD"] =="POST") {
      $isvalid=true;

    if(empty($name)){
      echo "Error: You must type your Name!";
      $isvalid=false;
    }else{
        $name = validate_input($_POST["name"]);
    }
    if(strlen($name)>20){
        echo "Error: You cannot exceed 20 characters!";
    }else{
     $name = validate_input($_POST["name"]);
    }
    if(ctype_alpha($name)){
     $name = validate_input($_POST["name"]);
    }else{
     echo "Error: Check the alphabetic characters!";
    }
    if(empty($lastname)){
        echo "Error: You must type your Lastname!";
    }else{
     $lastname= validate_input($_POST["lastname"]);
    }
    if(strlen($lastname)>20){
        echo "Error: You cannot exceed 20 characters!"; 
    }else{
     $lastname= validate_input($_POST["lastname"]);
    }
    if(ctype_alpha($lastname)){
     $lastname= validate_input($_POST["lastname"]); 
    }else{ 
     echo "Error: Check the alphabetic characters!"; 
    }
    if(empty($gender)){
     echo "Error: You must type your Gender!";
    }else{
     $gender= validate_input($_POST["gender"]);
    }
    if(empty($email)){
     echo "Error: You must type your Email!";
    }else{
     $email= validate_input($_POST["email"]);
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
     $email= validate_input($_POST["email"]);
    }else{
     echo "Error: Your Email adress is not valid";
    }
    if(empty($country)){
     echo "Error: You must type your Country";
    }else{
     $country= validate_input($_POST["country"]);
    }
    if(empty($message)){
        echo "Error: You must type your Message";
    }else{
     $message= validate_input($_POST["message"]); 
    }
  }
}
function send_mail($subject, $message_body, $email){
    $mail = new PHPMailer(true);

    try {
        $mail ->isSMTP();
        $mail ->Host = 'smtp.mailtrap.io';
        $mail ->Port = 2525;
        $mail ->SMTPAuth = true;
        $mail ->Username = 'ffbc9916a8e411';
        $mail ->Password = 'b8af1df68463d7';
        $mail ->setFrom('hackers-poulette@gmail.com', 'Hackers-poulette');
        $mail ->addAddress($email);

        //contenu du message
        $mail ->isHTML(true);
        $mail ->Subject = 'customers problem about : ' .$subject;
        $mail ->Body = $message_body ;

        $mail ->send();
       // echo'<div class="success">Message has been sent</div>';
        header("Location: form-thanks.html");
    
    }catch (Exception $e) {
        echo '<div class="fail">Message could not be sent. Mailer Error: {$mail ->ErrorInfo}</div>';
    }
}  // fin de la fonction sendmail
 

if(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["gender"]) && isset($_POST["email"]) && isset($_POST["country"]) && isset($_POST["subject"]) && isset($_POST["message"])){
    $name = validate_input($_POST["name"]);
    $lastname = validate_input($_POST["lastname"]);
    $gender = validate_input($_POST["gender"]);
    $email = validate_input($_POST["email"]);
    $country = validate_input($_POST["country"]);
    $subject = validate_input($_POST["subject"]);
    $message = validate_input($_POST["message"]);
    $client_message = "We have recieve your message, dont respond to this automatic message";
    $message_body = 
            'Firstname: ' .$name . '<br>' .
            'Lastname: ' .$lastname .'<br>' . 
            'Gender : ' .$gender .'<br>' . 
            'Country : ' .$country .'<br>' . 
            'Message : ' .$message .'<br>' . '<br>' .
            'We have recieve your message, dont respond to this automatic message'; 


        if(validate_data($name,$lastname,$gender,$email,$country,$message)){
           send_mail($subject, $message_body, $email);
        }       
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.fontsquirrel.com/fonts/bellota">
    <link rel="stylesheet" href="form-thanks.html">
    <link rel="stylesheet"  href="assets/css/style.css">
    <title>Hachers Poulette</title>
</head>
<body>
   <div class="container">
      
       <div class="header">
           <div class="text">
             <h1>Contact Support</h1>
             <div class="paragraf">
                <p>We love questions and feedback - and we're always happy to help!</p>
                <p>Here are some ways to contact us.</p>
             </div>
            </div>
             <div class="logo">
                <img src="assets/img/hackers-poulette-logo.png" width="200" heigth="200" alt="logo of Hackers Poulettes">
             </div>
       </div>
       
   <div class="form">
       <form action="" method="post">
           <div class="formheader">
              <h2>Send us a message</h2>
              <p>Send us a message and we'll respond within 24 hours.</p>
           </div>
           <div class="formbody">
             <div class="firstline">
               <div class="formname">
                  <label for="name">Name</label>
                  <br>
                  <input type="text" name="name" value="" pattern="^[A-Za-z ' -]+$"  maxlength="20" autocomplete>
                  </div>
           
               <div class="formlastname">
                  <label for="lastname">Last Name</label>
                  <br>
                  <input type="text" name="lastname" value="" required pattern="^[A-Za-z ' -]+$" maxlength="20" autocomplete>
               </div>
               <input type="text" name="website" id="website" value="">
               <div class="formgender">
                   <label for="gender">Gender</label>
                   <br>
                 <div class="button">
                   <input type="radio" name="gender" value="woman">
                   <label for="woman">Woman</label>
                   <br>
                   <input type="radio" name="gender" value="man">
                   <label for="man">Man</label>
                 </div>
               </div>
              </div>
             </div>
           <div class="secondline">
                <div class="formemail">
                    <label for="email">E-mail</label>
                    <br>
                    <input type="email" name="email" value="default@exemple.com" required pattern="^[A-Za-z0-9]+@{1}[A-Za-z]+\.{1}[A-Za-z]{2,}$" required autocomplete>
                </div>
                <div class="formcountry">
                    <label for="country">Country</label>
                    <br>
                    <select name="country" id="country-select" required>
                        <option value="">--Please select your Country</option>
                        <option value="Afghanistan">Afghanistan </option>
                        <option value="Afrique_Centrale">Afrique_Centrale </option>
                        <option value="Afrique_du_sud">Afrique_du_Sud </option>
                        <option value="Albanie">Albanie </option>
                        <option value="Algerie">Algerie </option>
                        <option value="Allemagne">Allemagne </option>
                        <option value="Andorre">Andorre </option>
                        <option value="Angola">Angola </option>
                        <option value="Anguilla">Anguilla </option>
                        <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                        <option value="Argentine">Argentine </option>
                        <option value="Armenie">Armenie </option>
                        <option value="Australie">Australie </option>
                        <option value="Autriche">Autriche </option>
                        <option value="Azerbaidjan">Azerbaidjan </option>

                        <option value="Bahamas">Bahamas </option>
                        <option value="Bangladesh">Bangladesh </option>
                        <option value="Barbade">Barbade </option>
                        <option value="Bahrein">Bahrein </option>
                        <option value="Belgique">Belgique </option>
                        <option value="Belize">Belize </option>
                        <option value="Benin">Benin </option>
                        <option value="Bermudes">Bermudes </option>
                        <option value="Bielorussie">Bielorussie </option>
                        <option value="Bolivie">Bolivie </option>
                        <option value="Botswana">Botswana </option>
                        <option value="Bhoutan">Bhoutan </option>
                        <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                        <option value="Bresil">Bresil </option>
                        <option value="Brunei">Brunei </option>
                        <option value="Bulgarie">Bulgarie </option>
                        <option value="Burkina_Faso">Burkina_Faso </option>
                        <option value="Burundi">Burundi </option>
                        <option value="Caiman">Caiman </option>
                        <option value="Cambodge">Cambodge </option>
                        <option value="Cameroun">Cameroun </option>
                        <option value="Canada">Canada </option>
                        <option value="Canaries">Canaries </option>
                        <option value="Cap_vert">Cap_Vert </option>
                        <option value="Chili">Chili </option>
                        <option value="Chine">Chine </option>
                        <option value="Chypre">Chypre </option>
                        <option value="Colombie">Colombie </option>
                        <option value="Comores">Colombie </option>
                        <option value="Congo">Congo </option>
                        <option value="Congo_democratique">Congo_democratique </option>
                        <option value="Cook">Cook </option>
                        <option value="Coree_du_Nord">Coree_du_Nord </option>
                        <option value="Coree_du_Sud">Coree_du_Sud </option>
                        <option value="Costa_Rica">Costa_Rica </option>
                        <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                        <option value="Croatie">Croatie </option>
                        <option value="Cuba">Cuba </option>

                        <option value="Danemark">Danemark </option>
                        <option value="Djibouti">Djibouti </option>
                        <option value="Dominique">Dominique </option>

                        <option value="Egypte">Egypte </option>
                        <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                        <option value="Equateur">Equateur </option>
                        <option value="Erythree">Erythree </option>
                        <option value="Espagne">Espagne </option>
                        <option value="Estonie">Estonie </option>
                        <option value="Etats_Unis">Etats_Unis </option>
                        <option value="Ethiopie">Ethiopie </option>

                        <option value="Falkland">Falkland </option>
                        <option value="Feroe">Feroe </option>
                        <option value="Fidji">Fidji </option>
                        <option value="Finlande">Finlande </option>
                        <option value="France">France </option>

                        <option value="Gabon">Gabon </option>
                        <option value="Gambie">Gambie </option>
                        <option value="Georgie">Georgie </option>
                        <option value="Ghana">Ghana </option>
                        <option value="Gibraltar">Gibraltar </option>
                        <option value="Grece">Grece </option>
                        <option value="Grenade">Grenade </option>
                        <option value="Groenland">Groenland </option>
                        <option value="Guadeloupe">Guadeloupe </option>
                        <option value="Guam">Guam </option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernesey">Guernesey </option>
                        <option value="Guinee">Guinee </option>
                        <option value="Guinee_Bissau">Guinee_Bissau </option>
                        <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                        <option value="Guyana">Guyana </option>
                        <option value="Guyane_Francaise ">Guyane_Francaise </option>

                        <option value="Haiti">Haiti </option>
                        <option value="Hawaii">Hawaii </option>
                        <option value="Honduras">Honduras </option>
                        <option value="Hong_Kong">Hong_Kong </option>
                        <option value="Hongrie">Hongrie </option>

                        <option value="Inde">Inde </option>
                        <option value="Indonesie">Indonesie </option>
                        <option value="Iran">Iran </option>
                        <option value="Iraq">Iraq </option>
                        <option value="Irlande">Irlande </option>
                        <option value="Islande">Islande </option>
                        <option value="Israel">Israel </option>
                        <option value="Italie">italie </option>

                        <option value="Jamaique">Jamaique </option>
                        <option value="Jan Mayen">Jan Mayen </option>
                        <option value="Japon">Japon </option>
                        <option value="Jersey">Jersey </option>
                        <option value="Jordanie">Jordanie </option>

                        <option value="Kazakhstan">Kazakhstan </option>
                        <option value="Kenya">Kenya </option>
                        <option value="Kirghizstan">Kirghizistan </option>
                        <option value="Kiribati">Kiribati </option>
                        <option value="Koweit">Koweit </option>

                        <option value="Laos">Laos </option>
                        <option value="Lesotho">Lesotho </option>
                        <option value="Lettonie">Lettonie </option>
                        <option value="Liban">Liban </option>
                        <option value="Liberia">Liberia </option>
                        <option value="Liechtenstein">Liechtenstein </option>
                        <option value="Lituanie">Lituanie </option>
                        <option value="Luxembourg">Luxembourg </option>
                        <option value="Lybie">Lybie </option>

                        <option value="Macao">Macao </option>
                        <option value="Macedoine">Macedoine </option>
                        <option value="Madagascar">Madagascar </option>
                        <option value="Madère">Madère </option>
                        <option value="Malaisie">Malaisie </option>
                        <option value="Malawi">Malawi </option>
                        <option value="Maldives">Maldives </option>
                        <option value="Mali">Mali </option>
                        <option value="Malte">Malte </option>
                        <option value="Man">Man </option>
                        <option value="Mariannes du Nord">Mariannes du Nord </option>
                        <option value="Maroc">Maroc </option>
                        <option value="Marshall">Marshall </option>
                        <option value="Martinique">Martinique </option>
                        <option value="Maurice">Maurice </option>
                        <option value="Mauritanie">Mauritanie </option>
                        <option value="Mayotte">Mayotte </option>
                        <option value="Mexique">Mexique </option>
                        <option value="Micronesie">Micronesie </option>
                        <option value="Midway">Midway </option>
                        <option value="Moldavie">Moldavie </option>
                        <option value="Monaco">Monaco </option>
                        <option value="Mongolie">Mongolie </option>
                        <option value="Montserrat">Montserrat </option>
                        <option value="Mozambique">Mozambique </option>

                        <option value="Namibie">Namibie </option>
                        <option value="Nauru">Nauru </option>
                        <option value="Nepal">Nepal </option>
                        <option value="Nicaragua">Nicaragua </option>
                        <option value="Niger">Niger </option>
                        <option value="Nigeria">Nigeria </option>
                        <option value="Niue">Niue </option>
                        <option value="Norfolk">Norfolk </option>
                        <option value="Norvege">Norvege </option>
                        <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                        <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

                        <option value="Oman">Oman </option>
                        <option value="Ouganda">Ouganda </option>
                        <option value="Ouzbekistan">Ouzbekistan </option>

                        <option value="Pakistan">Pakistan </option>
                        <option value="Palau">Palau </option>
                        <option value="Palestine">Palestine </option>
                        <option value="Panama">Panama </option>
                        <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
                        <option value="Paraguay">Paraguay </option>
                        <option value="Pays_Bas">Pays_Bas </option>
                        <option value="Perou">Perou </option>
                        <option value="Philippines">Philippines </option>
                        <option value="Pologne">Pologne </option>
                        <option value="Polynesie">Polynesie </option>
                        <option value="Porto_Rico">Porto_Rico </option>
                        <option value="Portugal">Portugal </option>

                        <option value="Qatar">Qatar </option>

                        <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                        <option value="Republique_Tcheque">Republique_Tcheque </option>
                        <option value="Reunion">Reunion </option>
                        <option value="Roumanie">Roumanie </option>
                        <option value="Royaume_Uni">Royaume_Uni </option>
                        <option value="Russie">Russie </option>
                        <option value="Rwanda">Rwanda </option>

                        <option value="Sahara Occidental">Sahara Occidental </option>
                        <option value="Sainte_Lucie">Sainte_Lucie </option>
                        <option value="Saint_Marin">Saint_Marin </option>
                        <option value="Salomon">Salomon </option>
                        <option value="Salvador">Salvador </option>
                        <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                        <option value="Samoa_Americaine">Samoa_Americaine </option>
                        <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
                        <option value="Senegal">Senegal </option>
                        <option value="Seychelles">Seychelles </option>
                        <option value="Sierra Leone">Sierra Leone </option>
                        <option value="Singapour">Singapour </option>
                        <option value="Slovaquie">Slovaquie </option>
                        <option value="Slovenie">Slovenie</option>
                        <option value="Somalie">Somalie </option>
                        <option value="Soudan">Soudan </option>
                        <option value="Sri_Lanka">Sri_Lanka </option>
                        <option value="Suede">Suede </option>
                        <option value="Suisse">Suisse </option>
                        <option value="Surinam">Surinam </option>
                        <option value="Swaziland">Swaziland </option>
                        <option value="Syrie">Syrie </option>

                        <option value="Tadjikistan">Tadjikistan </option>
                        <option value="Taiwan">Taiwan </option>
                        <option value="Tonga">Tonga </option>
                        <option value="Tanzanie">Tanzanie </option>
                        <option value="Tchad">Tchad </option>
                        <option value="Thailande">Thailande </option>
                        <option value="Tibet">Tibet </option>
                        <option value="Timor_Oriental">Timor_Oriental </option>
                        <option value="Togo">Togo </option>
                        <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                        <option value="Tristan da cunha">Tristan de cuncha </option>
                        <option value="Tunisie">Tunisie </option>
                        <option value="Turkmenistan">Turmenistan </option>
                        <option value="Turquie">Turquie </option>

                        <option value="Ukraine">Ukraine </option>
                        <option value="Uruguay">Uruguay </option>

                        <option value="Vanuatu">Vanuatu </option>
                        <option value="Vatican">Vatican </option>
                        <option value="Venezuela">Venezuela </option>
                        <option value="Vierges_Americaines">Vierges_Americaines </option>
                        <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                        <option value="Vietnam">Vietnam </option>

                        <option value="Wake">Wake </option>
                        <option value="Wallis et Futuma">Wallis et Futuma </option>

                        <option value="Yemen">Yemen </option>
                        <option value="Yougoslavie">Yougoslavie </option>

                        <option value="Zambie">Zambie </option>
                        <option value="Zimbabwe">Zimbabwe </option>
                    </select>
                </div>
                <div class="formsubject">
                    <label for="subject">Subject</label>
                    <br>
                    <select name="subject" id="subject-select">
                         <option value="Other" selected="selected">Other</option>
                         <option value="Information">Information</option>
                         <option value="price">Price</option>
                         <option value="complaints">Complaints</option>
                    </select>
                </div>
             </div>
             <div class="thirthdline">
                <div class="formmessage">
                    <label for="message">Message</label>
                    <br>
                    <textarea name="message" value="Type your message here" rows="7" cols="50" required></textarea>
                </div>
             </div>
             <div class="fourthline">
                    <input type="submit" value="SUBMIT">
             </div>
          </div>
       </form>
   </div>
   </div>
</body>
</html>