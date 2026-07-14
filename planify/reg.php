<?php
session_start();
include '../Db/connection.php';

if (isset($_POST['reg'])) {
    // 1. Sanitize inputs to prevent SQL Injection
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    $role = 'user';

    // 2. Backend Validation: Check for Duplicate Email, Phone, OR Username
    $checkQuery = "SELECT * FROM user_tb WHERE email='$email' OR phone='$phone' OR name='$name'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Fetch row to see which one matched to give a specific error
        $row = mysqli_fetch_assoc($checkResult);
        if ($row['email'] == $email) {
            echo "<script>alert('This Email is already registered!');</script>";
        } elseif ($row['phone'] == $phone) {
            echo "<script>alert('This Phone Number is already registered!');</script>";
        } elseif ($row['name'] == $name) {
            echo "<script>alert('This Username is already taken!');</script>";
        }
    } else {
        // 3. Password Match Check
        if ($password == $cpassword) {
            $query = "INSERT INTO user_tb(name, phone, email, password, role) VALUES ('$name', '$phone', '$email', '$password', '$role')";
            $insert = mysqli_query($con, $query);
            if ($insert) {
                echo "<script>alert('Successfully Registered. Please Log In.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Registration Failed. Database Error.');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match');</script>";
        }
    }
}

if (isset($_POST['log'])) {
    // Capture input (can be username or email)
    $input_user = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // UPDATED QUERY: Check if 'name' matches OR 'email' matches the input
    $query = "SELECT * FROM user_tb WHERE (name='$input_user' OR email='$input_user') AND password='$password'";
    $que = mysqli_query($con, $query);

    if (mysqli_num_rows($que) > 0) {
        $i = mysqli_fetch_assoc($que);
        $_SESSION['id'] = $i['id'];
        $_SESSION['name'] = $i['name'];
        $_SESSION['role'] = $i['role'];
        $_SESSION['is_loggin'] = True;

        echo "<script>alert('Successful Login..');</script>";

        // Admin Redirection
        if ($i['role'] == 'admin') {
            echo "<script>window.location.href='../admin/html/minisidebar/index.php';</script>";
        } else {
            echo "<script>window.location.href='index.php';</script>"; // Redirect user
        }
    } else {
        echo "<script>alert('Incorrect username/email or password. Try Again!!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planify Login</title>
</head>
<body>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        :root {
            --brand-color-1: #1c6663;
            --brand-color-2: #053d48;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Roboto";
        }

        .outer-container {
            background-color: var(--brand-color-2);
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: var(--brand-color-1);
            width: 600px;
            height: 320px;
            display: flex;
            position: relative;
        }
        
        .container .form-container {
            margin-left: 25px;
            background-color: white;
            height: 380px;
            width: 305px;
            align-self: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: absolute;
            transition: margin-left 1.5s;
            z-index: 10;
        }

        .container .form-container.active {
            margin-left: 275px;
        }

        .fire {
            top: -75px;
            position: absolute;
            z-index: 0;
        }

        .fire svg {
            width: 300px;
            height: auto;
            visibility: hidden;
        }

        .form-item form {
            z-index: 2;
            position: relative;
        }

        .form-item form.form-sign-up {
            margin-top: 30px;
            display: none;
        }

        .form-item input {
            display: block;
            padding: 10px;
            width: 250px;
            margin-top: 5px;
            margin-bottom: 10px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .form-item .btn {
            cursor: pointer;
            display: block;
            padding: 10px;
            width: 250px;
            margin: 5px;
            text-align: center;
            border: 2px solid var(--brand-color-1);
            background-color: var(--brand-color-1);
            color: white;
            opacity: 1;
        }

        .form-item .btn:hover {
            opacity: 0.7;
        }

        .info-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            position: relative;
        }

        .info-item {
            color: white;
            display: flex;
            align-content: center;
            align-items: center;
            flex-direction: column;
            font-weight: 500;
            font-size: 20px;
            position: relative;
            z-index: 1;
        }

        .log-in {
            text-align: center;
            margin-right: 40px;
        }

        .sign-up {
            margin-left: 40px;
            text-align: center;
        }

        .info-container .btn {
            cursor: pointer;
            background-color: transparent;
            width: 60px;
            padding: 10px 15px;
            border: 1px solid white;
            font-size: 16px;
            opacity: 1;
        }

        .info-container .btn:hover {
            opacity: 0.7;
        }

        .tree {
            height: auto;
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 0;
            bottom: 30px;
        }

        .leaves {
            z-index: 1;
            animation-delay: 0.5s;
            animation-duration: 1s;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 100px 100px 100px;
            border-radius: 30%;
            border-color: transparent transparent #6b8e23 transparent;
            position: relative;
            bottom: 40px;
        }

        .leaves:before {
            content: " ";
            border-style: solid;
            border-width: 0 65px 100px 65px;
            border-radius: 30%;
            border-color: transparent transparent #6b8e23 transparent;
            position: absolute;
            left: -65px;
            top: -100px;
        }

        .leaves:after {
            content: " ";
            border-style: solid;
            border-width: 0 85px 100px 85px;
            border-radius: 30%;
            border-color: transparent transparent #6b8e23 transparent;
            position: absolute;
            left: -85px;
            top: -50px;
        }

        .trunk {
            z-index: 0;
            width: 100px;
            height: 50px;
            background-color: #8b4513;
            position: absolute;
            bottom: 0px;
        }
    </style>

    <div class="outer-container">
        <div class="container">
            <div class="info-container">
                <div class="info-item log-in">
                    <p>Have an account?</p>
                    <div class="btn">Log In</div>
                </div>
                <div class="tree">
                    <div class="leaves"></div>
                    <div class="trunk"></div>
                </div>
                <div class="info-item sign-up">
                    <p>Don't have an account?</p>
                    <div class="btn">Sign Up</div>
                </div>
            </div>
            <div class="form-container">
                <div class="form-item">
                    <div class="fire">
                        <svg class="flameSVG" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <rect class="flame" x="400" y="310" width="5" height="5" rx="0.5" ry="0.5" fill="#FFDD02" />
                                <circle class="spark" cx="400" cy="300" r="0.05" fill="#FFDD02" />
                                <filter id="shadow" x="-100%" y="-100%" width="250%" height="250%">
                                    <feOffset in="SourceAlpha" dx="4" dy="4" result="offsetOut"></feOffset>
                                    <feGaussianBlur stdDeviation="3" in="offsetOut" result="drop" />
                                    <feOffset dx="0" dy="0" result="offsetblur"></feOffset>
                                    <feFlood id="glowAlpha" flood-color="#0F1217" flood-opacity="0.42"></feFlood>
                                    <feComposite in2="offsetblur" operator="in"></feComposite>
                                    <feMerge>
                                        <feMergeNode />
                                        <feMergeNode in="SourceGraphic"></feMergeNode>
                                    </feMerge>
                                </filter>
                            </defs>
                            <g class="whole">
                                <g class="flameContainer" />
                                <g class="sparksContainer" />
                                <g class="logs" opacity="1">
                                    <path d="M446.68,299.63l-91.46,29.22a3,3,0,0,1-3.68-2.12L349.2,318a3,3,0,0,1,2.12-3.68l91.46-29.22a3,3,0,0,1,3.68,2.12L448.8,296A3,3,0,0,1,446.68,299.63Z" fill="#612e25" />
                                    <path filter="url(#shadow)" d="M349.2,296l2.34-8.69a3,3,0,0,1,3.68-2.12l91.46,29.22A3,3,0,0,1,448.8,318l-2.34,8.69a3,3,0,0,1-3.68,2.12l-91.46-29.22A3,3,0,0,1,349.2,296Z" fill="#70392f" />
                                </g>
                            </g>
                            <rect class="hit" width="200" height="260" x="300" y="230" fill="transparent"></rect>
                        </svg>
                    </div>

                    <form class="form-log-in animated" method="post">
                        <input name="name" placeholder="Username or Email" type="text" required />
                        <input name="password" placeholder="Password" type="Password" required />
                        <button class="btn" type="submit" name="log">Log in</button>
                        <a href="forgot_password.php">Forgot Password</a>
                    </form>

                    <form class="form-sign-up animated" method="post" onsubmit="return validateSignUp()">
                        <input name="name" id="reg_name" placeholder="Username" type="text" required />
                        <input name="email" id="reg_email" placeholder="Email" type="email" required />
                        <input name="phone" id="reg_phone" placeholder="Phone Number (10 digits)" type="tel" required />
                        <input name="password" id="reg_pass" placeholder="Password (Min 6 chars)" type="Password" required />
                        <input name="cpassword" id="reg_cpass" placeholder="Confirm Password" type="Password" required />

                        <button class="btn" type="submit" name="reg">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/EasePack.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/CustomEase.min.js"></script>

    <script>
        // FRONTEND VALIDATION SCRIPT
        function validateSignUp() {
            var phone = document.getElementById('reg_phone').value;
            var email = document.getElementById('reg_email').value;
            var pass = document.getElementById('reg_pass').value;
            var cpass = document.getElementById('reg_cpass').value;

            // 1. Phone Number Validation (Must be 10 digits)
            var phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                alert('Please enter a valid 10-digit phone number.');
                return false;
            }

            // 2. Email Validation (Standard RegEx)
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            // 3. Password Length Validation
            if (pass.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }

            // 4. Confirm Password Validation
            if (pass !== cpass) {
                alert('Passwords do not match!');
                return false;
            }

            return true;
        }

        // ANIMATION SCRIPTS
        $(document).ready(function() {
            let isLoginVisible = true;

            $(".log-in .btn").click(function() {
                if (!isLoginVisible) {
                    $(".form-container").removeClass("active");
                    $(".form-sign-up").fadeOut(300, function() {
                        $(".form-log-in").fadeIn(300);
                    });
                    isLoginVisible = true;
                    animateLeaves();
                }
            });

            $(".sign-up .btn").click(function() {
                if (isLoginVisible) {
                    $(".form-container").addClass("active");
                    $(".form-log-in").fadeOut(300, function() {
                        $(".form-sign-up").fadeIn(300);
                    });
                    isLoginVisible = false;
                    animateLeaves();
                }
            });

            function animateLeaves() {
                $(".leaves").addClass("animated tada").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    $(this).removeClass("animated tada");
                });
            }
        });

        // FIRE ANIMATION
        var xmlns = "http://www.w3.org/2000/svg",
            xlinkns = "http://www.w3.org/1999/xlink",
            select = function(s) {
                return document.querySelector(s);
            },
            selectAll = function(s) {
                return document.querySelectorAll(s);
            },
            flameContainer = select('.flameContainer'),
            sparksContainer = select('.sparksContainer'),
            flameSVG = select('.flameSVG'),
            flamePosXArr = [10, -10],
            flameOffset = 0.34,
            sparkOffset = 0.72,
            numFlames = 50

        CustomEase.create("return", "M0,0 C0,0 0.162,1 0.4,1 0.918,1 1,0 1,0");
        CustomEase.create("sparkFlicker", "M0,0 C0.126,0.382 0.216,0.572 0.414,0.482 0.821,0.296 0.984,0.94 1,1");
        CustomEase.create("flameJump", "M0,0 C0.126,0.382 0.256,0.248 0.406,0.23 0.85,0.176 0.984,0.94 1,1");
        TweenMax.set('svg', {
            visibility: 'visible'
        })
        TweenMax.set('.whole', {
            scale: 1.52,
            transformOrigin: '50% -500%'
        })
        var mainTl = new TimelineMax({});
        var flameTl = new TimelineMax({
            repeat: 0
        });

        function createFlames() {
            for (var i = 0; i < numFlames; i++) {
                var f = select('.flame').cloneNode(true);
                flameContainer.appendChild(f);
                TweenMax.set(f, {
                    x: (i % 2) ? flamePosXArr[0] : flamePosXArr[1],
                    transformOrigin: '50% 50%',
                    rotation: -45
                })
                var fTl = new TimelineMax({
                    repeat: -1,
                    repeatDelay: ((numFlames - 1) * flameOffset) - 2
                });
                fTl.to(f, 2, {
                        x: (i % 2) ? '-=22' : '+=22',
                        scale: 10,
                        ease: 'return'
                    })
                    .to(f, 2, {
                        y: -145,
                        ease: 'flameJump'
                    }, '-=2')
                    .to(f, 2, {
                        fill: '#F73B01',
                        ease: Sine.easeOut
                    }, '-=2')
                    .to(f, 2, {
                        alpha: 0,
                        ease: Expo.easeIn
                    }, '-=2')

                flameTl.add(fTl, i * flameOffset);
                var s = select('.spark').cloneNode(true);
                sparksContainer.appendChild(s);
                TweenMax.set(s, {
                    x: (i % 3) ? flamePosXArr[1] : flamePosXArr[0],
                    transformOrigin: '50% 50%'
                })
            }
        }
        createFlames();

        var sparkTl = new TimelineMax({
            repeat: -1
        });

        sparkTl.staggerTo('.spark', 2, {
                cycle: {
                    x: ['-=25', '+=15', 0, '+=23', '-=5', '+=71', '-=54'],
                    scale: function() {
                        return Math.random() * 23
                    }
                },
                ease: 'return'
            }, sparkOffset)
            .staggerTo('.spark', 3, {
                cycle: {
                    ease: [SlowMo.ease.config(0.2, 0.2), 'sparkFlicker', SlowMo.ease.config(0.42, 0.52)],
                    y: function() {
                        return -(Math.random() * 200) - 200
                    }
                }

            }, sparkOffset, '-=' + sparkTl.duration())
            .staggerTo('.spark', 3, {
                cycle: {
                    fill: ['#F36B01', '#FDBB01', '#ededed']
                },
                ease: Sine.easeIn
            }, sparkOffset, '-=' + sparkTl.duration())
            .staggerTo('.spark', 3, {
                alpha: 0,
                ease: Expo.easeIn
            }, sparkOffset, '-=' + sparkTl.duration())

        sparkTl.timeScale(1)
        mainTl.add(flameTl, 0);
        mainTl.add(sparkTl, 0);
        mainTl.timeScale(1.2).seek(97);

        function pokeFire() {
            resetSparks();
            var pokeTl = new TimelineMax({
                onComplete: function() {
                    resetSparks();
                    sparkTl.play(99)
                }
            }).timeScale(2)
            pokeTl.staggerTo('.logs path', 0.7, {
                    cycle: {
                        rotation: [3, -3],
                        transformOrigin: ['2% 100%', '98% 100%']
                    },
                    ease: 'return'
                }, 0.02)
                .to(flameContainer, 0.7, {
                    scaleY: 0.8,
                    transformOrigin: '50% 100%',
                    ease: 'return'
                }, '-=' + pokeTl.duration())
                .staggerTo('.spark', 3, {
                    cycle: {
                        x: ['-=25', '+=15', 0, '+=23', '-=5', '+=71', '-=54'],
                        scale: function() {
                            return (Math.random() * 30)
                        }
                    },
                    ease: 'return'
                }, 0.07, '-=1.2')
                .staggerTo('.spark', 3, {
                    cycle: {
                        ease: [SlowMo.ease.config(0.2, 0.2), 'sparkFlicker', SlowMo.ease.config(0.42, 0.52)],
                        y: function() {
                            return -(Math.random() * 200) - 200
                        }
                    }
                }, 0.07, '-=' + pokeTl.duration())
                .staggerTo('.spark', 3, {
                    cycle: {
                        fill: ['#F36B01', '#FDBB01']
                    },
                    ease: Sine.easeIn
                }, 0.07, '-=' + pokeTl.duration())
                .staggerTo('.spark', 3, {
                    alpha: 0,
                    ease: Expo.easeIn
                }, 0.07, '-=' + pokeTl.duration())
        }

        function resetSparks() {
            TweenMax.staggerTo('.spark', 0, {
                cycle: {
                    x: function(i) {
                        return (i % 3) ? flamePosXArr[1] : flamePosXArr[0]
                    }
                },
                y: 0,
                alpha: 1,
                scale: 1
            }, 0)
        }

        flameSVG.onclick = pokeFire;
    </script>
</body>
</html>