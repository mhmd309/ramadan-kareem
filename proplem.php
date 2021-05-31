<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $mail       = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $text       = filter_var($_POST['subtext'], FILTER_SANITIZE_STRING);
    $msg        = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    $formError = array();

    if (strlen($user) < '3') {

        $formError[] = 'إسمك ليس صحيحا';
    }

    if (strlen($mail) == '') {

        $formError[] = 'لا تترك البريد فارغا';
    }

    if (strlen($text) == '') {

        $formError[] = 'اكتب الموضوع الذي تريد الاستفسار عنه';
    }

    if (strlen($msg) < 20) {

        $formError[] = 'الرساله النصيه لا تقل عن 20 حرف';
    }

    $myEmail    = 'ramadankareem4400@gmail.com';

    if (empty($formError)) {

        mail($myEmail, $mail, $text, $msg);

        $user     = '';
        $mail     = '';
        $text     = '';
        $msg      = '';

        $success  = '<div class="alert alert-success">تم إستلام رسالتك بنجاح وسنتواصل معك ف أقرب وقت</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Start Fonts-->
    <link rel="shortcut icon" href="img/icon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Yeon+Sung&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lateef&display=swap" />
    <link rel="stylesheet" href="css/all.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/media.css" />
    <title>تواصل معنا | رمضان كريم</title>
</head>

<body>
    <!-- Start Back Home -->
    <span class="bakhome">
        <a href="index.html">الصفحه الرئيسيه<i class="fas fa-angle-double-right fa-fw"></i></a>
    </span>
    <!-- End Back Home -->
    <!-- Start Form Contact -->
    <div class="form-contact">
        <div class="overlay"></div>
        <div class="container">
            <div class="info text-center">
                <img src="img/icon.png" class="img-responsive" />
                <h1>يسعدنا تواصلك معنا</h1>
                <p>كل عام وأنتم إلى الله أقرب</p>
                <?php if (!empty($formError)) { ?>
                    <div class="error">
                        <?php
                        foreach ($formError as $error) {
                            echo $error . '<br/>';
                        }
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($success)) {
                    echo $success;
                } ?>
            </div>
            <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <i class="far fa-user fa-fw"></i>
                <div class="form-group">
                    <input class="form-control" type="text" name="username" placeholder="إسمك" autocomplete="off" value="<?php if (isset($user)) {
                                                                                                                                echo $user;
                                                                                                                            } ?>" />
                    <span class="asterisx">*</span>
                </div>
                <i class="far fa-envelope-open fa-fw"></i>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="إيميلك" autocomplete="off" value="<?php if (isset($mail)) {
                                                                                                                                echo $mail;
                                                                                                                            } ?>" />
                    <span class="asterisx">*</span>
                </div>
                <i class="fas fa-pen-alt fa-fw"></i>
                <div class="form-group">
                    <input class="form-control" type="text" name="subtext" placeholder="اكتب الموضوع" autocomplete="off" value="<?php if (isset($text)) {
                                                                                                                                    echo $text;
                                                                                                                                } ?>" />
                    <span class="asterisx">*</span>
                </div>
                <i class="far fa-comments fa-fw"></i>
                <div class="form-group">
                    <textarea id="textarea" class="form-control" placeholder="الرساله النصيه" maxlength="500" name="message" value="<?php if (isset($msg)) {
                                                                                                                                        echo $msg;
                                                                                                                                    } ?>"></textarea>
                    <span class="asterisx">*</span>
                </div>
                <input class="btn btn-success" type="submit" value="إرسال" />
            </form>
        </div>
    </div>
    <!-- End Form Contact -->
    <!-- Start Footer -->
    <div class="footer text-center">
        <div class="container">
            <h2>جميع الحقوق محفوظه &copy;2021 لدى <strong>موقع رمضان كريم</strong></h2>
            <p>بكل فخر تصميم وبرمجه <a href="http://mohamedemara.eb2a.com/" target="_blank">#Mohamed_Emara</a></p>
        </div>
    </div>
    <!-- End Footer -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>