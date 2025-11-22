<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>*{ padding: 0; margin: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;} strong{ font-size: 15px; text-decoration: underline;} strong, p{ margin: 10px 0;} span{ font-weight: 600; color: #36366b;} #desc{ text-align: center;} #desc, #subject{ margin-bottom: 18px;} </style>
</head>
<body>
  <section>
    <strong id="subject">Registration has been Successful.</strong>
    <br/><br/>
    <p><span>Login ID: {{$email}}</span></p>
    <p><span>Password: {{$password}}</span></p>
  
    <p>Password generated on - <span>{{date('d-m-y h:i:s')}}</span></p>

    <p>Your account is accessed from Location with IP - <span>{{$_SERVER['REMOTE_ADDR']}}</span></p>

    <p>Please do not reply to this message or mail address. For any queries please mail to <span>codingmodassir@gmail.com</span></p>

    <br/><br/><div id="desc"><strong>DISCLAMER</strong></div>
    <p>This communication is confidential and directed for the use of the addressee only. The recipient if not the addressee should not use this e-mail in any manner. The recipient acknowledges that fund collection may be unable to exercise control or ensure or guarantee the integrity of the email text and teh text is not warranted as to coompleteness and accuracy.</p>

    <br/><br/>
    <div><span>Regards,</span></div>
    <div>Mosque Fund Collection Developer</div>
  </section>
</body>
</html>